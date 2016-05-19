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
 * Home controller
 */
class HomeController extends Controller {

	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return ['access' => ['class' => AccessControl::className(), 'only' => ['signup'], 'rules' => [['actions' => ['signup'], 'allow' => true, 'roles' => ['?'], ], ], ], ];
	}

	/**
	 * @inheritdoc
	 */
	public function actions() {
		return ['error' => ['class' => 'yii\web\ErrorAction', ], 'captcha' => ['class' => 'yii\captcha\CaptchaAction', 'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null, ], 'auth' => ['class' => 'yii\authclient\AuthAction', 'successCallback' => [$this, 'actionoAuthSuccess'], ], ];
	}

	public function actionoAuthSuccess($client) {
		// get user data from client

		$userAttributes = $client -> getUserAttributes();

		if (isset($userAttributes['kind'])) {
			$gpId = $userAttributes['id'];
			$gpEmail = $userAttributes['emails'][0]['value'];
			$gpName = $userAttributes['displayName'];
			$gpAvatar = $userAttributes['image']['url'];
			$ch = curl_init();

			$google_login_api = \Yii::$app -> params['google_login_api'];
			curl_setopt($ch, CURLOPT_URL, $google_login_api);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, FALSE);
			curl_setopt($ch, CURLOPT_POST, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, "{
              \"accountInfo\": {
                \"gpId\": $gpId,
                \"gpEmail\": \"$gpEmail\",
                \"gpName\": \"$gpName\",
                \"gpLink\": \"https://plus.google.com/$gpId\",
                \"gpAvatar\": \"$gpAvatar\",
                \"language\": \"1\",
                \"appVersion\": \"1.3.0\",
                \"browser\": \"Chrome/47.0.2526.106\"
              }
            }");

			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));

			$response = curl_exec($ch);
			curl_close($ch);
			$Gpusrdata = json_decode($response, true);
			$accountInfo=$Gpusrdata['accountInfo'];
			
			if(isset($accountInfo['id']) && isset($accountInfo['token'])) {
				//TODO					
				//echo "G+ DATA <pre>"; print_r($Gpusrdata);  print_r($userAttributes); exit;
				
				$accountInfo['mobileCountryId']=199;
				$accountInfo['mobileNum']="+1";
				$accountInfo['email']=@$accountInfo['gpEmail'];
				extract($accountInfo);
				
				\Yii::$app -> get('utility') -> signInUser($accountInfo);
				$redirectUrl = Yii::$app -> getUrlManager() -> createUrl("inbox");
				return $this -> redirect($redirectUrl, 302);
				exit();	
			}
			else{
				\Yii::$app -> getSession() -> setFlash('reset_msg', "Please register via Google account from the mobile App.");
				$loginUrl = Yii::$app -> getUrlManager() -> createUrl("home/login");
				return $this -> redirect($loginUrl, 302);
				exit;
			}
			/*
			exit;	
			
			if (isset($Gpusrdata['status']) && $Gpusrdata['status'] == '400') {
				$_SESSION['FBuserExist'] = $Gpusrdata['message'];
			} else {

				if (!empty($Gpusrdata['accountInfo']) && isset($Gpusrdata['accountInfo'])) {
					$_SESSION['rapiduserid'] = $Gpusrdata['accountInfo']['id'];
					$_SESSION['atoken'] = $Gpusrdata['accountInfo']['token'];
					$_SESSION['udata'] = $udata = $this -> GetUserPaymentdata($Gpusrdata['accountInfo']['id'], $Gpusrdata['accountInfo']['token']);
					$_SESSION['userdata']['username'] = $Gpusrdata['accountInfo']['username'];
					$_SESSION['userdata']['avatarImage'] = $Gpusrdata['accountInfo']['avatarImage'];
				}
			}
			return $this -> render('accountmanager//index', ['data' => isset($_SESSION['userdata']) ? $_SESSION['userdata'] : array(), ]);
			*/
		} else {
				
				
			$name = $userAttributes['name'];
			$fbid = $userAttributes['id'];
			$email = $userAttributes['email'];
			$ch = curl_init();
			
			$fb_login_api = \Yii::$app -> params['fb_login_api'];
			curl_setopt($ch, CURLOPT_URL, $fb_login_api);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, FALSE);
			curl_setopt($ch, CURLOPT_POST, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, "{
            \"accountInfo\": {
              \"fbId\": $fbid,
              \"fbEmail\": \"$email\",
              \"fbName\": \"$name\",
              \"fbLink\": \"https://www.facebook.com/app_scoped_user_id/$fbid/\",
              \"language\": \"1\",
              \"appVersion\": \"1.3.0\",
              \"browser\": \"Chrome/47.0.2526.106\"
            }
          }");

			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));

			$response = curl_exec($ch);
			curl_close($ch);

			$Fbusrdata = json_decode($response, true);
			$accountInfo=@$Fbusrdata['accountInfo'];
			
			if(isset($accountInfo['id']) && isset($accountInfo['token'])) {
				//echo "<pre>"; print_r($accountInfo); exit;
				$accountInfo['mobileCountryId']=199;
				$accountInfo['email']=$accountInfo['fbEmail'];
				$accountInfo['mobileNum']="+1";
				
				extract($accountInfo);
				\Yii::$app -> get('utility') -> signInUser($accountInfo);
				$redirectUrl = Yii::$app -> getUrlManager() -> createUrl("inbox");
				return $this -> redirect($redirectUrl, 302);
				exit();		
			}
			else{
				\Yii::$app -> getSession() -> setFlash('reset_msg', "Please register via FB account from the mobile App.");
				$loginUrl = Yii::$app -> getUrlManager() -> createUrl("home/login");
				return $this -> redirect($loginUrl, 302);
				exit;				
			}	
			/*
			exit;
			echo "<pre>=> FB Data"; print_r($Fbusrdata); exit;
			
			$name=$userAttributes['name'];
          	$fbid=$userAttributes['id'];
          	$email=$userAttributes['email'];  
		  	$status=$Fbusrdata['status'];
			
			if($status=="200"){
				echo "DEBUG: ==> <pre>"; print_r($Fbusrdata); exit;	
			}
			else{
				\Yii::$app->getSession()->setFlash('reset_msg', $Fbusrdata['message']);
				$redirectUrl = Yii::$app -> getUrlManager() -> createUrl("home/login");
				return $this -> redirect($redirectUrl, 302);
				exit();
			}			
			*/
		}

	}

	/**
	 * Displays HomePage.
	 *
	 * @return string
	 */
	public function actionIndex() {
		\Yii::$app -> get('utility') -> checkIfLoggedIn();
		$pagename = "Homepage";
		return $this -> render('index', ['pagename' => $pagename]);
		exit();
	}

	/**
	 * Logs out the local and remote Session
	 *
	 * @return NULL
	 */
	public function actionLogout() {
		\Yii::$app -> get('utility') -> signOutUser();
		$redirectUrl = Yii::$app -> getUrlManager() -> createUrl("home/login");
		return $this -> redirect($redirectUrl, 302);
		exit();
	}

	public function actionRegistration() {
		$LoggedIn = \Yii::$app -> get('utility') -> isUserLoggedIn();
		if ($LoggedIn === TRUE) {
			$redirectUrl = Yii::$app -> getUrlManager() -> createUrl("inbox");
			return $this -> redirect($redirectUrl, 302);
			exit();
		}

		$loginUrl = Yii::$app -> getUrlManager() -> createUrl("home/login");
		$submitUrl = Yii::$app -> getUrlManager() -> createUrl("home/submit");
		$countriesArray = \Yii::$app -> params['countriesArray'];

		$params = array();
		$params['loginUrl'] = $loginUrl;
		$params['submitUrl'] = $submitUrl;
		$params['countriesArray'] = $countriesArray;
		$params['email'] = "";
		$params['username'] = "";
		$params['country'] = "";

		return $this -> renderPartial('registration', $params);
	}

	public function actionSubmit() {

		if (isset($_POST['_csrf']) && !empty($_POST['_csrf'])) {
			$message = array();
			if ($_POST['password'] != $_POST['password2']) {
				$message[] = '<br />Passwords do not match. Please try again';
			} elseif (strlen(trim($_POST['password'])) < 6) {
				$message[] = '<br />Password can not be less than 6 charactors.';
			}
			if ($_POST['country'] == "SELECT") {
				$message[] = '<br />Please choose a country.';
			}
			if (count($message) > 0) {
				$loginUrl = Yii::$app -> getUrlManager() -> createUrl("home/login");
				$submitUrl = Yii::$app -> getUrlManager() -> createUrl("home/submit");
				$countriesArray = \Yii::$app -> params['countriesArray'];

				$parameters = array();
				$parameters['message'] = $message;
				$parameters['loginUrl'] = $loginUrl;
				$parameters['submitUrl'] = $submitUrl;
				$parameters['countriesArray'] = $countriesArray;
				$parameters['country'] = $_POST['country'];
				$parameters['username'] = $_POST['username'];
				$parameters['email'] = $_POST['email'];

				return $this -> renderPartial('registration', $parameters);
				exit();
			}

			$params = array();
			$params["accountInfo"]["username"] = $_POST['username'];
			$params["accountInfo"]["email"] = $_POST['email'];
			$params["accountInfo"]["password"] = $_POST['password'];
			$params["accountInfo"]["mobileCountryId"] = $_POST['country'];
			//$params["accountInfo"]["mobileNum"]=$_POST['mobile'];
			$params["accountInfo"]["pushId"] = "1111111111111111111111111111111111111111111111111temppushid";
			$params["accountInfo"]["vendor"] = "4";
			$params["accountInfo"]["osVersion"] = "0";
			$params["accountInfo"]["platform"] = "0";
			$params["accountInfo"]["model"] = "0";
			$params["accountInfo"]["screenWidth"] = "0";
			$params["accountInfo"]["screenHeight"] = "0";
			$params["accountInfo"]["language"] = "1";
			$params["accountInfo"]["appVersion"] = "1.3.0";
			$params["accountInfo"]["referrer"] = "";
			$params2 = json_encode($params);

			$register_api = \Yii::$app -> params['register_api'];
			$res = \Yii::$app -> get('utility') -> callApi($register_api, $params2);
			$response = json_decode($res['response'], TRUE);
			$http_code = @$res['headers']['http_code'];
			//echo "DEBUG: <pre>"; print_r($res); print_r($response); exit;
			if ($http_code == "200" || $http_code == "201") {
				$accountInfo = $response['accountInfo'];
				\Yii::$app -> get('utility') -> signInUser($accountInfo);
				$redirectUrl = Yii::$app -> getUrlManager() -> createUrl("inbox");
				return $this -> redirect($redirectUrl, 302);
				exit ;
			} else {
				$message[] = $response['message'];
				$loginUrl = Yii::$app -> getUrlManager() -> createUrl("home/login");
				$submitUrl = Yii::$app -> getUrlManager() -> createUrl("home/submit");
				$countriesArray = \Yii::$app -> params['countriesArray'];

				$parameters = array();
				$parameters['message'] = $message;
				$parameters['loginUrl'] = $loginUrl;
				$parameters['submitUrl'] = $submitUrl;
				$parameters['countriesArray'] = $countriesArray;
				$parameters['country'] = $_POST['country'];
				$parameters['username'] = $_POST['username'];
				$parameters['email'] = $_POST['email'];

				return $this -> renderPartial('registration', $parameters);
				exit();
			}
		} else {
			$redirectUrl = Yii::$app -> getUrlManager() -> createUrl("home/registration");
			return $this -> redirect($redirectUrl, 302);
			exit();
		}
	}

	public function actionResetpassword() {
		$LoggedIn = \Yii::$app -> get('utility') -> isUserLoggedIn();
		if (isset($_POST['resetemail']) && !empty($_POST['resetemail'])) {
			$resetemail = $_POST['resetemail'];

			$params = array();
			$params["accountInfo"]["email"] = $resetemail;
			$params["accountInfo"]["mobileCountryId"] = "";
			$params["accountInfo"]["mobileNum"] = "";
			$params2 = json_encode($params);

			$forgot_password_api = \Yii::$app -> params['forgot_password_api'];
			$res = \Yii::$app -> get('utility') -> callApi($forgot_password_api, $params2);
			$response = json_decode($res['response'], TRUE);
			$http_code = @$res['headers']['http_code'];
			//echo "DEBUG: <pre>"; print_r($res); print_r($response); exit;
			if ($http_code == "200" || $http_code == '204') {
				\Yii::$app -> getSession() -> setFlash('reset_msg', 'Please check your email to reset the Password.');
			} else {
				\Yii::$app -> getSession() -> setFlash('reset_msg', $response['message']);
			}
			//echo "RESET PASS: <pre>"; print_r($_POST); print_r($res); exit;

		}

		$loginUrl = Yii::$app -> getUrlManager() -> createUrl("home/login");
		return $this -> redirect($loginUrl, 302);
		exit();
	}

	public function actionLogin() {
		\Yii::$app -> get('utility') -> signOutUser();
		/*	
		$LoggedIn = \Yii::$app -> get('utility') -> isUserLoggedIn();
		if ($LoggedIn === TRUE) {
			$redirectUrl = Yii::$app -> getUrlManager() -> createUrl("inbox");
			return $this -> redirect($redirectUrl, 302);
			exit();
		}
		*/
		$actionUrl = Yii::$app -> getUrlManager() -> createUrl("home/validate");
		$registrationUrl = Yii::$app -> getUrlManager() -> createUrl("home/registration");
		$resetpassword = Yii::$app -> getUrlManager() -> createUrl("home/resetpassword");

		$params = array();
		$params['actionUrl'] = $actionUrl;
		$params['registrationUrl'] = $registrationUrl;
		$params['resetpassword'] = $resetpassword;

		echo $this -> renderPartial('login', $params, false);
	}

	public function actionValidate() {
		if (isset($_POST['username']) && !empty($_POST['username'])) {
			$params = array();
			$params["accountInfo"]["email"] = $_POST['username'];
			$params["accountInfo"]["pushId"] = 'sdhjvdfkdjfhdfsfdsdfssfd$54k23798fhksdj293dsk';
			$params["accountInfo"]["password"] = $_POST['password'];
			$params["accountInfo"]["vendor"] = "4";
			$params["accountInfo"]["osVersion"] = "0";
			$params["accountInfo"]["platform"] = "web";
			$params["accountInfo"]["model"] = "web";
			$params["accountInfo"]["screenWidth"] = "0";
			$params["accountInfo"]["screenHeight"] = "0";
			$params["accountInfo"]["language"] = "1";
			$params["accountInfo"]["appVersion"] = "1";
			$params2 = json_encode($params);
			$register_api = \Yii::$app -> params['login_api'];
			$res = \Yii::$app -> get('utility') -> callApi($register_api, $params2);
			$http_code = @$res['headers']['http_code'];
			$response = json_decode($res['response'], TRUE);
			if ($http_code == 200) {
				$accountInfo = $response['accountInfo'];
				\Yii::$app -> get('utility') -> signInUser($accountInfo);
				$redirectUrl = Yii::$app -> getUrlManager() -> createUrl("inbox");
				//$redirectUrl = Yii::$app -> getUrlManager() -> createUrl("home");
				return $this -> redirect($redirectUrl, 302);
				exit ;
			} else {
				$actionUrl = Yii::$app -> getUrlManager() -> createUrl("home/validate");
				$registrationUrl = Yii::$app -> getUrlManager() -> createUrl("home/registration");

				$params = array();
				$params['actionUrl'] = $actionUrl;
				$params['registrationUrl'] = $registrationUrl;
				$params['error'] = "Invalid Email or Password. Please try again";
				$params['resetpassword'] = Yii::$app -> getUrlManager() -> createUrl("home/resetpassword");
				
				echo $this -> renderPartial('login', $params, false);
				exit();
			}
		} else {
			$loginUrl = Yii::$app -> getUrlManager() -> createUrl("home/login");
			return $this -> redirect($loginUrl, 302);
			exit();
		}
	}

}
