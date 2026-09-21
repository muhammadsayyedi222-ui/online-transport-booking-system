<?php require_once __DIR__ . '/../db.php'; if(!isset($_SESSION['user'])||$_SESSION['user']['role']!=='admin'){ header('Location: login.php'); exit; }
if($_SERVER['REQUEST_METHOD']==='POST'){
  if(isset($_POST['add'])){
    $o=$_POST['origin']; $d=$_POST['destination']; $p=floatval($_POST['price']);
    $s = $conn->prepare('INSERT INTO routes (origin,destination,price) VALUES (?,?,?)'); $s->bind_param('ssd',$o,$d,$p); $s->execute();
  } elseif(isset($_POST['delete'])){
    $id=intval($_POST['id']); $s=$conn->prepare('DELETE FROM routes WHERE id=?'); $s->bind_param('i',$id); $s->execute();
  }
}
$rows = $conn->query('SELECT * FROM routes ORDER BY id DESC')->fetch_all(MYSQLI_ASSOC); $state = ['Abia','Adamawa','Akwa Ibom','Anambra','Bauchi','Bayelsa','Benue','Borno','Cross Rivere','Delta','Ebonyi','Edo','Ekiti','Enugu','Gombe','Imo','Jigawa','Kaduna','Kano','Katsina','Kebbi','Kogi','Kwara','Lagos','Nasarawa','Niger'.'Ogun','Ondo','Osun','Oyo','Plateu','Rivers','Sokoto','Taraba','Yobe','Zamfara','FCT'];  ?> 
?><!doctype html><html><head><meta charset="utf-8"><title>Routes</title><link rel="stylesheet" href="../assets/style.css"></head><body><?php include __DIR__.'/../includes/header.php'; ?>
<div class="container"><h2>Routes</h2>
<form method="post"><label>Origin</label><select name="origin" required><option value="">--select origin state--</option><?php foreach($state as $state): ?><option value="<?php echo htmlspecialchars($state); ?>"><?php echo htmlspecialchars($state); ?></option><?php endforeach; ?></select><label>Destination</label><input name="destination" required><label>Price</label><input name="price" type="number" step="0.01" required><button class="btn" name="add">Add</button></form>
<table class="table"><thead><tr><th>#</th><th>Origin</th><th>Destination</th><th>Price</th><th></th></tr></thead><tbody><?php foreach($rows as $r): ?>
<tr><td><?php echo $r['id']; ?></td><td><?php echo e($r['origin']); ?></td><td><?php echo e($r['destination']); ?></td><td>₦<?php echo number_format($r['price'],2); ?></td><td><form method="post" onsubmit="return confirm('Delete?');"><input type="hidden" name="id" value="<?php echo $r['id']; ?>"><button class="btn btn" name="delete">Delete</button></form></td></tr><?php endforeach; ?></tbody></table>
</div><?php include __DIR__.'/../includes/footer.php'; ?></body></html>
