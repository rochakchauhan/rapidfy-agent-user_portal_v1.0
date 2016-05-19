<?php
namespace app\components;
 use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\web\Session;
use yii\web\Cookie;
 
class Utility extends Component{
	
	public function getLoggedInTime($includeSeconds=FALSE){
		$hours=$min=NULL;
		$getUserInfo=$this->getUserInfo();
		//echo "DEBUG <pre>"; print_r($getUserInfo); exit;
		$lastLoginDate=$getUserInfo['lastLoginDate'];
		if(!empty($lastLoginDate)){
			$_lastLoginDate=strtotime($lastLoginDate);
			$time=time();
			
			$diff=$time-$_lastLoginDate;
					
			$hours = intval($diff / 3600); 
			$min = intval(($diff / 60) % 60); 
			$sec = intval($diff % 60); 
			
			if($includeSeconds){
				return $hours."h:".$min."m:".$sec."s";
			}
			else{
				return $hours."h:".$min."m";
			}
		}
		else{
			return NULL;
		}
	}
	
	public function sanitizeString($str){
		$str=trim($str);
		$str=strip_tags($str);
		$str=$this->xss_clean($str);
		return $str;
	}
	
	public function xss_clean($data) {
		// Fix &entity\n;
		$data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
		$data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
		$data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
		$data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');
		// Remove any attribute starting with "on" or xmlns
		$data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);
		// Remove javascript: and vbscript: protocols
		$data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
		$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
		$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);
		// Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
		$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
		$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
		$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);
		// Remove namespaced elements (we do not need them)
		$data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);
		do
		{
			// Remove really unwanted tags
			$old_data = $data;
			$data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
		}
		while ($old_data !== $data);
		// we are done...
		return $data;
	}
	
	public function checkIfLoggedIn(){
		$LoggedIn=$this->isUserLoggedIn();
		if ($LoggedIn === FALSE) {
			$loginUrl = \Yii::$app -> getUrlManager() -> createUrl("home/login");
			return \Yii::$app->getResponse()-> redirect($loginUrl, 302);
			exit();
		}
	}
		
	public function formatDate($date){
		$time=strtotime($date);
		return date("F j, Y, g:i a",$time);
	}
	
	/**
	 * Get User Info of current User
	 *
	 * @return array
	 */
	public function getUserInfo() {
		$session = Yii::$app->session;
		$session->open();
		$session->regenerateID();
		
		return $session['accountInfo'];
	}
	
	public function isUserLoggedIn() {
		$return=FALSE;
		$session = Yii::$app->session;
		$session->open();
		$nons=$session['nons'];
	  	$session->regenerateID();
		
		$HASH_GENERATED=md5($_SERVER['HTTP_USER_AGENT']."_".$_SERVER['REMOTE_ADDR']."_".$nons);
		$_HASH=@$_COOKIE['RHASH'];
		
		//echo "GET:  $nons | $_HASH | $HASH_GENERATED <hr /><pre>"; print_r($_COOKIE); exit;  
		if(isset($nons) && !empty($nons)){
		//if($_HASH==$HASH_GENERATED){
	  		return TRUE;
		}
		else{
			return FALSE;
		}
	} 
	
	public function signInUser($accountInfo) {
		$session = Yii::$app->session;
		$session->open();
		//echo "=> <pre>";print_r($accountInfo); exit;
		if(isset($session['accountInfo'])){
			$_accountInfo=$session['accountInfo'];	
			$accountInfo=array_merge($_accountInfo,$accountInfo);
		}
		$session['accountInfo']=$accountInfo;
		$session['nons']=$nons=rand(1,99999999);
		$session->regenerateID();
		
		$RHASH=md5($_SERVER['HTTP_USER_AGENT']."_".$_SERVER['REMOTE_ADDR']."_".$nons);
		
		$domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
		setcookie('RHASH', $RHASH, time()+60*60*24*365, '/', $domain, false, true);
		//echo "SET:  $nons | $RHASH |<pre>"; print_r($_COOKIE); exit;
	}
	
	public function signOutUser() {
		$session = Yii::$app->session;
		$session->open();
		$session->destroy();
		
		$this->logoutUser();
		
		@session_start();
		@session_destroy();
				
		$RHASH="";
		$domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
		setcookie('RHASH', $RHASH, time()-222, '/', $domain, false, true);
	} 
	
	public function postViaCurl($apiUrl,$params,$returnHeaders=TRUE,$includeAuth=FALSE){
		$ch = curl_init();
		if($includeAuth==TRUE){
			$_params=json_decode($params,TRUE);
			$getUserInfo= $this->getUserInfo();		
			$id=$getUserInfo['id'];
			$token=$getUserInfo['token'];
		
			header("Authorization: RA $id:$token");
			$headr = array();
			$headr[] = "Authorization: RA $id:$token";	
			$headr[] = "Content-Type: application/json";	
			
			curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);
			curl_setopt($ch, CURLOPT_POST, TRUE); 
		}
				
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);              
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
      	
		
		$response = curl_exec($ch);
		$headers = curl_getinfo($ch);		
		$http_code=$headers['http_code'];
		curl_close($ch);
		
		if($returnHeaders){
			$return = array("response"=>$response,"headers"=>$headers);
			return $return;
		}
		else{
			return $response;
		}
	}
	
	/**
	 * Calls API
	 *
	 * @param string $apiUrl 
	 * @param array $params 
	 * 
	 * @return mixed
	 */
	public function callApi($apiUrl,$params,$returnHeaders=TRUE,$includeAuth=FALSE){
		$ch = curl_init();
		if($includeAuth==TRUE){
			$_params=json_decode($params,TRUE);
			$getUserInfo= $this->getUserInfo();		
			$id=$getUserInfo['id'];
			$token=$getUserInfo['token'];
		
			header("Authorization: RA $id:$token");
			$headr = array();
			$headr[] = "Authorization: RA $id:$token";	
			$headr[] = "Content-Type: application/json";	
			
			//curl_setopt($ch, CURLOPT_PUT, TRUE);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");		
			curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);
		}
		else{
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
			curl_setopt($ch, CURLOPT_POST, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, FALSE); 
		}
				
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);              
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
      	
		
		$response = curl_exec($ch);
		$headers = curl_getinfo($ch);		
		$http_code=$headers['http_code'];
		curl_close($ch);
		
		if($returnHeaders){
			$return = array("response"=>$response,"headers"=>$headers);
			return $return;
		}
		else{
			return $response;
		}
	}
	
	//TODO
	public function GetUserDataViaAPI($id, $atoken,$returnHeaders=TRUE) {
        $headers = array(
            "Content-type: application/json",
            "Authorization: RA $id:$atoken",
        );
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "http://staging.api.rapidfy.com/v3/accountmanager/users/" . $id . "/dashboard");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        $response = curl_exec($ch);
		$headers = curl_getinfo($ch);	
		
        curl_close($ch);

        if($returnHeaders){
			$return = array("response"=>$response,"headers"=>$headers);
			return $return;
		}
		else{
			return $response;
		}
    }
	 
	public function getViaCurl($url,$id,$token, $returnHeaders=TRUE) { 
		header("Authorization: RA $id:$token");
		
		$headr = array();
		$headr[] = "Authorization: RA $id:$token";


		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, FALSE);
		curl_setopt($ch, CURLINFO_HEADER_OUT, true);
		
		$response = curl_exec($ch);
		$headers = curl_getinfo($ch);		
		$http_code=$headers['http_code'];
		curl_close($ch);
		$_SESSION['response']=$response;
		if($returnHeaders){
			$return=array("response"=>$response,"headers"=>$headers);
			//echo "DEBUG : <pre>"; print_r($return); exit;
			return $return;
		}
		else{
			return $response;
		}
	}
	
	public function uploadeRemoteFile($id, $token){
		$http_code=NULL;
		
		$rapiduserid = $id;
		$avatar_upload_api = \Yii::$app -> params['avatar_upload_api'];
		$avatar_upload_api = str_ireplace('{rapiduserid}', $rapiduserid, $avatar_upload_api);
		
		$sendHeaders = array(
            "Content-type: application/json",
            "Authorization: RA $id:$token",
        );
		
		$filename = $_FILES['imagefile']['name'];
	    $filedata = $_FILES['imagefile']['tmp_name'];
		//$filecontent = file_get_contents($filedata);
	    $filesize = $_FILES['imagefile']['size'];
		
	    //echo "DEBUG: (before) <pre>"; print_r($_FILES);print_r($sendHeaders); exit;
		if (!empty($filedata)){
	    
	        //$postfields = array("filedata" => "@$filedata", "filename" => $filename, "filecontent"=>$filecontent);
	        $postfields = array("filedata" => "@".$filedata, "filename" => $filename);
	        $ch = curl_init();
	        $options = array(
	            CURLOPT_URL => $avatar_upload_api,
	            CURLOPT_HEADER => true,
	            CURLOPT_POST => true,
	            //CURLOPT_SAFE_UPLOAD=>true,
	            CURLOPT_UPLOAD=>true,
	            CURLINFO_HEADER_OUT=>true,
	            CURLOPT_HTTPHEADER => $sendHeaders,
	            CURLOPT_POSTFIELDS => $postfields,
	            CURLOPT_INFILESIZE => $filesize,
	            CURLOPT_RETURNTRANSFER => true
	        ); // cURL options
	        
	        curl_setopt_array($ch, $options);
			
	        $res=curl_exec($ch);
			$headers = curl_getinfo($ch);		
			$http_code=$headers['http_code'];
			curl_close($ch);
			echo "$http_code DEBUG: (after) <pre>"; print_r($postfields);print_r($headers); exit;
			
		}
		
		return 	$http_code; 			
		
	}
	
	private function logoutUser() {
		$session = Yii::$app->session;
		$session->open();
		        
        $id = $session['accountInfo']['id'];
        $atoken = $session['accountInfo']['token'];
        $headers = array(
            "Content-type: application/json",
            "Authorization: RA $id:$atoken",
        );
        $ch = curl_init();
        $rapiduserid = $id;
		$logout_api = \Yii::$app -> params['logout_api'];
		$logout_api = str_ireplace('{rapiduserid}', $rapiduserid, $logout_api);
		
        curl_setopt($ch, CURLOPT_URL, $logout_api);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");

        $response = curl_exec($ch);
        curl_close($ch);
        session_destroy();
    }
}