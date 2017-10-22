<?php 
	session_start();
?>

<html>
<head>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 

</head>
<body>

	<div class="container">
		<form id="form" action="authenticateUser.php" method="post" class="col-sm-2 col-lg-4">
			<div class="form-group">
				<label for="password_login"> password: </label>
				<input type = "password" Name ="password" ID="password_login" placeholder="password" class="form-control col-xs-4">
			</div>
			<div class="form-group">
				<label for="username"> username: </label>
				<input type = "text" Name ="username" ID="username" placeholder="username" class="form-control col-xs-4">
			</div>
			<button Name="login" type="submit" class="btn btn-default">Login</button>
		</form>
	</div>

	<hr/>

	<div class="container">
	
		<h3>new user?</h3>

		<form id="sign_up_form" action="authenticateUser.php" method="post" class="col-sm-2 col-lg-4">
			<div class="form-group" >
				<label for="first_name">First Name: </label>
				<input type = "text" Name ="first_name" ID="first_name"  placeholder="First Name" class="form-control col-xs-4">
			</div>
			<div class="form-group">
				<label for="last_name">Last Name: </label>
				<input type = "text" Name ="last_name" ID="last_name" placeholder="Last Name" class="form-control col-xs-4">
			</div>
			<div class="form-group">
				<label for="email">Email: </label>
				<input type = "text" Name ="email" ID="email" placeholder="email" class="form-control col-xs-4">
			</div>
			<div class="form-group">
				<label for="password_signup"> password: </label>
				<input type = "password" Name ="password" ID="password_signup" placeholder="password" class="form-control col-xs-4">
			</div>
			<div class="form-group">
				<label for="username"> username: </label>
				<input type = "text" Name ="username" ID="username" placeholder="username" class="form-control col-xs-4">
			</div>
			<button type="submit" Name="sign_up" class="btn btn-default">Sign Up</button>
		</form>
	</div>

	<script type="text/javascript">
		function validate_email(email) {
			var email_pattern = new RegExp('^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$');
			return email_pattern.test(email)
		}

		function validate_username(username) {
		}


		$('#sign_up_form').submit(function (event) {
			if(!validate_email($('#email').val())){
				event.preventDefault();
				alert('invalid email address');
			}
		});

	</script>

	
</body>
</html>