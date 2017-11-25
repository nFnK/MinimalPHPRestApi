<?php
Class auth{
	private $db;
	function __construct(){
		$this->db = new DB();
	}
	public function login(){
		if(isset($_POST['username']) && isset($_POST['password'])){
			$filtered_data = Common::filter($_POST);
			Common::json($filtered_data);
		}else{
			Common::json($this->error);
		}
	}
	public function register(){
		if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])){
			$payload = Common::filter($_POST);

			$res_check = $this->db->select('users','*',array('username' => $payload['username'],'email' => $payload['email']),true);
			
			if($res_check['num_rows'] > 0){
				Common::json(array('success'=>0 , 'message' => 'Username already exist'));
			}else{
				$payload['password'] = md5($payload['password']);
				$res = $this->db->insert($payload,'users');
				unset($payload['password']);
				if($res){
					Common::json(array('success'=>1 , 'message' => 'Registered successfully' , 'token' => Common::JWT($payload)));
				}else{
					Common::json(array('success'=>0 , 'message' => 'Failed to register.' , 'catch' => 'Check the fields matching table fields'));
				}
			}
			
		}else{
			Common::json(array('success'=>0 , 'message' => 'All fields required'));
		}
	}
	public function get_users()
	{
		if(isset($_POST['username']) && isset($_POST['password']))
		{
			$payload = Common::filter($_POST);
			$res = $this->db->select('users','*');
			if($res){
				Common::json(array('success'=>1 , 'message' => $res));
			}else{
				Common::json(array('success'=>0 , 'message' => 'Failed to get users' , 'catch' => 'Check the fields matching table fields'));
			}
		}
	}
}