<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
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
</head>

  <body class="login-body">

    <div class="container">
		    	
		<h2>Login Error</h2>
		<p>Invalid email or password. <a href='<?php echo $loginUrl; ?>'>Please try again</a></p>
		


    </div>



    <!-- js placed at the end of the document so the pages load faster -->
    <script src="<?php echo $this->theme->baseUrl; ?>/js/jquery.js"></script>
    <script src="<?php echo $this->theme->baseUrl; ?>/js/bootstrap.min.js"></script>


  </body>
</html>