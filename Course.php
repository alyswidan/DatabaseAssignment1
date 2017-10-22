<?php 
	spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
	});

	/**
	* 
	*/
	class Course extends Entity
	{
		public $name,$description,$credit_hours,$instructor_name,$department_id;
	}




 ?>