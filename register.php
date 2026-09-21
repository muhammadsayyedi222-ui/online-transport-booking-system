<?php require_once __DIR__ . "/db.php"; ?>
<?php
$msg='';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'] ?? '';
  $email = $_POST['email'] ?? '';
  $password = $_POST['password'] ?? '';
  if (!$name || !$email || !$password) $msg = 'All fields required.';
  else {
    $hash = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("INSERT INTO users (name,email,password) VALUES (?,?,?)");
    $stmt->bind_param("sss",$name,$email,$hash);
    if ($stmt->execute()) $msg = 'Registered successfully. <a href="login.php">Login</a>';
    else $msg = 'Error: ' . e($stmt->error);
  }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Register</title><link rel="stylesheet" href="assets/style.css"></head>
<body>
<?php include __DIR__ . "/includes/header.php"; ?>
<div class="container" style="max-width:520px;margin-top:40px;">
  <h2>Create Account</h2>
  <?php if($msg) echo '<div class="alert">' . $msg . '</div>'; ?>
  <form method="post">
    <label>Full Name</label>
    <input name="name" required>
    <label>Email</label>
    <input type="email" name="email" required>
    <label>Password</label>
    <input type="password" name="password" required>
    <button class="btn" type="submit">Register</button>
  </form>
</div>
<?php include __DIR__ . "/includes/footer.php"; ?>
</body>
</html>
