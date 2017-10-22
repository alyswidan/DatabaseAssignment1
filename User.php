<?php 
	spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
	});

	/**
	* 
	*/
	class User extends Entity
	{
		public $first_name,$last_name,$username,$password,$email,$registration_date,$department_id;
	}




 ?>