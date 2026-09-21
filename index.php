<?php require_once __DIR__ . "/db.php"; ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>GIGM Online Booking</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<?php include __DIR__ . "/includes/header.php"; ?>
<main class="hero">
  <div class="overlay"></div>
  <div class="hero-content wrap">
    <h1>Welcome to God is Good Motors Online Booking</h1>
    <p>Book your trip quickly and travel safely with GIGM.</p>
    <div class="cta">
      <a class="btn" href="login.php">Login</a>
      <a class="btn btn-outline" href="register.php">Register</a>
      <a class="btn btn-secondary" href="booking.php">Book Now</a>
    </div>
  </div>
</main>
<?php include __DIR__ . "/includes/footer.php"; ?>
</body>
</html>
