<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Registration :: <?php echo \Yii::$app -> params['application_name']; ?></title>
   
    <!-- Bootstrap core CSS -->
    <link href="<?php echo $this -> theme -> baseUrl; ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $this -> theme -> baseUrl; ?>/css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="<?php echo $this -> theme -> baseUrl; ?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="<?php echo $this -> theme -> baseUrl; ?>/css/style.css" rel="stylesheet">
    <link href="<?php echo $this -> theme -> baseUrl; ?>/css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="<?php echo $this->theme->baseUrl; ?>/js/html5shiv.js"></script>
    <script src="<?php echo $this->theme->baseUrl; ?>/js/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
    	#form-signin-select {
		    margin-bottom: 15px;
		    border-radius: 5px;
		    -webkit-border-radius: 5px;
		    border: 1px solid #eaeaea;
		    box-shadow: none;
		    font-size: 12px;
		}    	
    </style>
</head>

  <body class="login-body">

    <div class="container">
	  		
      <form method="post" class="form-signin" action="<?php echo $submitUrl; ?>">
        <h2 class="form-signin-heading">registration now</h2>
        	<div style="color: #ff0000;text-align:left;">
        		<ul style="margin-left:1%; inside; list-style-type: circle">
	        	<?php
		        	if(isset($message) && count($message)>0){
					  	foreach($message as $msg){
					  		echo "<li>$msg</li>";
					  	}
					}
				?>
				</ul>
			</div>
        <div class="login-wrap">
        	
            <p> Enter your account details below</p>
            <input required="required" name="username" value="<?php echo @$username; ?>" type="text" class="form-control" placeholder="Name" autofocus>
            <input required="required" name="email" value="<?php echo @$email; ?>" type="email" class="form-control" placeholder="Email" autofocus>
            <input required="required" name="password"  type="password" class="form-control" placeholder="Password">
            <input required="required" name="password2" type="password" class="form-control" placeholder="Re-type Password">
            <input type="hidden" name="_csrf" value="<?php echo Yii::$app->request->getCsrfToken(); ?>" />
                     
        	 <select style="font-size:12px;padding:8px;margin-bottom:4px;" required="required" name="country" class="form-control form-signin-select">
        	 	<?php
        	 		if($country=='SELECT'){
        	 			echo '<option selected="selected" value="SELECT">Select Country</option>';						
        	 		}
					else{
						echo '<option value="SELECT">Select Country</option>';
					}
					foreach($countriesArray as $ccode=>$cname){
    					if(@$country==$ccode){	
    						echo "<option selected='selected' value='$ccode'>$cname</option>";
						}
						else{
							echo "<option value='$ccode'>$cname</option>";
						}
    				}
				?>
        	</select>
                        
            <button class="btn btn-lg btn-login btn-block" type="submit">Submit</button>

            <div class="registration">
                Already Registered.
                <a class="" href="<?php echo $loginUrl; ?>">
                    Login
                </a>
            </div>
        </div>
      </form>
      
    </div>
  </body>
</html>