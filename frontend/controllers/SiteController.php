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
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => [ 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    
                ],
            ],
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
           'auth' => [
              'class' => 'yii\authclient\AuthAction',
              'successCallback' => [$this, 'actionoAuthSuccess'],
            ],
        ];
    }

    public function actionoAuthSuccess($client) {
    // get user data from client
        
        $userAttributes = $client->getUserAttributes();

        if(!empty($_SESSION['userdata'])){session_unset($_SESSION['userdata']);}

        if(isset($userAttributes['kind']))
        {
            $gpId=$userAttributes['id'];
            $gpEmail=$userAttributes['emails'][0]['value'];
            $gpName=$userAttributes['displayName'];
            $gpAvatar=$userAttributes['image']['url'];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "http://dev.api.rapidassign.com/v3/accountmanager/accounts/logingplus");
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

            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
              "Content-Type: application/json"
            ));

            $response = curl_exec($ch);
            curl_close($ch);


            $Gpusrdata=json_decode($response,true);
            

            if(isset($Gpusrdata['status']) && $Gpusrdata['status']=='400')
            {
              $_SESSION['FBuserExist']=$Gpusrdata['message'];
            }
            else
            {
              
              if(!empty($Gpusrdata['accountInfo']) &&  isset($Gpusrdata['accountInfo']))
              {
                $_SESSION['rapiduserid']=$Gpusrdata['accountInfo']['id'];
                $_SESSION['atoken']=$Gpusrdata['accountInfo']['token'];
                $_SESSION['udata']=$udata=$this->GetUserPaymentdata($Gpusrdata['accountInfo']['id'],$Gpusrdata['accountInfo']['token']);
                $_SESSION['userdata']['username']=$Gpusrdata['accountInfo']['username'];
                $_SESSION['userdata']['avatarImage']=$Gpusrdata['accountInfo']['avatarImage'];
              }
            }  
            return $this->render('accountmanager//index', [
            'data' => isset($_SESSION['userdata'])?$_SESSION['userdata']:array(),
             ]);
        }
        else
        {
          $name=$userAttributes['name'];
          $fbid=$userAttributes['id'];
          $email=$userAttributes['email'];
          $ch = curl_init();

          curl_setopt($ch, CURLOPT_URL, "http://dev.api.rapidassign.com/v3/accountmanager/accounts/loginfacebook");
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

          curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json"
          ));

          $response = curl_exec($ch);
          curl_close($ch);

          $Fbusrdata=json_decode($response,true);
          
         
          if(isset($Fbusrdata['status']) && $Fbusrdata['status']=='400')
          {
            $_SESSION['FBuserExist']=$Fbusrdata['message'];
          }
          else
          {
            if(!empty($Fbusrdata['accountInfo']) && isset($Fbusrdata['accountInfo']))
            {
              $_SESSION['rapiduserid']=$Fbusrdata['accountInfo']['id'];
              $_SESSION['atoken']=$Fbusrdata['accountInfo']['token'];
              $_SESSION['udata']=$udata=$this->GetUserPaymentdata($Fbusrdata['accountInfo']['id'],$Fbusrdata['accountInfo']['token']);
              $_SESSION['userdata']['username']=$Fbusrdata['accountInfo']['username'];
              $_SESSION['userdata']['avatarImage']=$Fbusrdata['accountInfo']['avatarImage'];
              $this->layout='main';
              

              return $this->render('accountmanager//index', [
                  'data' => isset($_SESSION['userdata'])?$_SESSION['userdata']:array(),
                  'udata'=> isset($_SESSION['udata'])?$_SESSION['udata']:array(),
              ]); 
            }
          }
          
        }
        
      
    }
    
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
    	        
        $session = new Session;
        $user_id = $session->get('userdata');
		
        if(isset($user_id) && !empty($user_id)) {
            
            $this->layout='main';
            return $this->render('accountmanager//index', [
              'udata' => isset($_SESSION['udata'])?$_SESSION['udata']:array(),
              'data' => isset($_SESSION['userdata'])?$_SESSION['userdata']:array(),
          ]);
        }
        else
        {
          
          $this->layout='login';
            return $this->render('accountmanager//login',[
                'FBuserExist' => isset($_SESSION['FBuserExist'])?$_SESSION['FBuserExist']:Null,
              ]);
        }
    }
    /**
     * Get User Data.
     *
     * @return mixed
     */
    public function Getuserdata($emailid,$password)
    {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "http://dev.api.rapidassign.com/v3/accountmanager/accounts/loginemail");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);

            curl_setopt($ch, CURLOPT_POST, TRUE);

            curl_setopt($ch, CURLOPT_POSTFIELDS, "{
              \"accountInfo\": {
                \"email\": \"$emailid\",
                \"password\": \"$password\",
                \"language\": \"1\",
                \"appVersion\": \"1.3.0\",
                \"browser\": \"Chrome/47.0.2526.106\"
              }
            }");

            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
              "Content-Type: application/json"
            ));

            $response = curl_exec($ch);
            curl_close($ch);
           // $userData=jsonparse($response);
            $userdata=json_decode($response,true);
            
            return isset($userdata['accountInfo'])?$userdata['accountInfo']:$userdata;
    }

    function GetUserPaymentdata($id,$atoken)
    {
        $headers = array(
            "Content-type: application/json",
            "Authorization: RA $id:$atoken",
        );
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "http://dev.api.rapidassign.com/v3/accountmanager/users/".$id."/dashboard");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);
        
        return json_decode($response,true);
    }
    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
      
        $this->layout='login';
        $session = new Session;

        $model = new LoginForm();
        $FBuserExist = isset($_SESSION['FBuserExist'])?$_SESSION['FBuserExist']:Null;
        if (Yii::$app->request->post()) 
        {
                
                $emailid= $_POST['emailid'];
                $password=$_POST['password'];
                
                $userdata=$_SESSION['userdata']=$this->Getuserdata($emailid,$password);
                $session->set('userdata', $userdata);

                if(isset($_SESSION['userdata']['id']) && !empty($_SESSION['userdata']['id']))
                {
                  
                  $id=isset($_SESSION['userdata']['id'])?$_SESSION['userdata']['id']:'';
                  $_SESSION['rapiduserid']=$_SESSION['userdata']['id'];
                  $_SESSION['atoken']=$_SESSION['userdata']['token'];
                  $_SESSION['udata']=$udata=$this->GetUserPaymentdata($_SESSION['userdata']['id'],$_SESSION['userdata']['token']);
                  
                  $this->layout='main';
                  return $this->render('accountmanager//index', [
                      'data' => $_SESSION['userdata'],
                      'udata'=> $udata,
                  ]);
                }
                else
                {

                  Yii::$app->session->setFlash('error', isset($_SESSION['userdata']['message'])?$_SESSION['userdata']['message']:Null);
                  return $this->render('accountmanager//login', [
                    'model' => $model,]);
                }
        } 
        else 
        {
            
            $user_id = $session->get('userdata');

            if($user_id) {
                
                $this->layout='main';
                return $this->render('accountmanager//index', [
                  'udata' => isset($_SESSION['udata'])?$_SESSION['udata']:array(),
                  'data' => isset($_SESSION['userdata'])?$_SESSION['userdata']:array(),
              ]);
            } 
            else
            {
              
              $this->layout='login';
                return $this->render('accountmanager//login',[
                    'FBuserExist' => isset($_SESSION['FBuserExist'])?$_SESSION['FBuserExist']:Null,
                  ]);
            }  
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        $session = new Session;
        Yii::$app->user->logout();
        $id=$_SESSION['rapiduserid'];
        $atoken=$_SESSION['atoken'];
        $headers = array(
            "Content-type: application/json",
            "Authorization: RA $id:$atoken",
        );
        $ch = curl_init();
        $rapiduserid=isset($_SESSION['rapiduserid'])?$_SESSION['rapiduserid']:'';
        curl_setopt($ch, CURLOPT_URL, "http://dev.api.rapidassign.com/v3/accountmanager/v1/accounts/$rapiduserid/logout");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");

        $response = curl_exec($ch);
        curl_close($ch);
        foreach ($session as $name => $value) {
          if($name=='userdata'){
              session_unset($_SESSION[$name]);
              if(isset($_SESSION['udata']))
              {     }
            }
        }

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
