<?php 

	/**
	* 
	*/
	class Entity
	{
		
		public $id;
		function __construct()
		{
		}
		
		public static function fromRow(array $row)
		{
			$instance = new static;
			/*$props = get_class_vars();*/
			$reflection = new ReflectionClass(get_called_class());
			$props = $reflection->getdefaultProperties();
			foreach($props as $key=>$val){
				error_log("current_key_".$key." ",3,'./log');
				if(isset($row[$key])){
					$instance->$key = $row[$key];
				}
			}
			return $instance;
		}

	}






 ?>