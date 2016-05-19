<?php
namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Session;

/**
 * JobInbox controller
 */
class JobinboxController extends Controller
{
	public function actionIndex()
    {
    	\Yii::$app -> get('utility') -> checkIfLoggedIn();
		
		$params=array();			
		$params['getUserInfo']=$getUserInfo=\Yii::$app -> get('utility') ->getUserInfo();
		$params['countryName']="";
		if(!empty($getUserInfo['mobileCountryId'])){
			$countriesArray = \Yii::$app -> params['countriesArray'];
			$params['countryName']=@$countriesArray[$getUserInfo['mobileCountryId']];
		}
    	return $this->render('index', $params); 
		exit();
		
    }
	
	public function actionGetmessages(){
		\Yii::$app -> get('utility') -> checkIfLoggedIn();		
		//$_POST['href']="/users/92e3a438-32cc-11e5-a280-126b5d3831bb/requests/8560/responses/386582";		
		$return=array();			
		if(!isset($_POST['href']) || empty($_POST['href'])){
			$return['server_error']="No HREF found.";
		}
		else{
			$href=$_POST['href'];
			$responses_id=\Yii::$app -> get('utility') ->sanitizeString($href);
			
			$getUserInfo=\Yii::$app -> get('utility') ->getUserInfo();		
			$id=$getUserInfo['id'];
			$token=$getUserInfo['token']; 
			
			//$href="http://api.rapidassign.com/v3".$href."/messages";
			$href=\Yii::$app -> params['base_api'].$href;
						
			$res = \Yii::$app -> get('utility') -> getViaCurl($href,$id,$token);			
			$response = json_decode($res['response'], TRUE);			
			/*
			echo "PARAM: $href <pre>"; 
			print_r($res); 
			print_r($response); exit;
			*/			
			$http_code = @$res['headers']['http_code'];
			if($http_code==200 || $http_code==201){
				$return=$response;
			}
			else{
				$return['server_error']="ERROR: Could not get messages.";
			}			
		}
		echo json_encode($return);	
	}
	
	public function actionMessage(){
		\Yii::$app -> get('utility') -> checkIfLoggedIn();
		$return=array();
		
		if(!isset($_POST['request_id']) || empty($_POST['request_id'])){
			$return['server_error']="No Request ID found.";
		}
		elseif(!isset($_POST['responses_id']) || empty($_POST['responses_id'])){
			$return['server_error']="No Response ID found.";
		}
		elseif(!isset($_POST['content']) || empty($_POST['content'])){
			$return['server_error']="No Message found.";
		}
		else{
			$request_id=$_POST['request_id'];
			$responses_id=$_POST['responses_id'];
			$content=$_POST['content'];
			$request_id=\Yii::$app -> get('utility') ->sanitizeString($request_id);
			$responses_id=\Yii::$app -> get('utility') ->sanitizeString($responses_id);
			$content=\Yii::$app -> get('utility') ->sanitizeString($content);
			
			$getUserInfo=\Yii::$app -> get('utility') ->getUserInfo();		
			$id=$getUserInfo['id'];
			$token=$getUserInfo['token'];
			
			$respond_conversations= \Yii::$app -> params['respond_conversations'];
			$respond_conversations = str_ireplace('{rapiduserid}', $id, $respond_conversations);
			$respond_conversations = str_ireplace('{req_id}', $request_id, $respond_conversations);
			$respond_conversations = str_ireplace('{responses_id}', $responses_id, $respond_conversations);
			
			$messageArray=array();
			$messageArray['messageInfo']['content']=$content;
			$messageArray['messageInfo']['contentType']='Text';
			$messageArray['messageInfo']['source']=0;
			$params2=json_encode($messageArray);
			
			$res = \Yii::$app -> get('utility') -> postViaCurl($respond_conversations, $params2,TRUE,TRUE);
			$response = json_decode($res['response'], TRUE);
			$http_code = @$res['headers']['http_code'];
			//echo "DEBUG: <pre>"; print_r($params2); print_r($res); print_r($response); exit;
			if($http_code==200 || $http_code==201){
					$return=$response;
			}
			else{
				$return['server_error']="ERROR: Could not send Message.";
			}
			
		}
		echo json_encode($return);
	}
	
