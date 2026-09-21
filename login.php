<?php require_once __DIR__ . "/db.php"; ?>
<?php
$error='';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'] ?? '';
  $password = $_POST['password'] ?? '';
  $stmt = $conn->prepare("SELECT id, name, email, password, role FROM users WHERE email=? LIMIT 1");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $res = $stmt->get_result()->fetch_assoc();
  if ($res && password_verify($password, $res['password'])) {
    $_SESSION['user'] = ['id'=>$res['id'],'name'=>$res['name'],'email'=>$res['email'],'role'=>$res['role']];
    header('Location: booking.php'); exit;
  } else {
    $error = "Invalid credentials.";
  }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8"><title>Login</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<?php include __DIR__ . "/includes/header.php"; ?>
<div class="container" style="max-width:480px;margin-top:40px;">
  <h2>Login</h2>
  <?php if($error) echo '<div class="alert">'.e($error).'</div>'; ?>
  <form method="post">
    <label>Email</label>
    <input type="email" name="email" required>
    <label>Password</label>
    <input type="password" name="password" required>
    <button class="btn" type="submit">Login</button>
  </form>
</div>
<?php include __DIR__ . "/includes/footer.php"; ?>
</body>
</html>
