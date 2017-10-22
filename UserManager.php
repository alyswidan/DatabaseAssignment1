<?php 
spl_autoload_register(function ($class_name) {
	include $class_name . '.php';
});

	/**
	* 
	*/
	class UserManager extends GenericEntityManager
	{
		
		function __construct($conn)
		{
			GenericEntityManager::__construct($conn,'users',new User());
		}


		public function getByUserNameAndPassword($user)
		{

			$sql = "select * from users where username='".$user->username."' and password='".$user->password."'";
			return $this->conn->query($sql);

		}
		public function getByUserName($user)
		{
			$sql = "select * from users where username='".$user->username."'";
			$result = $this->conn->query($sql);
			return $result;
		}
		public function isUniqueUsername($user)
		{
			$result = $this->getByUserName($user);
			return ($result->num_rows) == 0;

		}

		public function setDepartmentId($user)
		{
			$sql = 'update users set department_id='.$user->department_id.' where id='.$user->id;
			return $this->conn->query($sql);
		}

	}



	?>