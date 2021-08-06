<?php include('server.php'); ?>


<!DOCTYPE html>
<html>
	<head>
		<title>TS Clinic IS</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>

	<body>
		<div class="menu">
			<h2>TS Clinic IS</h2>
		</div>

		 <div class="form-header">
  			<h2>Login as an employee</h2>
  		</div>

		<form method="post" action="login-emp.php">
			<?php include('errors.php');?>
			<div class="input-group">
				<label>Username</label>
				<input type="text" name="username" placeholder="Enter username" required>
			</div>
			<div class="input-group">
				<label>Password</label>
				<input type="password" placeholder="Enter password" name="password" required>
			</div>
			<div>
				<button type="submit"  name="login-emp" class="btn">Log in</button>
			</div>
			<a href="index.php" class="login-back-btn">Back</a>
		</form>
	</body>
</html>

<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>