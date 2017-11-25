<?php
Class hotel{
	private $db;
	function __construct(){
		$this->db = new DB();
		Common::check_jwt();
	}

	public function get_hotel(){
		$res = $this->db->select('hotel','*');
		if($res){
			Common::json(array('success'=>1 , 'message' => $res));
		}else{
			Common::json(array('success'=>0 , 'message' => 'Failed to retrive hotel list'));
		}
	}
	public function get_single_hotel(){
		if(isset($_POST['hotel_id']))
		{
			$payload = Common::filter($_POST);
			$where = array('hotel_id'=>$payload['hotel_id']);
			$res = $this->db->select('hotel','*',$where);
			if($res){
				Common::json(array('success'=>1 , 'message' => $res));
			}else{
				Common::json(array('success'=>0 , 'message' => 'Failed to retrive hotel list'));
			}
		}
	}
}