	public function actionRequestinbox(){
		\Yii::$app -> get('utility') -> checkIfLoggedIn();		
		$return=array(); 	
		$page=1;
		if(isset($_POST['page']) && !empty($_POST['page'])){
			$page=$_POST['page'];
		}
		$getUserInfo=\Yii::$app -> get('utility') ->getUserInfo();		
		$id=$getUserInfo['id'];
		$token=$getUserInfo['token'];
				
		$requestinbox_api = \Yii::$app -> params['requestinbox_api'];
		$requestinbox_api = str_ireplace('{rapiduserid}', $id, $requestinbox_api);
		$requestinbox_api = str_ireplace('{page}', $page, $requestinbox_api);
		$res = \Yii::$app -> get('utility') -> getViaCurl($requestinbox_api, $id,$token);
		$response=json_decode($res['response'],TRUE);
		//echo "DEBUG: <pre>"; print_r($res); print_r($response); exit;
		if(empty($res['response'])){
			$return['server_error']="No tasks assigned";
		}
		else{
			$response = $res['response'];
			$return = json_decode($response,TRUE);
		}
		echo json_encode($return);
	}
	
	public function actionRequestdetail(){
		\Yii::$app -> get('utility') -> checkIfLoggedIn();		
		$return=array(); 		
		//$_POST['request_id']="8560";		
		if(!isset($_POST['request_id']) || empty($_POST['request_id'])){
			$return['server_error']="No Request ID found.";
		}
		else{
			$request_id=$_POST['request_id'];
			$request_id=\Yii::$app -> get('utility') ->sanitizeString($request_id);
			
			$getUserInfo=\Yii::$app -> get('utility') ->getUserInfo();		
			$id=$getUserInfo['id'];
			$token=$getUserInfo['token'];
			
			$request_details = \Yii::$app -> params['request_details'];
			$request_details = str_ireplace('{rapiduserid}', $id, $request_details);
			$request_details = str_ireplace('{req_id}', $request_id, $request_details);
			$res1 = \Yii::$app -> get('utility') -> getViaCurl($request_details, $id,$token);
			$response1=json_decode($res1['response'],TRUE);
			//echo "DEBUG: <pre>"; print_r($res1); print_r($response1); exit;
			if(empty($res1['response'])){
				$return['server_error']="No tasks assigned";
			}
			else{
				$response = $res1['response'];
				$return = json_decode($response,TRUE);
			}
		}
		$countriesArray=Yii::$app->params['countriesArray'];
		$return['requestInfo']['CountryName']=$countriesArray[$return['requestInfo']['countryId']];
			
		//echo "DEBUG: <pre>"; print_r($return); exit;
		echo json_encode($return);
	} 
	
	public function actionResponsedetail(){
		\Yii::$app -> get('utility') -> checkIfLoggedIn();		
		$return=array(); 
		
		//$_POST['response_id']="8560";
		//$_POST['request_id']="386582";
		
		if(!isset($_POST['response_id']) || empty($_POST['response_id'])){
			$return['server_error']="No Response ID found.";
		}
		elseif(!isset($_POST['request_id']) || empty($_POST['request_id'])){
			$return['server_error']="No Request ID found.";
		}
		else{
			$request_id=$_POST['request_id'];
			$request_id=\Yii::$app -> get('utility') ->sanitizeString($request_id);
			$response_id=$_POST['response_id'];
			$response_id=\Yii::$app -> get('utility') ->sanitizeString($response_id);
						
			$getUserInfo=\Yii::$app -> get('utility') ->getUserInfo();		
			$id=$getUserInfo['id'];
			$token=$getUserInfo['token'];
			
		
			$responder_details_api = \Yii::$app -> params['responder_details_api'];
			$responder_details_api = str_ireplace('{rapiduserid}', $id, $responder_details_api);
			$responder_details_api = str_ireplace('{req_id}', $response_id, $responder_details_api);
			$responder_details_api = str_ireplace('{responses_id}', $request_id, $responder_details_api);
			$res = \Yii::$app -> get('utility') -> getViaCurl($responder_details_api, $id,$token);
			
			$response=json_decode($res['response'],TRUE);
			//echo "DEBUG: <pre>"; print_r($res); print_r($response); exit;
		
			if(empty($res['response'])){
				$return['server_error']="No tasks assigned";
			}
			else{
				$response = $res['response'];
				$return = json_decode($response,TRUE);
			}
		}
		//echo "DEBUG: <pre>"; print_r($return); exit;
		echo json_encode($return);
	}
	
