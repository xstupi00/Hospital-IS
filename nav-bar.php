<nav class="navbar navbar-inverse" style="margin-bottom: 0">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php?page=0">TS Clinic IS</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Search<span class="caret"></span></a>
        <ul class="dropdown-menu">
        <?php if($_SESSION['usertype'] == "A"):?>
          <li><a href="index.php?search=1">Doctor</a></li>
          <li><a href="index.php?search=2">Nurse</a></li>
          <li><a href="index.php?search=3">Medication</a></li>
          <li><a href="index.php?search=4">Department</a></li>
        <?php endif?>
        <?php if($_SESSION['usertype'] == "D"):?>
          <li><a href="index.php?search=1">Patient</a></li>
          <li><a href="index.php?search=3">Medication</a></li>
          <li><a href="index.php?search=4">Department</a></li>
        <?php endif?>
        <?php if($_SESSION['usertype'] == "N"):?>
          <li><a href="index.php?search=1">Patient</a></li>
          <li><a href="index.php?search=4">Department</a></li>
        <?php endif?>
        </ul>
      </li>
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Add<span class="caret"></span></a>
        <ul class="dropdown-menu">
        <?php if($_SESSION['usertype'] == "A"):?>
          <li><a href="add-doctor.php">Doctor</a></li>
          <li><a href="add-nurse.php">Nurse</a></li>
          <li><a href="add-medication.php">Medication</a></li>
          <li><a href="add-department.php">Department</a></li>
        <?php endif?>
        <?php if($_SESSION['usertype'] == "D" || $_SESSION['usertype'] == "N"):?>
          <li><a href="add-patient.php">Patient</a></li>
        <?php endif?>
        </ul>
      </li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="#"><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['username'];?></a></li>
      <li><a href="index.php?logout=1"><span class="glyphicon glyphicon-log-out"></span> Log out</a></li>
    </ul>
  </div>
</nav>        