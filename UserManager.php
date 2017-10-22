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
			error_log($sql,3,"./log");
			return $this->conn->query($sql);

		}
		public function getByUserName($user)
		{
			$result = $this->conn->query("select * from users where username='".$user->username."'");
			return $result;
		}
		public function isUniqueUsername($user)
		{
			$result = getByUserName($user->username);
			return ($result->num_rows) == 0;

		}

		public function setDepartmentId($user)
		{
			$sql = 'update users set department_id='.$user->department_id.' where id='.$user->id;
			return $this->conn->query($sql);
		}

	}



	?>