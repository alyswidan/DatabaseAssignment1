<?php 

session_start();
spl_autoload_register(function ($class_name) {
	include $class_name . '.php';
});


$conn = new DbConnection('SRF');
$userManager = new UserManager($conn);
if(isset($_POST['dept_id'])){
	$user = $userManager->getById($_SESSION['id']);
	$user->department_id = $_POST['dept_id'];
	if($userManager->setDepartmentId($user) == TRUE){
		echo 1;
	}
	else{
		echo 0;
	}
}

?>