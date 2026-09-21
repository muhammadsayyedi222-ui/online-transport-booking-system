<?php if(session_status()===PHP_SESSION_NONE) session_start(); ?>
<header class="site-header">
  <div class="wrap">
    <div class="brand"><a href="/transport_booking/index.php">GIGM Booking</a></div>
    <nav class="nav">
      <?php if(isset($_SESSION['user'])): ?>
        <a href="/transport_booking/booking.php">Book</a>
        <a href="/transport_booking/user/history.php">My Bookings</a>
        <?php if($_SESSION['user']['role']==='admin'): ?>
          <a href="/transport_booking/admin/index.php">Admin</a>
        <?php endif; ?>
        <a href="/transport_booking/logout.php">Logout</a>
      <?php else: ?>
        <a href="/transport_booking/index.php">Home</a>
        <a href="/transport_booking/login.php">Login</a>
        <a href="/transport_booking/register.php">Register</a>
      <?php endif; ?>
    </nav>
  </div>
</header>
