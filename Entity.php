<<?php 

	/**
	* 
	*/
	class Entity
	{
		
		public $id;
		function __construct()
		{
		}
		
		public function props()
		{
			 var_dump( get_object_vars($this) );
		}

		public static function fromRow(array $row)
		{
			$instance = new static;
			$props = get_class_vars(get_called_class());
			foreach($props as $key=>$val){
				if(isset($row[$key])){
					$instance->$key = $row[$key];
				}
			}
			return $instance;
		}

	}






 ?>