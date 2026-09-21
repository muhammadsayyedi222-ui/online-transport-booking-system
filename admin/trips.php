<?php require_once __DIR__ . '/../db.php'; if(!isset($_SESSION['user'])||$_SESSION['user']['role']!=='admin'){ header('Location: login.php'); exit; }
if($_SERVER['REQUEST_METHOD']==='POST'){
  if(isset($_POST['add'])){
    $route_id=intval($_POST['route_id']); $vehicle_id=intval($_POST['vehicle_id']);
    $depart_date=$_POST['depart_date']; $depart_time=$_POST['depart_time']; $seats=intval($_POST['seats_total']);
    $s = $conn->prepare('INSERT INTO trips (route_id,vehicle_id,depart_date,depart_time,seats_total,seats_available) VALUES (?,?,?,?,?,?)'); $s->bind_param('issiii',$route_id,$vehicle_id,$depart_date,$depart_time,$seats,$seats); $s->execute();
  } elseif(isset($_POST['delete'])){
    $id=intval($_POST['id']); $s=$conn->prepare('DELETE FROM trips WHERE id=?'); $s->bind_param('i',$id); $s->execute();
  }
}
$routes = $conn->query('SELECT * FROM routes')->fetch_all(MYSQLI_ASSOC);
$vehicles = $conn->query('SELECT * FROM vehicles')->fetch_all(MYSQLI_ASSOC);
$rows = $conn->query('SELECT trips.*, routes.origin, routes.destination, vehicles.type FROM trips JOIN routes ON trips.route_id=routes.id JOIN vehicles ON trips.vehicle_id=vehicles.id ORDER BY depart_date DESC')->fetch_all(MYSQLI_ASSOC);
?><!doctype html><html><head><meta charset="utf-8"><title>Trips</title><link rel="stylesheet" href="../assets/style.css"></head><body><?php include __DIR__.'/../includes/header.php'; ?>
<div class="container"><h2>Trips</h2>
<form method="post"><label>Route</label><select name="route_id"><?php foreach($routes as $r) echo '<option value="'.$r['id'].'">'.e($r['origin'].' → '.$r['destination']).'</option>'; ?></select>
<label>Vehicle</label><select name="vehicle_id"><?php foreach($vehicles as $v) echo '<option value="'.$v['id'].'">'.e($v['type'].' ('.$v['plate_no'].')').'</option>'; ?></select>
<label>Depart Date</label><input type="date" name="depart_date" required><label>Depart Time</label><input type="time" name="depart_time" required><label>Seats Total</label><input type="number" name="seats_total" min="1" required><button class="btn" name="add">Add Trip</button></form>
<table class="table"><thead><tr><th>#</th><th>Route</th><th>Date</th><th>Time</th><th>Vehicle</th><th>Seats</th><th></th></tr></thead><tbody><?php foreach($rows as $r): ?><tr><td><?php echo $r['id']; ?></td><td><?php echo e($r['origin'].' → '.$r['destination']); ?></td><td><?php echo e($r['depart_date']); ?></td><td><?php echo e(substr($r['depart_time'],0,5)); ?></td><td><?php echo e($r['type']); ?></td><td><?php echo e($r['seats_available']); ?></td><td><form method='post' onsubmit='return confirm("Delete?");'><input type='hidden' name='id' value='<?php echo $r['id']; ?>'><button class='btn btn' name='delete'>Delete</button></form></td></tr><?php endforeach; ?></tbody></table>
</div><?php include __DIR__.'/../includes/footer.php'; ?></body></html>
