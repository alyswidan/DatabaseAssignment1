<?php 
spl_autoload_register(function ($class_name) {
	include $class_name . '.php';
});

	/**
	* 
	*/
	class User extends Entity
	{
		public $first_name,$last_name,$username,$email,$registration_date,$department_id;
		private $password;

		function __set($name,$value){
			if(method_exists($this,"set".$name)){
				$name = "set".$name;
				$this->$name($value);
			}
			else{
				$this->$name = $value;
			}

		}

		function __get($name){
			if(method_exists($this, "get".$name)){
				$name = "get".$name;
				return $this->$name();
			}
			elseif(property_exists($this,$name)){
				return $this->$name;
			}
			 return null;
		}

		public function setpassword($password){
        $this->password = md5($password);
    	}

    	public function getpassword(){
    		return $this->password;
    	}
    }

?>