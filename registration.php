<?php 
session_start();
spl_autoload_register(function ($class_name) {
	include $class_name . '.php';
});
$conn = new DbConnection("SRF");
function set_session($user)
{
	$_SESSION['id'] = $user->id;
	$_SESSION['username'] = $user->username;
}

function isUniqueUsername($user){
	$conn = $GLOBALS['conn'];
	$userManager = new UserManager($conn);
	return $userManager->isUniqueUsername($user);
}

function sign_up()
{
	$conn = $GLOBALS['conn'];
	$user = User::fromRow($_POST);
	$userManager = new UserManager($conn);
	$res = $userManager->save($user);
	if($res == TRUE ){
		set_session($user);
		header('Location:./chooseDepartment.php',TRUE,301);
		
	}
	else {
		return $conn->error;	
	}

}
function login()
{
	$conn = $GLOBALS['conn'];
	$user = User::fromRow($_POST);
	$userManager = new UserManager($conn);
	$result = $userManager->getByUserNameAndPassword($user);
	if($result->num_rows > 0)
	{
		$user = User::fromRow($result->fetch_assoc());
		set_session($user);
		if(!isset($user->department_id)){
			header('Location:./chooseDepartment.php',TRUE,301);
		}
		else{
			header('Location:./chooseCourses.php',TRUE,301);
		}
		return TRUE;
	}
	else {
		return FALSE;
	}
}
?>

<html>
<head>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>


	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


	<style type="text/css">
		#login_form {
			margin-top: 20;
		}
		.form-group.required .form-control-label:after { 
			color: #d00;
			content: "*";
			margin-left: 8px;
			top:7px;
		}
	}

</style>
</head>
<body>

	<form class="container" action="" method="post">
		<h3>Login</h3>

		<div class="row">
			<div class="col-md-3 mb-3">
				<input type="text" class="form-control" name ="username" ID="username_login" placeholder="username" required>
				<div class="invalid-feedback">
					Invalid username or password.
				</div>
			</div>
			<div class="col-md-3 mb-3">
				<input type="password" class="form-control"  placeholder="password" Name ="password" ID="password_login" required>
				<div class="invalid-feedback">
				</div>
			</div>
		</div>
		<button name="login" type="submit" class="btn btn-primary">Login</button>
	</form>
	<?php 
	
	if(isset($_POST['login'])){
		$res = login();
		echo '<script type="text/javascript"> $("#username_login").addClass("is-invalid");$("#password_login").addClass("is-invalid");</script>';
	}
	?>
	<br>
	<hr/>

	<div class="container">
		<h3>new user?</h3>

		<form id="sign_up_form" action="" method="post" class="col-sm-2 col-lg-4 ">
			<div class="form-group row required" >
				<label for="first_name" class="form-control-label" >First Name: </label>
				<input type = "text" Name ="first_name" ID="first_name"  placeholder="First Name" class="form-control col-xs-4" required>
			</div>
			<div class="form-group row required">
				<label for="last_name" class="form-control-label">Last Name: </label>
				<input type = "text" Name ="last_name" ID="last_name" placeholder="Last Name" class="form-control col-xs-4" required>
			</div>
			<div class="form-group row required">
				<label for="email" class="form-control-label">Email: </label>
				<input type = "text" Name ="email" ID="email" placeholder="email" class="form-control col-xs-4" required>
			</div>
			<div class="form-group row required">
				<label for="password_signup" class="form-control-label"> password: </label>
				<input type = "password" Name ="password" ID="password_signup" placeholder="password" class="form-control col-xs-4" required>
			</div>
			<div class="form-group row has-error has-feedback required" id="username-login-form-group">
				<label for="username" class="form-control-label"> username: </label>
				<input type = "text" Name ="username" ID="username-signup" placeholder="username" class="form-control form-control-danger col-xs-4" required>
				<div class="invalid-feedback">
					This username is already taken,please try another one.
				</div>
			</div>
			
			<div class="form-group row">
				<button type="submit" name="sign_up" class="btn btn-primary">Sign Up</button>
			</div>
		</form>
	</div>

	<?php


	if(isset($_POST['sign_up'])){

		if(!isUniqueUsername(User::fromRow($_POST))){
			echo '<script type="text/javascript"> $("#username-signup").addClass("is-invalid");</script>';
		}
		else{
			sign_up();
		}
	}



	?>


	<script type="text/javascript">
		function validate_email(email) {
			var email_pattern = new RegExp('^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$');
			return email_pattern.test(email)
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