	public function actionTasks(){
		\Yii::$app -> get('utility') -> checkIfLoggedIn();
		
		$getUserInfo=\Yii::$app -> get('utility') ->getUserInfo();		
		$id=$getUserInfo['id'];
		$token=$getUserInfo['token'];
		
		$all_tasks_api = \Yii::$app -> params['all_tasks_api'];
		$all_tasks_api = str_ireplace('{rapiduserid}', $id, $all_tasks_api);
		$res = \Yii::$app -> get('utility') -> getViaCurl($all_tasks_api, $id,$token);
		
		if(empty($res['response'])){
			$return['server_error']="No tasks assigned";
		}
		else{
			$response = $res['response'];
			$return = json_decode($response,TRUE);
		}
		echo json_encode($return);
	}
	
	public function actionRequests(){
		\Yii::$app -> get('utility') -> checkIfLoggedIn();
		
		$return=array();
		$getUserInfo=\Yii::$app -> get('utility') ->getUserInfo();		
		$id=$getUserInfo['id'];
		$token=$getUserInfo['token'];
		
		$all_requests_api = \Yii::$app -> params['all_requests_api'];
		$all_requests_api = str_ireplace('{rapiduserid}', $id, $all_requests_api);
		$res = \Yii::$app -> get('utility') -> getViaCurl($all_requests_api, $id,$token);
		
		if(empty($res['response'])){
			$return['server_error']="No request assigned";
		}
		else{
			$response = $res['response'];
			$response = json_decode($response,TRUE);
			$conversations=$statuses=array();
			
			if(!isset($response['requestInfo']['items'])){
				$return['conversations']=array();
			}
			else{
				foreach($response['requestInfo']['items'] as $item ){
					$tmp=array();
					$tmp['SN']=$item['serviceName'];
					$tmp['status']=$item['status'];
					$tmp['request_id']=$item['id'];
					$requestImage=$item['requestImage'];
					$tmp['responses_id']=$requestImage['0']['id'];
					$conversations[$item['id']]=json_encode($tmp);
					$return = $response;
					$return['conversations']=$conversations;
				}
			}
		}
		//echo "DEBUG: <pre>"; print_r($return); exit;
		echo json_encode($return);
	}
	
	//@Todo
	public function actionInbox(){
		if(isset($_POST['kw']) && !empty($_POST['kw'])){	
			$kw=trim($_POST['kw']);
			$kw=\Yii::$app -> get('utility') -> sanitizeString($kw);
			$kw=strtolower($kw);
			$kw=ucwords($kw);
						
			$return=array();
			$return[]=array("n"=>"Jonathan Smith",	"m"=>"Hello Anjelina are you there?",	"t"=>"12:30");
			$return[]=array("n"=>"Anjelina",		"m"=>"I am great. How about you ?",	"t"=>"12:31");
			$return[]=array("n"=>"Jonathan Smith",	"m"=>"Good, so can you please send your detailed quote for <b>$kw</b>",	"t"=>"12:32");
			$return[]=array("n"=>"Anjelina",		"m"=>"Your email ?",			"t"=>"12:33");
			
			echo json_encode($return);
		}
	}
	
