<?php require_once __DIR__ . "/db.php"; ?>
<?php
if (!isset($_SESSION['user'])) { header('Location: login.php'); exit; }
$trips = [];
$q = "SELECT trips.id, routes.origin, routes.destination, trips.depart_date, trips.depart_time, trips.seats_available, routes.price, vehicles.type
      FROM trips JOIN routes ON trips.route_id = routes.id JOIN vehicles ON trips.vehicle_id = vehicles.id
      WHERE trips.depart_date >= CURDATE() ORDER BY trips.depart_date, trips.depart_time LIMIT 50";
$res = $conn->query($q);
if ($res) $trips = $res->fetch_all(MYSQLI_ASSOC);
$msg = $_GET['msg'] ?? '';
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Book Trip</title><link rel="stylesheet" href="assets/style.css"></head>
<body>
<?php include __DIR__ . "/includes/header.php"; ?>
<div class="container">
  <h2>Available Trips</h2>
  <?php if($msg) echo '<div class="alert">'.e($msg).'</div>'; ?>
  <?php if(!$trips): ?>
    <div class="alert">No trips available. Admin can add trips in admin panel.</div>
  <?php else: ?>
    <table class="table">
      <thead><tr><th>Route</th><th>Date</th><th>Time</th><th>Vehicle</th><th>Seats</th><th>Price</th><th></th></tr></thead>
      <tbody>
        <?php foreach($trips as $t): ?>
        <tr>
          <td><?php echo e($t['origin'] . ' → ' . $t['destination']); ?></td>
          <td><?php echo e($t['depart_date']); ?></td>
          <td><?php echo e(substr($t['depart_time'],0,5)); ?></td>
          <td><?php echo e($t['type']); ?></td>
          <td><?php echo e($t['seats_available']); ?></td>
          <td>₦<?php echo number_format($t['price'],2); ?></td>
          <td><?php if($t['seats_available']>0) echo '<a class="btn" href="book.php?trip_id='.$t['id'].'">Book</a>'; else echo 'Sold out'; ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>
<?php include __DIR__ . "/includes/footer.php"; ?>
</body>
</html>
