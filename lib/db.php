<?php
Class DB{
	public static $host = 'localhost';
	public static $user = 'root';
	public static $pass = '';
	public static $db = 'test';

	public $mysqli;
	public function __construct(){
	    $this->mysqli = new mysqli(self::$host, self::$user, self::$pass, self::$db);
	    return $this->mysqli;
 	}
 	/* Crud */
 	
 	/*
	@ Used to generate insert query
	
	@params Array data, Table name

 	@Param $arr
 	@values Values to be insert to update
	
	@Param $table
 	@values Table name
 	*/
 	public function insert($arr,$table)
 	{
		$values = '(';
 		$fields = '(';
		foreach ($arr as $key => $value){
			$fields .= $key.",";
			$values .= "'".$value."',";
		}
		$fields = rtrim($fields,",");
		$values = rtrim($values,",");
		$fields .= ')';
		$values .= ')';
		$query = 'INSERT INTO `'.$table.'` '.$fields." VALUES ".$values;
		return $this->run_query($query);
		// return 'INSERT INTO `'.$table.'` '.$fields." VALUES ".$values;
 	}

 	/*
	@ Used to generate update query
	
	@params Array data, Table name

 	@Param $arr
 	@values Values to be insert to update
	
	@Param $table
 	@values Table name

 	@Param $where
 	@values Optional value , used when updating
 	*/
 	public function update($arr,$table,$where)
 	{
		$values = '';
		$where_string = '';
		foreach ($where as $key => $val){
			unset($arr[$key]);
			$where_string .= $key."='".$val."' AND";
		}
		$where_string = rtrim($where_string," AND");
		foreach ($arr as $key => $value){
			$values .= $key." = '".$value."',";
		}
		$values = rtrim($values,",");
		$query = 'UPDATE '.$table.' SET '.$values." WHERE ".$where_string;
		return $this->run_query($query);
		// return 'UPDATE '.$table.' SET '.$values." WHERE ".$where_string;
 	}

 	/*
	@ Used to generate update query
	
	@params Table name, Where

 	@Param $arr
 	@values Values to be insert to update
	
	@Param $table
 	@values Table name

 	@Param $where
 	@values Optional value , used when updating
 	*/
 	public function select($table,$fields,$where=null,$and_or = 'AND')
 	{
		$where_string = '';
		if($where != null){
			$where_string = ' WHERE ';
			($and_or !== 'AND') ? $and_or='OR' : $and_or='AND';
			foreach ($where as $key => $val){
				$where_string .= $key."='".$val."' ".$and_or." ";
			}	
			$where_string = rtrim($where_string," ".$and_or." ");
		}
		$query = 'SELECT '.$fields.' FROM '.$table." ".$where_string." LIMIT 10";
		return $this->run_select($query);
 	}

 	public function delete($table,$where,$and_or = 'AND') {
 		if($where != null){
			$where_string = ' WHERE ';
			($and_or !== 'AND') ? $and_or='OR' : $and_or='AND';
			foreach ($where as $key => $val){
				$where_string .= $key."='".$val."' ".$and_or." ";
			}	
			$where_string = rtrim($where_string," ".$and_or." ");
		}
	 	$query = 'DELETE FROM '.$table.' WHERE '.$where_string;
	 	return $this->run_query($query);
 	}

 	public function run_query($sql)
 	{
		$q = $this->mysqli->query($sql);
		if($q) {
			return $q;
	 	}else{
	 		return false;
	 	}
 	}
 	public function run_select($sql)
 	{
		$q = $this->mysqli->query($sql);
		if($q) {
			$ret = array();
			while($row=$q->fetch_assoc()){
				$ret[]=$row;
			}
	 		return array('result'=>$ret,'num_rows'=>$q->num_rows);
	 	}else{
	 		return false;
	 	}
 	}
}