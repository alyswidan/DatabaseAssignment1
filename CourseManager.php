<?php 
spl_autoload_register(function ($class_name) {
	include $class_name . '.php';
});

	/**
	* 
	*/
	class CourseManager extends GenericEntityManager
	{
		
		function __construct($conn)
		{
			GenericEntityManager::__construct($conn,'courses',new Course());
		}


		public function getByDepartmentId($department_id)
		{

			$sql = "select * from courses where department_id={$department_id}";
			$result = $this->conn->query($sql);
			$entities = array();
			while($row = $result->fetch_assoc()){
				array_push($entities,Course::fromRow($row));
			}
			return $entities;

		}

	}



	?>