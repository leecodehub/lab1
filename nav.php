<?php // nav.php ?>
<nav class="navbar">
  <span class="brand">Assessment</span>
  <a class="nav-link<?php echo basename($_SERVER['PHP_SELF']) === 'index.php' && strpos($_SERVER['PHP_SELF'],'pages') === false ? ' active' : ''; ?>" href="/assessment_beginner/index.php">Dashboard</a>
  <a class="nav-link<?php echo strpos($_SERVER['PHP_SELF'],'clients') !== false ? ' active' : ''; ?>" href="/assessment_beginner/pages/clients_list.php">Clients</a>
  <a class="nav-link<?php echo strpos($_SERVER['PHP_SELF'],'services') !== false ? ' active' : ''; ?>" href="/assessment_beginner/pages/services_list.php">Services</a>
  <a class="nav-link<?php echo strpos($_SERVER['PHP_SELF'],'bookings') !== false ? ' active' : ''; ?>" href="/assessment_beginner/pages/bookings_list.php">Bookings</a>
  <a class="nav-link<?php echo strpos($_SERVER['PHP_SELF'],'tools') !== false ? ' active' : ''; ?>" href="/assessment_beginner/pages/tools_list_assign.php">Tools</a>
  <a class="nav-link<?php echo strpos($_SERVER['PHP_SELF'],'payments') !== false ? ' active' : ''; ?>" href="/assessment_beginner/pages/payments_list.php">Payments</a>
</nav>