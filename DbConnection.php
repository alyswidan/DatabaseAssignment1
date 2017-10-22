<?php 

	spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
	});
	class DbConnection
	{

		private $conn;
		function __construct($dbname,$servername="localhost",$username="root",$password="")
		{
			$this->conn = new mysqli($servername,$username,$password,$dbname);
			if($this->conn->connect_error){
				die("connection failed " . $connection->connect_error);
			}
		}

		function  __destruct(){
			$this->conn->close();

		}

		public function __get($conn) {
    		if (property_exists($this, $conn)) {
      			return $this->$conn;
   			}
  		}

  		public function query($sql)
  		{
  			return $this->conn->query($sql);
  		}
  		public function error(){

  			return $this->conn->error;
  		}

  		public function insert_id()
  		{
  			return $this->conn->insert_id;
  		}
	}





 ?>
