<?php require_once __DIR__ . '/../db.php'; if(!isset($_SESSION['user']) || $_SESSION['user']['role']!=='admin'){ header('Location: login.php'); exit; } ?>
<!doctype html><html><head><meta charset="utf-8"><title>Admin</title><link rel="stylesheet" href="../assets/style.css"></head><body>
<?php include __DIR__ . '/../includes/header.php'; ?>
<div class="container">
  <h2>Admin Dashboard</h2>
  <div><a class="btn" href="routes.php">Manage Routes</a> <a class="btn" href="vehicles.php">Manage Vehicles</a> <a class="btn" href="trips.php">Manage Trips</a> <a class="btn btn" href="bookings.php">View Bookings</a></div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
</body></html>
