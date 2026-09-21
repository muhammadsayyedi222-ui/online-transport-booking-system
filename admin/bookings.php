<?php require_once __DIR__ . '/../db.php'; if(!isset($_SESSION['user'])||$_SESSION['user']['role']!=='admin'){ header('Location: login.php'); exit; }
$res = $conn->query('SELECT b.*, u.name as uname, r.origin, r.destination, t.depart_date, t.depart_time FROM bookings b JOIN users u ON b.user_id=u.id JOIN trips t ON b.trip_id=t.id JOIN routes r ON t.route_id=r.id ORDER BY b.booked_at DESC');
?><!doctype html><html><head><meta charset="utf-8"><title>Bookings</title><link rel="stylesheet" href="../assets/style.css"></head><body><?php include __DIR__.'/../includes/header.php'; ?>
<div class="container"><h2>All Bookings</h2>
<?php if($res->num_rows==0) echo '<div class="alert">No bookings yet</div>'; else { ?>
<table class="table"><thead><tr><th>ID</th><th>User</th><th>Route</th><th>Date</th><th>Seats</th><th>Amount</th><th>Booked At</th></tr></thead><tbody><?php while($r=$res->fetch_assoc()): ?><tr><td><?php echo $r['id']; ?></td><td><?php echo e($r['uname']); ?></td><td><?php echo e($r['origin'].' → '.$r['destination']); ?></td><td><?php echo e($r['depart_date'].' '.substr($r['depart_time'],0,5)); ?></td><td><?php echo e($r['seats']); ?></td><td>₦<?php echo number_format($r['amount'],2); ?></td><td><?php echo e($r['booked_at']); ?></td></tr><?php endwhile; ?></tbody></table><?php } ?>
</div><?php include __DIR__.'/../includes/footer.php'; ?></body></html>
