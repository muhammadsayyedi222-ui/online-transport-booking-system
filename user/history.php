<?php require_once __DIR__ . "/../db.php"; ?>
<?php if(!isset($_SESSION['user'])){ header('Location: /transport_booking/login.php'); exit; } ?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>My Bookings</title><link rel="stylesheet" href="../assets/style.css"></head>
<body>
<?php include __DIR__ . '/../includes/header.php'; ?>
<div class="container">
  <h2>My Bookings</h2>
  <?php
  $uid = $_SESSION['user']['id'];
  $stmt = $conn->prepare("SELECT b.*, t.depart_date, t.depart_time, r.origin, r.destination FROM bookings b JOIN trips t ON b.trip_id=t.id JOIN routes r ON t.route_id=r.id WHERE b.user_id=? ORDER BY b.booked_at DESC");
  $stmt->bind_param('i',$uid); $stmt->execute(); $res = $stmt->get_result();
  if ($res->num_rows==0) echo '<div class="alert">No bookings yet.</div>';
  else {
    echo '<table class="table"><thead><tr><th>Route</th><th>Date</th><th>Seats</th><th>Amount</th><th>Status</th></tr></thead><tbody>';
    while($r = $res->fetch_assoc()){
      echo '<tr><td>'.e($r['origin'].' → '.$r['destination']).'</td><td>'.e($r['depart_date'].' '.substr($r['depart_time'],0,5)).'</td><td>'.e($r['seats']).'</td><td>₦'.number_format($r['amount'],2).'</td><td>'.e($r['status']).'</td></tr>';
    }
    echo '</tbody></table>';
  }
  ?>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
