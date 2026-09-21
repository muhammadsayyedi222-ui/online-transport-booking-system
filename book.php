<?php require_once __DIR__ . "/db.php"; ?>
<?php
if (!isset($_SESSION['user'])) { header('Location: login.php'); exit; }
$trip_id = intval($_GET['trip_id'] ?? 0);
if (!$trip_id) die('Invalid trip.');
$stmt = $conn->prepare("SELECT trips.*, routes.price, routes.origin, routes.destination, vehicles.type FROM trips JOIN routes ON trips.route_id=routes.id JOIN vehicles ON trips.vehicle_id=vehicles.id WHERE trips.id=?");
$stmt->bind_param('i',$trip_id); $stmt->execute(); $trip = $stmt->get_result()->fetch_assoc();
if (!$trip) die('Trip not found.');
$msg='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
  $seats = max(1,intval($_POST['seats'] ?? 1));
  $conn->begin_transaction();
  try {
    $stmt = $conn->prepare("SELECT seats_available FROM trips WHERE id=? FOR UPDATE");
    $stmt->bind_param('i',$trip_id); $stmt->execute(); $cur = $stmt->get_result()->fetch_assoc();
    if (!$cur || $cur['seats_available'] < $seats) throw new Exception('Not enough seats.');
    $new = $cur['seats_available'] - $seats;
    $u = $conn->prepare("UPDATE trips SET seats_available=? WHERE id=?"); $u->bind_param('ii',$new,$trip_id); $u->execute();
    $amount = $seats * floatval($trip['price']);
    $ins = $conn->prepare("INSERT INTO bookings (user_id, trip_id, seats, amount) VALUES (?,?,?,?)"); $uid = $_SESSION['user']['id'];
    $ins->bind_param('iiid',$uid,$trip_id,$seats,$amount); $ins->execute();

$booking_id = $ins->insert_id;
$conn->commit();
// Send booking confirmation email (simple PHP mail)
$to = isset($_SESSION['user']['email']) ? $_SESSION['user']['email'] : '';
$name = isset($_SESSION['user']['name']) ? $_SESSION['user']['name'] : 'Passenger';
$subject = 'Booking Confirmation - GIGM';
$message = "Dear $name,\n\nYour booking has been confirmed.\n\nRoute: " . e($trip['origin']) . " → " . e($trip['destination']) . "\nDate: " . e($trip['depart_date']) . "\nTime: " . substr(e($trip['depart_time']),0,5) . "\nSeats: " . $seats . "\nAmount: ₦" . number_format($amount,2) . "\nBooking ID: " . $booking_id . "\n\nThank you for choosing GIGM.";
$headers = "From: noreply@gigm.com\r\nReply-To: noreply@gigm.com\r\nX-Mailer: PHP/" . phpversion();
@mail($to, $subject, $message, $headers);
header('Location: payment_mock.php?booking_id=' . $booking_id);
exit;

  } catch(Exception $e) {
    $conn->rollback();
    $msg = $e->getMessage();
  }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Book</title><link rel="stylesheet" href="assets/style.css"></head>
<body>
<?php include __DIR__ . '/includes/header.php'; ?>
<div class="container" style="max-width:520px;">
  <h2>Book Trip</h2>
  <?php if($msg) echo '<div class="alert">'.e($msg).'</div>'; ?>
  <p><strong>Route:</strong> <?php echo e($trip['origin'].' → '.$trip['destination']); ?></p>
  <p><strong>Date/Time:</strong> <?php echo e($trip['depart_date'].' '.substr($trip['depart_time'],0,5)); ?></p>
  <p><strong>Vehicle:</strong> <?php echo e($trip['type']); ?> | <strong>Price:</strong> ₦<?php echo number_format($trip['price'],2); ?></p>
  <form method="post">
    <label>Seats</label>
    <input type="number" name="seats" min="1" max="<?php echo e($trip['seats_available']); ?>" value="1" required>
    <button class="btn" type="submit">Confirm Booking</button>
  </form>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
