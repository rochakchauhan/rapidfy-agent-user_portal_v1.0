<?php

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Form Validation</title>

    <!-- Bootstrap core CSS -->
    <link href="../../../vendor/bower/flatlab/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../../vendor/bower/flatlab/css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="../../../vendor/bower/flatlab/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
      <!--right slidebar-->
      <link href="../../../vendor/bower/flatlab/css/slidebars.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../../../vendor/bower/flatlab/css/style.css" rel="stylesheet">
    <link href="../../../vendor/bower/flatlab/css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

  <section id="container" class="">
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
              <!-- page start-->
              <div class="row">
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                             BUSINESS REGISTRATION
                          </header>
                          <div class="panel-body">
                              <div class="form">
                                  <form class="cmxform form-horizontal tasi-form" id="register" method="post" action="payment.php">
                                      <div class="form-group ">
                                          <label for="businesstype" class="control-label col-lg-2">Business Type</label>
                                          <div class="col-lg-10">
                                              <input class=" form-control" id="businesstype" name="businesstype" type="text" required />
                                          </div>
                                      </div>
                                      <div class="form-group ">
                                          <label for="businessname" class="control-label col-lg-2">BUSINESS NAME</label>
                                          <div class="col-lg-10">
                                              <input class=" form-control" id="businessname" name="businessname" type="text" required/>
                                          </div>
                                      </div>
									  <div class="form-group ">
                                          <label for="description" class="control-label col-lg-2">BUSINESS DESCRIPTION</label>
                                          <div class="col-lg-10">
                                              <input class=" form-control" id="description" name="description" type="text" />
                                          </div>
                                      </div>
									  <div class="form-group ">
                                          <label for="phone" class="control-label col-lg-2">BUSINESS PHONE NUMBER</label>
                                          <div class="col-lg-10">
                                              <input class=" form-control" id="phone" name="phone" type="text" required />
                                          </div>
                                      </div><div class="form-group ">
                                          <label for="username" class="control-label col-lg-2">USERNAME</label>
                                          <div class="col-lg-10">
                                              <input class=" form-control" id="username" name="username" type="text" />
                                          </div>
                                      </div><div class="form-group ">
                                          <label for="password" class="control-label col-lg-2">PASSWORD</label>
                                          <div class="col-lg-10">
                                              <input class=" form-control" id="password" name="password" type="password" />
                                          </div>
                                      </div>
									   <div class="form-group ">
                                          <label for="confirm_password" class="control-label col-lg-2">CONFIRM PASSWORD</label>
                                          <div class="col-lg-10">
                                              <input class="form-control " id="confirm_password" name="confirm_password" type="password" />
                                          </div>
                                      </div>
									  
									  <div class="form-group ">
                                          <label for="email" class="control-label col-lg-2">EMAIL</label>
                                          <div class="col-lg-10">
                                              <input class=" form-control" id="email" name="email" type="email" />
                                          </div>
                                      </div>
									  
                                      <div class="form-group ">
                                          <label for="location" class="control-label col-lg-2">BUSINESS LOCATION</label>
										  <div class="col-lg-10">
                                              <input class="form-control " id="autocomplete" name="location" type="text" onFocus="geolocate()" required />
                                          </div>
                                      </div>
										  <div class="form-group ">
											  <label for="address" class="control-label col-lg-2">STREET ADDRESS</label>
											  <div class="col-lg-3">
												  <input class="form-control " id="street_number" type="text" placeholder="Street number" required/>
											  </div>
											  <div class="col-lg-7">
											  <input class="form-control " id="route" name="route" type="text" required/>
											  </div>
										  </div>

										  <div class="form-group ">
											  <label for="address" class="control-label col-lg-2">CITY</label>
											  <div class="col-lg-10">
												  <input class="form-control " id="locality" name="locality" type="text" />
											  </div>
										  </div>
										   <div class="form-group ">
											  <label for="address" class="control-label col-lg-2">STATE</label>
											  <div class="col-lg-10">
												  <input class="form-control " id="administrative_area_level_1" type="text" />
											  </div>
										  </div>
										   <div class="form-group ">
											  <label for="address" class="control-label col-lg-2">ZIP CODE</label>
											  <div class="col-lg-10">
												  <input class="form-control " id="postal_code" name="postal_code" type="text" />
											  </div>
										  </div>
										
                                      <div class="form-group ">
                                          <label for="agree" class="control-label col-lg-2 col-sm-3">Agree to Our Policy</label>
                                          <div class="col-lg-10 col-sm-9">
                                              <input  type="checkbox" style="width: 20px" class="checkbox form-control" id="agree" name="agree" />
                                          </div>
                                      </div>
                                      <div class="form-group ">
                                          <label for="newsletter" class="control-label col-lg-2 col-sm-3">Receive the Newsletter</label>
                                          <div class="col-lg-10 col-sm-9">
                                              <input  type="checkbox" style="width: 20px" class="checkbox form-control" id="newsletter" name="newsletter" />
                                          </div>
                                      </div>


                                          <div class="col-lg-offset-2 col-lg-10">
											<button class="btn btn-danger" type="submit">Submit</button>
                                          </div>

                                  </form>
                              </div>
                          </div>
                      </section>
                  </div>
              </div>
              <!-- page end-->
          </section>
      </section>
      <!--main content end-->
     
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="../../../vendor/bower/flatlab/js/jquery.js"></script>
    <script src="../../../vendor/bower/flatlab/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="../../../vendor/bower/flatlab/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="../../../vendor/bower/flatlab/js/jquery.scrollTo.min.js"></script>
    <script src="../../../vendor/bower/flatlab/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script type="text/javascript" src="../../../vendor/bower/flatlab/js/jquery.validate.min.js"></script>
    <script src="../../../vendor/bower/flatlab/js/respond.min.js" ></script>

  <!--right slidebar-->
  <script src="../../../vendor/bower/flatlab/js/slidebars.min.js"></script>

    <!--common script for all pages-->
    <script src="../../../vendor/bower/flatlab/js/common-scripts.js"></script>

    <!--script for this page-->
    <script src="../../../vendor/bower/flatlab/js/form-validation-script.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDHwh2uw1io2Ou2E5FBQPvyR3ezH8Bf7ZU&signed_in=true&libraries=places&callback=initAutocomplete"
        async defer></script>
	
	<script type="text/javascript">

	  
	var placeSearch, autocomplete;
	var componentForm = {
	  street_number: 'short_name',
	  route: 'long_name',
	  locality: 'long_name',
	  administrative_area_level_1: 'short_name',
	  country: 'long_name',
	  postal_code: 'short_name',

	};

	function initAutocomplete() {
	  // Create the autocomplete object, restricting the search to geographical
	  // location types.
	  autocomplete = new google.maps.places.Autocomplete(
		  /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
		  {types: ['geocode']});

	  // When the user selects an address from the dropdown, populate the address
	  // fields in the form.
	  autocomplete.addListener('place_changed', fillInAddress);
	}

	// [START region_fillform]
	function fillInAddress() {
	  // Get the place details from the autocomplete object.
	  var place = autocomplete.getPlace();

	  for (var component in componentForm) {
		document.getElementById(component).value = '';
		document.getElementById(component).disabled = false;
	  }

	  // Get each component of the address from the place details
	  // and fill the corresponding field on the form.
	  for (var i = 0; i < place.address_components.length; i++) {
		var addressType = place.address_components[i].types[0];
		if (componentForm[addressType]) {
		  var val = place.address_components[i][componentForm[addressType]];
		  console.log("working");
		  document.getElementById(addressType).value = val;
		}
	  }
	}
	// [END region_fillform]

	// [START region_geolocation]
	// Bias the autocomplete object to the user's geographical location,
	// as supplied by the browser's 'navigator.geolocation' object.
	function geolocate() {
	  if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position) {
		  var geolocation = {
			lat: position.coords.latitude,
			lng: position.coords.longitude
		  };
		  var circle = new google.maps.Circle({
			center: geolocation,
			radius: position.coords.accuracy
		  });
		  autocomplete.setBounds(circle.getBounds());
		});
	  }
	}
	// [END region_geolocation]
	</script>
  </body>
</html>
