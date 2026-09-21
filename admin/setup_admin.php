<?php require_once __DIR__ . '/../db.php';
// run once to create admin user
$email='admin@local'; $pw='Admin@123';
$hash = password_hash($pw, PASSWORD_BCRYPT);
$check = $conn->prepare('SELECT id FROM users WHERE email=?'); $check->bind_param('s',$email); $check->execute(); $r=$check->get_result();
if ($r && $r->num_rows>0) { echo 'Admin user already exists. <a href="login.php">Login</a>'; exit; }
$stmt = $conn->prepare('INSERT INTO users (name,email,password,role) VALUES (?,?,?,"admin")'); $name='Administrator'; $stmt->bind_param('sss',$name,$email,$hash);
if ($stmt->execute()) echo 'Admin created. Email: '.$email.' Password: '.$pw.' <a href="login.php">Go to login</a>'; else echo 'Error: '.$stmt->error;
?>