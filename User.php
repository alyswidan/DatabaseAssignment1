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
		private $password;

		function __set($name,$value){
			if(method_exists($this, $name)){
				$this->$name($value);
			}
			else{
				$this->$name = $value;
			}
		}

		function __get($name){
			if(method_exists($this, $name)){
				return $this->$name();
			}
			elseif(property_exists($this,$name)){
				return $this->$name;
			}
			 return null;
		}

		public function password($password){
        $this->password = md5($password);
    	}

    	public function password(){
    		return $this->password
    	}


		?>