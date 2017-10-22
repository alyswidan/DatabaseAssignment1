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
		error_log("hi",3,'./log');
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

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
	<style type="text/css">
		#login_form {
			margin-top: 20;
		};

	</style>
</head>
<body>

	<div class="container">
		<h3>Login</h3>
		<form id="login_form" action="" method="post" class="form-inline">
			<label class="sr-only" for="inlineFormInput">Name</label>
			<input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0"  Name ="username" ID="username" placeholder="username">

			<label class="sr-only" for="inlineFormInputGroup">Password</label>
			<div class="input-group mb-2 mr-sm-2 mb-sm-0">
				<input type="password" class="form-control" placeholder="password" Name ="password" ID="password_login" >
			</div>

			<button name="login" type="submit" class="btn btn-primary">Submit</button>
		</form>
<!-- 		<form id="form" action="" method="post" class="col-sm-2 col-lg-4 form-inline">
			<div class="form-group">
				<label for="password_login"> password: </label>
				<input type = "password" Name ="password" ID="password_login" placeholder="password" class="form-control col-xs-4">
			</div>
			<div class="form-group">
				<label for="username"> username: </label>
				<input type = "text" Name ="username" ID="username" placeholder="username" class="form-control col-xs-4">
			</div>
			<button Name="login" type="submit" class="btn btn-default">Login</button>
		</form> -->
	</div>

	<?php 
			if(isset($_POST['login'])){
				login();
			}
	 ?>

	<hr/>

	<div class="container">

		<h3>new user?</h3>

		<form id="sign_up_form" action="" method="post" class="col-sm-2 col-lg-4 ">
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
				<?php
				if( (isset($_POST['sign_up']) && !isUniqueUsername(User::fromRow($_POST))))
					echo "<p>this user name is taken,try again</p>";
				else {
					if(($res = sign_up()) != "success"){
						echo $res;
					}
				}
				?>
			</div>
			<button type="submit" Name="sign_up" class="btn btn-primary">Sign Up</button>
		</form>
	</div>

	<script type="text/javascript">
		function validate_email(email) {
			var email_pattern = new RegExp('^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$');
			return email_pattern.test(email)
		}

		function validate_username(username) {
			$.ajax({
				method: "POST",
				url: "authenticateUser.php",
				data: { check_username:true,username:username }
			})
			.done(function( msg ) {
				console.log(msg);
				return msg.search('1') > 0;
			});
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