
<?php
require_once __DIR__ . '/db.php';
session_start();
$booking_id = isset($_GET['booking_id']) ? intval($_GET['booking_id']) : 0;
if (!$booking_id) { echo '<p>Invalid booking.</p>'; exit; }
$stmt = $conn->prepare('SELECT b.*, t.depart_date, t.depart_time, r.origin, r.destination FROM bookings b JOIN trips t ON b.trip_id=t.id JOIN routes r ON t.route_id=r.id WHERE b.id=? LIMIT 1');
$stmt->bind_param('i', $booking_id);
$stmt->execute();
$bk = $stmt->get_result()->fetch_assoc();
if (!$bk) { echo '<p>Booking not found.</p>'; exit; }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Payment Success</title><link rel="stylesheet" href="assets/style.css"></head><body><div class="container"><h2>Payment Successful</h2><p>Your payment for booking ID '.htmlspecialchars($booking_id).' was successful (demo).</p><p><a class="btn" href="booking.php">Back to Trips</a></p></div></body></html>';
    exit;
}
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Mock Payment</title><link rel="stylesheet" href="assets/style.css"></head>
<body>
<?php include __DIR__ . '/includes/header.php'; ?>
<div class="container" style="max-width:600px;margin-top:40px;text-align:left;">
<h2>Mock Payment for Booking ID: <?php echo htmlspecialchars($booking_id); ?></h2>
<p><strong>Passenger (user id):</strong> <?php echo htmlspecialchars($bk['user_id']); ?></p>
<p><strong>Route:</strong> <?php echo htmlspecialchars($bk['origin'] . ' → ' . $bk['destination']); ?></p>
<p><strong>Date/Time:</strong> <?php echo htmlspecialchars($bk['depart_date'] . ' ' . substr($bk['depart_time'],0,5)); ?></p>
<p><strong>Seats:</strong> <?php echo htmlspecialchars($bk['seats']); ?></p>
<p><strong>Amount:</strong> ₦<?php echo number_format($bk['amount'],2); ?></p>
<form method="post">
    <label>Card Number (demo)</label>
    <input name="card" required>
    <label>Expiry</label>
    <input name="exp" required>
    <label>CVV</label>
    <input name="cvv" required>
    <button class="btn" type="submit">Pay Now (Demo)</button>
</form>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
