<?php
		session_start();

		spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
	});
		$conn = new DbConnection("SRF");
		if(isset($_POST['sign_up'])){
			sign_up();
		}
		elseif(isset($_POST['login'])){
			login();
		}
		elseif (isset($_POST['check_username'])) {
			
		}

		function register_user($user)
		{
			$_SESSION['id'] = $user->id;
			$_SESSION['username'] = $user->username;

		}

		function isUniqueUsername(){
			$conn = $GLOBALS['conn'];
			$userManager = new UserManager($conn);
			return $userManager->isUniqueUsername($user)
		}

		function sign_up()
		{
			$conn = $GLOBALS['conn'];
			$user = User::fromRow($_POST);
			$userManager = new UserManager($conn);

			if($userManager->save($user) == TRUE ){
				echo "<h3>success</h3></br>";
				register_user($user);
				header('Location:./chooseDepartment.php',TRUE,301);
			}
			else {
    			echo "Error: "  . "<br>" . $conn->error();	
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
				register_user($user);
				if(!isset($user->department_id)){
					header('Location:./chooseDepartment.php',TRUE,301);
				}
				else{
					header('Location:./chooseCourses.php',TRUE,301);
				}
			}
			else {
				echo "no acount was found please sign up";
			}
		}
	?>