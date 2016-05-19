<?php 
	extract($getUserInfo); 
	$countryName=$countriesArray[$mobileCountryId];
?>
<div class="row">
	<aside class="profile-nav col-lg-3">
		<section class="panel">
			<div class="user-heading round">
				<a href="<?php echo $viewProfile; ?>"> <img src="<?php echo $avatarImage; ?>" alt="<?php echo $username; ?>"> </a>
				<h1><?php echo $username; ?></h1>
				<p><?php echo $email; ?></p>
			</div>

			<ul class="nav nav-pills nav-stacked">
				<li class="active">
					<a href="<?php echo $viewProfile; ?>"> <i class="fa fa-user"></i> Profile</a>
				</li>				
				<li>
					<a href="<?php echo $editProfile; ?>"> <i class="fa fa-edit"></i> Edit profile</a>
				</li>
			</ul>

		</section>
	</aside>
	<aside class="profile-info col-lg-9">
		
		<section class="panel">
			
			<div class="panel-body bio-graph-info">
				<h1>Bio Graph</h1>
				<div class="row">
					<div class="bio-row">
						<p>
							<span>Name </span>: <strong><?php echo $username; ?></strong>
						</p>
					</div>
					<div class="bio-row">
						<p>
							<span>Country </span>: <strong><?php echo $countryName; ?></strong>
						</p>
					</div>
					<div class="bio-row">
						<p>
							<span>Created On</span>: <strong><?php echo \Yii::$app -> get('utility') -> formatDate($createdDate); ?></strong>
						</p>
					</div>
					<div class="bio-row">
						<p>
							<span>Last Logged in </span>: <strong><?php echo  \Yii::$app -> get('utility') -> formatDate($lastLoginDate); ?></strong>
						</p>
					</div>
					<div class="bio-row">
						<p>
							<span>Email </span>: <strong><?php echo $email; ?></strong>
						</p>
					</div>
					<div class="bio-row">
						<p>
							<span>Mobile </span>: <strong><?php echo $mobileNum; ?></strong>
						</p>
					</div>
					
				</div>
			</div>
		</section>
	</aside>
</div>
