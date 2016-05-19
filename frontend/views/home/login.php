<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <meta name="google-site-verification" content="1rQbc4P5Rf9ick1RbVFItIQMJQLlIKFAvwm0cRae3NI" />
    
    <link rel="shortcut icon" href="img/favicon.png">

    <title>LOGIN :: <?php echo \Yii::$app->params['application_name']; ?></title>
   
    <!-- Bootstrap core CSS -->
    <link href="<?php echo $this->theme->baseUrl; ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $this->theme->baseUrl; ?>/css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="<?php echo $this->theme->baseUrl; ?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="<?php echo $this->theme->baseUrl; ?>/css/style.css" rel="stylesheet">
    <link href="<?php echo $this->theme->baseUrl; ?>/css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="<?php echo $this->theme->baseUrl; ?>/js/html5shiv.js"></script>
    <script src="<?php echo $this->theme->baseUrl; ?>/js/respond.min.js"></script>
    <![endif]-->
    
    <style>
    	.login-social-link a.twitter {
		    background: #C23321;
		    box-shadow: 0 4px #82190E;
		    float:left;
		}

    </style>
</head>

  <body class="login-body">

    <div class="container">

      <form class="form-signin" method="post" action="<?php echo $actionUrl; ?>/">
      	<input type="hidden" name="_csrf" value="<?php echo Yii::$app->request->getCsrfToken(); ?>" />
   		 
   		 <?php if(Yii::$app->session->hasFlash('reset_msg')){ ?>
			<div style="text-align: center;" class="alert alert-warning">
		  		<?php echo Yii::$app->session->getFlash('reset_msg'); ?>
		 	</div>
		 <?php } ?>
		 
        <h2 class="form-signin-heading">sign in now</h2>
        <div style="color: #ff0000;text-align:left;">
        	<?php 
        		if(isset($error)){
        			echo "$error";
        		}
			?>
        </div>
        <div class="login-wrap">
            <input required="required" type="email" name="username" class="form-control" placeholder="Email" autofocus required="required">
            <input required="required" type="password" name="password" class="form-control" placeholder="Password" required="required">
            <label class="checkbox">
                <span class="pull-right">
                    <a data-toggle="modal" href="#myModal"> Forgot Password?</a>

                </span>
            </label>
            <button class="btn btn-lg btn-login btn-block" type="submit">Sign in</button>
            <p>or you can sign in via social network</p>
            <div class="login-social-link">
            	
                <a href="<?php echo Yii::$app -> getUrlManager() -> createUrl("home/auth?authclient=facebook"); ?>" class="facebook">
                    <i class="fa fa-facebook"></i>
                    Facebook
                </a>
                <a href="<?php echo Yii::$app -> getUrlManager() -> createUrl("home/auth?authclient=google"); ?>" class="twitter">
                    <i class="fa fa-google-plus-square"></i>
                    Google+
                </a>
            </div>
            <div class="registration">
                Don't have an account yet?
                <a class="" href="<?php echo $registrationUrl; ?>">
                    Create an account
                </a>
            </div>

        </div>
		 </form>
		 
		  <form action="<?php echo $resetpassword; ?>"  method="post">
          <!-- Modal -->
          <input type="hidden" name="_csrf" value="<?php echo Yii::$app->request->getCsrfToken(); ?>" />
   
          <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title">Forgot Password ?</h4>
                      </div>
                      <div class="modal-body">
                          <p>Enter your e-mail address below to reset your password.</p>
                          <input required="required" type="email" name="resetemail" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">

                      </div>
                      <div class="modal-footer">
                          <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                          <button class="btn btn-success" type="submit">Submit</button>
                      </div>
                  </div>
              </div>
          </div>
          <!-- modal -->

      </form>

    </div>



    <!-- js placed at the end of the document so the pages load faster -->
    <script src="<?php echo $this->theme->baseUrl; ?>/js/jquery.js"></script>
    <script src="<?php echo $this->theme->baseUrl; ?>/js/bootstrap.min.js"></script>


  </body>
</html>
