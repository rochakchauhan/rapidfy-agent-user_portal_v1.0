<?php   
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>
  <?php $url=Url::base(); $form=ActiveForm::begin(['action' => $url.'/index.php?r=site/login','id'=>'login-form']); ?>
    <div class="form-signin">
        <h2 class="form-signin-heading">sign in now</h2>
        <div class="login-wrap">
            <input type="email" class="form-control" name="emailid" placeholder="User ID" autofocus>
            <input type="password" class="form-control" style="margin-top:5px" name="password" placeholder="Password">
            <label class="checkbox">
                <input type="checkbox" value="remember-me" style="display:none">
                <span class="pull-right" style="display:none">
                    <a data-toggle="modal" href="#myModal"> Forgot Password?</a>

                </span>
            </label>
            <button class="btn btn-lg btn-login btn-block" type="submit">Sign in</button>
            <p>or you can sign in via social network</p>
            <div class="login-social-link">
                <a href="index.php?r=site/auth&authclient=facebook" class="facebook">
                    <i class="fa fa-facebook"></i>
                    Facebook

                </a>
                <a href="index.php?r=site/auth&authclient=google" class="twitter">
                    <i class="fa fa-google-plus"></i>
                    Google Plus
                </a>
            </div>
            <div class="registration" >
                <?php if(Yii::$app->session->hasFlash('error')): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= Yii::$app->session->getFlash('error') ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>

        </div>
    <?php ActiveForm::end(); ?>
    <?php  
    if(isset($FBuserExist))
  { ?>
      <div class="modal fade modal-dialog-center" id="myModal6" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm Fberror">
            <div class="modal-content-wrap">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Login Error</h4>
                    </div>
                    <div class="modal-body">

                        <?= isset($FBuserExist)?$FBuserExist:'' ?>
                        <?php if(isset($_SESSION['FBuserExist']))
                                {   unset($_SESSION['FBuserExist']); } ?>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <style type="text/css">
      .Fberror{
          z-index: 99999 !important;
      }
    </style>
  <?php } ?>
<style type="text/css">
.login-social-link a {
    padding: 15px 20px !important;
}
.form-signin .form-control {
    font-size: 11px !important;
}
</style>