	/**
	 * Function to get details of a resquest as an JSON object
	 * 
	 * @param string $req_id	 * 
	 * @return json
	 */
	public function actionGetrequestdetails(){
		$return=array();
		//$_POST['req_id']="4713d1";
		//$_POST['req_id']="91618111d556";
		if(!isset($_POST['req_id']) || empty($_POST['req_id'])){
			$return['server_error']="No Request ID found.";
		}
		else{				
			$getUserInfo=\Yii::$app -> get('utility') ->getUserInfo();		
			if(!isset($getUserInfo['id'])){	
				$return['server_error']="User not logged in";
			}
			else{
				$id=$getUserInfo['id'];
				$token=$getUserInfo['token'];
				$req_id=$_POST['req_id'];
				$req_id=\Yii::$app -> get('utility') ->sanitizeString($req_id);
				
				$request_details = \Yii::$app -> params['request_details'];
				$request_details = str_ireplace('{rapiduserid}', $id, $request_details);
				$request_details = str_ireplace('{req_id}', $req_id, $request_details);
				$res = \Yii::$app -> get('utility') -> getViaCurl($request_details, $id,$token);
				
				if(empty($res['response'])){
					$return['server_error']="No request assigned";
				}
				else{
					$return=$res['response'];
				}
			}
		}		
		echo json_encode($return);	
	}

	/**
	 * Function to get all resquests as an JSON object
	 * 
	 * @return json
	 */
	public function actionGetallrequests(){
		$return=array();
				
		$getUserInfo=\Yii::$app -> get('utility') ->getUserInfo();		
		if(!isset($getUserInfo['id'])){	
			$return['server_error']="User not logged in";
		}
		else{
			$id=$getUserInfo['id'];
			$token=$getUserInfo['token'];
			
			$all_requests_api = \Yii::$app -> params['all_requests_api'];
			$all_requests_api = str_ireplace('{rapiduserid}', $getUserInfo['id'], $all_requests_api);
			$res = \Yii::$app -> get('utility') -> getViaCurl($all_requests_api, $id,$token);
			
			if(empty($res['response'])){
				$return['server_error']="No request assigned";
			}
			else{
				$return=$res['response'];
			}
		}
		
		echo json_encode($return);	
	}
	
	/**
	 * Get logged in time of current user  
	 */
	public function actionGetloggedintime(){
		$includeSeconds=TRUE;
		$time=\Yii::$app -> get('utility') ->getLoggedInTime($includeSeconds);
		echo $time;
	}
	
	/**
	 * Get details of the reply/message
	 * 
	 * @param string $ref
	 * @param string $sref
	 * 
	 * @return JSON
	 */
	public function actionGetreplydetails(){
		$return=array();
		
		$_POST['ref']="4713d1";
		$_POST['sref']="91618111d556";
		
		if(isset($_POST['ref']) && isset($_POST['sref'])){
			$getUserInfo=\Yii::$app -> get('utility') ->getUserInfo();		
			if(!isset($getUserInfo['id'])){	
				$return['server_error']="User not logged in";
			}
			else{	
				$id=$getUserInfo['id'];
				$token=$getUserInfo['token'];
				$ref=\Yii::$app -> get('utility') ->sanitizeString($_POST['ref']);
				$sref=\Yii::$app -> get('utility') ->sanitizeString($_POST['sref']);
				
				$reply_api= \Yii::$app -> params['reply_api'];
				$reply_api = str_ireplace('{ref}', $ref, $reply_api);
				$reply_api = str_ireplace('{sref}', $sref, $reply_api);
				$res = \Yii::$app -> get('utility') -> getViaCurl($reply_api, $id,$token);
				
				if(empty($res['response'])){
					$return['server_error']="No reply found";
				}
				else{
					$response=json_decode($res['response'],TRUE);
					$return=$response;
				}
			}
		}
		else{
			$return['server_error']="No parameters found";
		}
		echo json_encode($return);
	}
}