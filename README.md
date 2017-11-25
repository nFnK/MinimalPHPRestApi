# MinimalPHPRestApi
  A minimal library for Rest Api using PHP and JWT.

# To use DB query
  
  > In constructor use this : $this->db = new DB();

  # Insert
  ```
  $this->db->insert($data_as_array,$table_name);
  ```
  # update
  ```
  $where = array('user_id'=>$payload['user_id']);
  $res = $this->db->update($payload,'users',$where,'OR');
  $res = $this->db->update($payload,'users',$where,'AND');
  ```
  # Select
  ```
  $where = array('user_id'=>$payload['user_id']);
  $res = $this->db->select($table_name,'*',$where);
  $res = $this->db->select($table_name,'field_1,field_2',$where);
  ```
  # Delete
  ```
  $this->db->delete($table,$where,'AND');
  $this->db->delete($table,$where,'OR');
  ```
  
  # Custom query to select
  ```
  $query = 'select * from user';
  $this->db->run_select($query);
  ```
  # Custom query other than select
  ```
  $query = 'select * from user';
  $this->db->run_query($query);
  ```
  
 # Common class functions:
 
  # json
  > Converts array to json
  ```
  Common::json(array('success'=>1 , 'message' => $res));
  ```
  # xml
  > Converts array to xml
  ```
  Common::xml(array('success'=>1 , 'message' => $res));
  ```
  
  # JWT
  > Converts array to JWT Token
  ```
  JWT($payload)
  ```
  
  #check_jwt
  > Checks for valid jwt token
  ```
  function __construct(){
		$this->db = new DB();
		Common::check_jwt();
	}
  ```
  #filter
  > Filter data from sqli
  ```
		Common::filter($_POST);
  ```
