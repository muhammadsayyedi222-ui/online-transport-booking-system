<?php require_once __DIR__ . '/../db.php'; if(!isset($_SESSION['user'])||$_SESSION['user']['role']!=='admin'){ header('Location: login.php'); exit; }
if($_SERVER['REQUEST_METHOD']==='POST'){
  if(isset($_POST['add'])){
    $t=$_POST['type']; $pl=$_POST['plate_no']; $cap=intval($_POST['capacity']);
    $s = $conn->prepare('INSERT INTO vehicles (type,plate_no,capacity) VALUES (?,?,?)'); $s->bind_param('ssi',$t,$pl,$cap); $s->execute();
  } elseif(isset($_POST['delete'])){
    $id=intval($_POST['id']); $s=$conn->prepare('DELETE FROM vehicles WHERE id=?'); $s->bind_param('i',$id); $s->execute();
  }
}
$rows = $conn->query('SELECT * FROM vehicles ORDER BY id DESC')->fetch_all(MYSQLI_ASSOC); $bus_type = ['Toyota Hiace','Coaster','Luxury Bus','Mini Bus','Mazda','SUV']; ?>
?><!doctype html><html><head><meta charset="utf-8"><title>Vehicles</title><link rel="stylesheet" href="../assets/style.css"></head><body><?php include __DIR__.'/../includes/header.php'; ?>
<div class="container"><h2>Vehicles</h2>
<form method="post"><label>Type</label><select name="type" required><option value="">--select bus type--</option><?php foreach($bus_type as $type): ?><option value="<?php echo htmlspecialchars($type); ?>"><?php echo htmlspecialchars($type); ?></option><?php endforeach; ?></select><label>Plate No</label><input name="plate_no" required><label>Capacity</label><input name="capacity" type="number" min="1" required><button class="btn" name="add">Add</button></form>
<table class="table"><thead><tr><th>#</th><th>Type</th><th>Plate</th><th>Capacity</th><th></th></tr></thead><tbody><?php foreach($rows as $r): ?>
<tr><td><?php echo $r['id']; ?></td><td><?php echo e($r['type']); ?></td><td><?php echo e($r['plate_no']); ?></td><td><?php echo e($r['capacity']); ?></td><td><form method="post" onsubmit="return confirm('Delete?');"><input type="hidden" name="id" value="<?php echo $r['id']; ?>"><button class="btn btn" name="delete">Delete</button></form></td></tr><?php endforeach; ?></tbody></table>
</div><?php include __DIR__.'/../includes/footer.php'; ?></body></html>
