<?php
spl_autoload_register(function ($class_name) {
	include '../' . $class_name . '.php';
});
session_start();
function set_session($user)
{
	$_SESSION['id'] = $user->id;
	$_SESSION['username'] = $user->username;
}
function login()
{

	$data  = (array) json_decode(file_get_contents('php://input'), TRUE)['data'];
	var_dump($data);
	$conn = new DbConnection("SRF");
	$user = User::fromRow($data);
	$userManager = new UserManager($conn);
	$result = $userManager->getByUserNameAndPassword($user);
	if($result->num_rows > 0)
	{
		$user = User::fromRow($result->fetch_assoc());
		set_session($user);
		/*if(!isset($user->department_id)){
			header('Location:./chooseDepartment.php',TRUE,301);
		}
		else{
			header('Location:./chooseCourses.php',TRUE,301);
		}*/
		return 1;
	}
	else {
		return 0;
	}
}
$result = array('result'=>login());
$json =json_encode($result);

echo json_encode($result); 

?>