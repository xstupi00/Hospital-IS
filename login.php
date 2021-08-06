<?php include('server.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>TS Clinic IS</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://www.stud.fit.vutbr.cz/~xzubri00/IIS/style.css"> 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="index.php">TS Clinic IS</a>
      </div>
    </div>
  </nav>
  
<div class="container">

	<div class="form-header">
	<h4>Log in as an 
		<?php echo (isset($_GET['user']) && $_GET['user']=="0") ? "admin": "employee"?>
	</h4>
	</div>
	<form class="login-form" method="post" action="login.php?<?php echo "user=".$_GET['user'];?>">
		<?php include('errors.php');?>
	    <div class="form-group">
	        <label for="inputUsername">Username</label>
	        <input type="text" name="username" class="form-control"  placeholder="Username" required>
	    </div>
	    <div class="form-group">
	        <label for="inputPassword">Password</label>
	        <input type="password" name="password" class="form-control" placeholder="Password" required>
	    </div>
	    <button type="submit" name="login" class="btn btn-primary">Login</button>
	    <a style="float: right;" href="index.php" class="btn btn-primary" role="button">Back</a>
	</form>
</div>

</body>
</html>


<script>
/*JS Script removing resubmission of form */
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>