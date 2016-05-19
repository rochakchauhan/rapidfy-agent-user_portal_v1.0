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
 * Profile controller
 */
class ProfileController extends Controller
{

    /**
     * Displays profile.
     *
     * @return mixed
     */
    public function actionIndex()
    {
    	\Yii::$app -> get('utility') -> checkIfLoggedIn();
		
    	$param=array();
    	$param['getUserInfo']=\Yii::$app -> get('utility') -> getUserInfo();
		$param['viewProfile']= Yii::$app -> getUrlManager() -> createUrl("profile");
		$param['editProfile']= Yii::$app -> getUrlManager() -> createUrl("profile/edit");
		$param['countriesArray']=\Yii::$app->params['countriesArray'];
		
    	return $this->render('index', $param);
    }
	
	public function actionEdit()
    {
    	\Yii::$app -> get('utility') -> checkIfLoggedIn();
		
    	$param=array();
    	$param['getUserInfo']=$getUserInfo=Yii::$app -> get('utility') -> getUserInfo();
		$param['viewProfile']= Yii::$app -> getUrlManager() -> createUrl("profile");
		$param['editProfile']= Yii::$app -> getUrlManager() -> createUrl("profile/edit");
		$param['saveprofile']= Yii::$app -> getUrlManager() -> createUrl("profile/profilesave");
		$param['changepassword']=Yii::$app -> getUrlManager() -> createUrl("profile/changepassword");
		$param['updateavatar']=Yii::$app -> getUrlManager() -> createUrl("profile/updateavatar");
		$param['countriesArray']=Yii::$app->params['countriesArray'];
		
		//echo "TEST <pre>"; print_r($getUserInfo); exit;
    	return $this->render('edit', $param);
    }
	
	public function actionProfilesave()
   	{
   		\Yii::$app -> get('utility') -> checkIfLoggedIn();
		
   		if(isset($_POST['username']) && !empty($_POST['username']) ){
	   		$getUserInfo=Yii::$app -> get('utility') -> getUserInfo();
			$uuid=$getUserInfo['id'];
			$register_api=Yii::$app -> params['register_api']."/$uuid";
	    	
			$params=array();
			$params["accountInfo"]["username"]=$_POST['username'];
			$params["accountInfo"]["email"]=$_POST['email'];
			$params["accountInfo"]["mobileCountryId"]=$_POST['country'];
			$params["accountInfo"]["mobileNum"]=$_POST['mobile'];
			$params["accountInfo"]["pushId"]="1111111111111111111111111111111111111111111111111temppushid";
			$params["accountInfo"]["id"]=$getUserInfo['id'];
			$params["accountInfo"]["token"]=$getUserInfo['token'];
			
			
			$params2=json_encode($params);
			$res=\Yii::$app -> get('utility') -> callApi($register_api,$params2,TRUE,TRUE);
			$response=json_decode($res['response'],TRUE);
			$http_code=@$res['headers']['http_code'];
			//echo "$http_code DEBUG: <pre>"; print_r($res); print_r($response); exit;
			
			$msg="";
			if($http_code=="200"){
				$accountInfo=$response['accountInfo'];
				\Yii::$app -> get('utility') -> signInUser($accountInfo);					
				\Yii::$app->getSession()->setFlash('profile_msg', 'Success :: Profile Updated.');
			}
			else{
				\Yii::$app->getSession()->setFlash('profile_msg', 'Error: Could not Update Profile. Please try again.');
			}
			$redirectUrl = Yii::$app -> getUrlManager() -> createUrl("profile/edit");
			return $this -> redirect($redirectUrl, 302);
			exit();				
	   	}
		else{
			$redirectUrl = Yii::$app -> getUrlManager() -> createUrl("profile/edit");
			return $this -> redirect($redirectUrl, 302);
			exit();	
		}
	}
	
	public function actionUpdateavatar()
   	{
   		\Yii::$app -> get('utility') -> checkIfLoggedIn();
		
		
		if(isset($_FILES['imagefile']['error']) && ($_FILES['imagefile']['error']==0) ){
			//$tmp_name=$_FILES['imagefile']['tmp_name'];
			//$is_valid_jpeg= imagecreatefromjpeg ($tmp_name );
			//var_dump($is_valid_jpeg);			
			
			$id=$_POST['id'];
			$token=$_POST['token'];
			$http_code=\Yii::$app -> get('utility') -> uploadeRemoteFile($id,$token);
			 
			if($http_code==200){
				//echo "PASS <pre>"; print_r($_POST); print_r($_FILES);	exit;
				\Yii::$app->getSession()->setFlash('profile_msg', 'Success :: Avatar Updated.');
			}
			else{
				\Yii::$app->getSession()->setFlash('profile_msg', 'Failed to update Avatar. Please try again.');
			}
		}
		else{
			\Yii::$app->getSession()->setFlash('profile_msg', 'Error: Failed to update your Avatar. Please try again.');
		}
		
		$redirectUrl = Yii::$app -> getUrlManager() -> createUrl("profile/edit");
		return $this -> redirect($redirectUrl, 302);
		exit();
		
   		
	}
}