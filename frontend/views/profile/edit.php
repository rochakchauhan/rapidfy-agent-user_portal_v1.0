<?php
extract($getUserInfo);
$country=$mobileCountryId;
$countryName = $countriesArray[$mobileCountryId];
?>
<!-- page start-->
<div class="row">
	<aside class="profile-nav col-lg-3">
		<section class="panel">
			<div class="user-heading round">
				<a href="<?php echo $viewProfile; ?>"> <img src="<?php echo $avatarImage; ?>" alt="<?php echo $username; ?>"> </a>
				<h1><?php echo $username; ?></h1>
				<p><?php echo $email; ?></p>
			</div>

			<ul class="nav nav-pills nav-stacked">
				<li>
					<a href="<?php echo $viewProfile; ?>"> <i class="fa fa-user"></i> Profile</a>
				</li>
				<li  class="active">
					<a href="<?php echo $editProfile; ?>"> <i class="fa fa-edit"></i> Edit profile</a>
				</li>
			</ul>

		</section>
	</aside>
	<aside class="profile-info col-lg-9">
		<section class="panel">
			
			 <?php if(Yii::$app->session->hasFlash('profile_msg')){ ?>
				<div style="text-align: center;" class="alert alert-warning">
			  		<?php echo Yii::$app->session->getFlash('profile_msg'); ?>
			 	</div>
			 <?php } ?>
			 
			<div class="panel-body bio-graph-info">
				<h1> Profile Info</h1>
				<form class="form-horizontal" action="<?php echo $saveprofile; ?>" method="post" role="form">
					<input type="hidden" name="_csrf" value="<?php echo Yii::$app->request->getCsrfToken(); ?>" />
                     
        			<div class="form-group">
						<label  class="col-lg-2 control-label">Name</label>
						<div class="col-lg-6">
							<input required="required" name="username" type="text" class="form-control" placeholder="Name" value="<?php echo $username; ?>">
						</div>
					</div>
					<div class="form-group">
						<label  class="col-lg-2 control-label">E-mail</label>
						<div class="col-lg-6">
							<input required="required" name="email" type="email" class="form-control" placeholder="Email" value="<?php echo $email; ?>">
						</div>
					</div>
					<div class="form-group">
						<label  class="col-lg-2 control-label">Mobile</label>
						<div class="col-lg-6">
							<input type="text" name="mobile" class="form-control" placeholder="Mobile" value="<?php echo $mobileNum; ?>">
						</div>
					</div>
					<div class="form-group">
						<label  class="col-lg-2 control-label">Country</label>
						<div class="col-lg-6">
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
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-lg-offset-2 col-lg-10">
							<button type="submit" class="btn btn-success">
								Save
							</button>
							<button type="button" class="btn btn-default">
								Cancel
							</button>
						</div>
					</div>
				</form>
			</div>
		</section>
		<section>
			<div class="panel panel-primary">
				<div class="panel-heading">
					Update Avatar
				</div>
				<div class="panel-body">
					<form enctype="multipart/form-data" method="post" action="<?php echo $updateavatar; ?>" class="form-horizontal" role="form">
						<input type="hidden" name="_csrf" value="<?php echo Yii::$app->request->getCsrfToken(); ?>" />
                     	
                     	<input type="hidden" name="id" value="<?php echo $id; ?>" />
						<input type="hidden" name="href" value="<?php echo $href; ?>" />
						<input type="hidden" name="token" value="<?php echo $token; ?>" />
						
						<!--div class="form-group">
							<label  class="col-lg-2 control-label">Current Password</label>
							<div class="col-lg-6">
								<input name="password" required="required" type="password" class="form-control" id="c-pwd" placeholder=" ">
							</div>
						</div>
						<div class="form-group">
							<label  class="col-lg-2 control-label">New Password</label>
							<div class="col-lg-6">
								<input name="newpassword1" required="required" type="password" class="form-control" id="n-pwd" placeholder=" ">
							</div>
						</div>
						<div class="form-group">
							<label  class="col-lg-2 control-label">Re-type New Password</label>
							<div class="col-lg-6">
								<input name="newpassword2" required="required" type="password" class="form-control" id="rt-pwd" placeholder=" ">
							</div>
						</div-->
						
						<div class="form-group">
		                      <label  class="col-lg-2 control-label">Change Avatar</label>
		                      <div class="col-lg-6">
		                          <input required="required" name='imagefile' type="file" class="file-pos" id="exampleInputFile"> (JPG Images Only with size less than 600kb)
		                      </div>
		                </div>
		

						<div class="form-group">
							<div class="col-lg-offset-2 col-lg-10">
								<button type="submit" class="btn btn-info">
									Save
								</button>
								<button type="button" class="btn btn-default">
									Cancel
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</section>
	</aside>
</div>
