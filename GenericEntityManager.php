<?php 
	/**
	* 
	*/
	class GenericEntityManager
	{

		protected $conn,$className;
		function __construct($conn,$tableName,$entityClassInstance)
		{
			$this->conn = $conn;
			$this->tableName = $tableName;
			$this->className = get_class($entityClassInstance);
		}

		private function insert(&$entity){

			$sql = "INSERT into ".$this->tableName."(";


			foreach (get_object_vars($entity) as $col=>$val)
			{
				if(!is_null($val)){
					$sql .= $col . ',';
				}
			}

			$sql = substr($sql, 0,strlen($sql)-1) . ") values ("; 

			foreach (get_object_vars($entity) as $col=>$val)
			{
				if(!is_null($val)){
					$sql .= "'". $val . "',";
				}
			}
			$sql =  substr($sql, 0,strlen($sql)-1) . ")";

			$result = $this->conn->query($sql);
			if($result == TRUE){
				$entity->id = $this->conn->insert_id();
			}
			return $result;
		}
		public function save(&$entity)
		{
			$this->insert($entity);
		}


		public function getAll()
		{
			$result = $this->conn->query("select * from ".$this->tableName);
			$entities = array();
			while($row = $result->fetch_assoc()){
				$x = call_user_func($this->className .'::fromRow',$row);
				array_push($entities,$x);
			}
			return $entities;
		}

		public function getById($id)
		{
			$result = $this->conn->query("select * from ".$this->tableName." where id = ".$id);
			if($result->num_rows > 0)
				return call_user_func($this->className .'::fromRow',$result->fetch_assoc());
			
		}


	}





 ?>