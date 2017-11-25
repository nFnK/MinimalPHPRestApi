<?php
class Common{
	public static $jwt_key = '';
	public static $jwt_expiry_time = 0;
	
	public static function json($data){
		// header('Content-Type: application/text');
		header('Content-Type: application/json');
		echo json_encode($data);
		die();
	}
	public static function xml($data)
	{
		$xml = new SimpleXMLElement('<root/>');
		array_walk_recursive($data, array ($xml, 'addChild'));
		print $xml->asXML();
		die();
	}
	public static function filter($data) {
	    if (is_array($data)) {
	        foreach ($data as $key => $element) {
	            $data[$key] = self::filter($element);
	        }
	    } else {
	        $data = trim(htmlentities(strip_tags($data)));
	        if(get_magic_quotes_gpc()) $data = stripslashes($data);
	        $search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
	    	$replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");
		    $data = str_replace($search, $replace, $data);
		    return $data;
	    }
	    return $data;
	}
	public static function JWT($payload)
	{
		$issueTime = time();
		$expireTime = $issueTime + Common::$jwt_expiry_time;
		$token = array(
	        "iat" => $issueTime,
	        "nbf" => $issueTime,
	        "data" => $payload
    	);
		return JWT::encode($token, Common::$jwt_key);
	}
	public static function isAjax()
	{
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
		{    
		  return true;
		}
		return false;
	}
}