<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#"><?php echo COMPANY_NAME ?></a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="map.php?action=add">Upload SSU Map</a></li>
      <li><a href="userdashboard.php">View Maps</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><img src='images/user-icon.png' width="25" height="25"/> Hi,<?php echo $_SESSION['SESS_USERNAME'] ?></li>
      <li><a href="logout.php"><img title='Logout' src="images/logout-icon.png" width="25" height="25"  /></a></li>
    </ul>
  </div>
</nav>