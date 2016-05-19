<?php
use yii\helpers\Html;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    
    <link rel="shortcut icon" href="<?php echo $this->theme->baseUrl; ?>/img/favicon.png">
    <title><?php echo \Yii::$app->params['application_name']; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo $this->theme->baseUrl; ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $this->theme->baseUrl; ?>/css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="<?php echo $this->theme->baseUrl; ?>/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="<?php echo $this->theme->baseUrl; ?>/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>
    <link rel="stylesheet" href="<?php echo $this->theme->baseUrl; ?>/css/owl.carousel.css" type="text/css">

    <!--right slidebar-->
    <link href="<?php echo $this->theme->baseUrl; ?>/css/slidebars.css" rel="stylesheet">

    <!-- Custom styles for this template -->

    <link href="<?php echo $this->theme->baseUrl; ?>/css/style.css" rel="stylesheet">
    <link href="<?php echo $this->theme->baseUrl; ?>/css/style-responsive.css" rel="stylesheet" />



    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
      <script src="<?php echo $this->theme->baseUrl; ?>/js/html5shiv.js"></script>
      <script src="<?php echo $this->theme->baseUrl; ?>/js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

	<?php 
		$userInfo=\Yii::$app -> get('utility') ->getUserInfo();
	?>
  <section id="container" >
      <!--header start-->
      <header class="header white-bg">
              <div class="sidebar-toggle-box">
                  <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
              </div>
            <!--logo start-->
            <a href="<?php echo Yii::$app->getUrlManager()->createUrl("home"); ?>" class="logo">Rapid<span>fy</span></a>
            <div class="top-nav ">
                <!--search & user info start-->
                <ul class="nav pull-right top-menu">
                    <!-- user login dropdown start-->
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <img alt="<?php echo $userInfo['username']; ?>" width="32" src="<?php echo $userInfo['avatarImage']; ?>" >
                            <span class="username"><?php echo $userInfo['username']; ?></span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu extended logout">
                            <div class="log-arrow-up"></div>
                            <li><a href="<?php echo Yii::$app->getUrlManager()->createUrl("profile"); ?>"><i class=" fa fa-suitcase"></i>Profile</a></li>
                            <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>
                            <li><a href="#"><i class="fa fa-bell-o"></i> Notification</a></li>
                            <li><a href="<?php echo Yii::$app->getUrlManager()->createUrl("home/logout"); ?>"><i class="fa fa-key"></i> Log Out</a></li>
                        </ul>
                    </li>
                    <!-- user login dropdown end -->
                </ul>
                <!--search & user info end-->
            </div>
        </header>
      <!--header end-->
      <!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
                 <li>
                      <a href="<?php echo Yii::$app->getUrlManager()->createUrl("inbox"); ?>">
                          <i class="fa fa-envelope"></i>
                          <span>Request Inbox</span>
                      </a>
                  </li>
                  
                  <li>
                      <a href="<?php echo Yii::$app->getUrlManager()->createUrl("jobinbox"); ?>">
                          <i class="fa fa-envelope"></i>
                          <span>Job Inbox</span>
                      </a>
                  </li>
                  
                  <!--li class="active" class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-laptop"></i>
                          <span>Layouts</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="boxed_page.html">Boxed Page</a></li>
                          <li><a  href="horizontal_menu.html">Horizontal Menu</a></li>
                          <li><a  href="header-color.html">Different Color Top bar</a></li>
                          <li><a  href="mega_menu.html">Mega Menu</a></li>
                          <li><a  href="language_switch_bar.html">Language Switch Bar</a></li>
                          <li><a  href="email_template.html" target="_blank">Email Template</a></li>
                      </ul>
                  </li>

                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-book"></i>
                          <span>UI Elements</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="general.html">General</a></li>
                          <li><a  href="buttons.html">Buttons</a></li>
                          <li><a  href="modal.html">Modal</a></li>
                          <li><a  href="toastr.html">Toastr Notifications</a></li>
                          <li><a  href="widget.html">Widget</a></li>
                          <li><a  href="slider.html">Slider</a></li>
                          <li><a  href="nestable.html">Nestable</a></li>
                          <li><a  href="font_awesome.html">Font Awesome</a></li>
                      </ul>
                  </li>

                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-cogs"></i>
                          <span>Components</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="grids.html">Grids</a></li>
                          <li><a  href="calendar.html">Calendar</a></li>
                          <li><a  href="gallery.html">Gallery</a></li>
                          <li><a  href="todo_list.html">Todo List</a></li>
                          <li><a  href="draggable_portlet.html">Draggable Portlet</a></li>
                          <li><a  href="tree.html">Tree View</a></li>
                      </ul>
                  </li>
                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-tasks"></i>
                          <span>Form Stuff</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="form_component.html">Form Components</a></li>
                          <li><a  href="advanced_form_components.html">Advanced Components</a></li>
                          <li><a  href="form_wizard.html">Form Wizard</a></li>
                          <li><a  href="form_validation.html">Form Validation</a></li>
                          <li><a  href="dropzone.html">Dropzone File Upload</a></li>
                          <li><a  href="inline_editor.html">Inline Editor</a></li>
                          <li><a  href="image_cropping.html">Image Cropping</a></li>
                          <li><a  href="file_upload.html">Multiple File Upload</a></li>
                      </ul>
                  </li>
                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-th"></i>
                          <span>Data Tables</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="basic_table.html">Basic Table</a></li>
                          <li><a  href="responsive_table.html">Responsive Table</a></li>
                          <li><a  href="dynamic_table.html">Dynamic Table</a></li>
                          <li><a  href="editable_table.html">Editable Table</a></li>
                      </ul>
                  </li>
                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class=" fa fa-envelope"></i>
                          <span>Mail</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="inbox.html">Inbox</a></li>
                          <li><a  href="inbox_details.html">Inbox Details</a></li>
                      </ul>
                  </li>
                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class=" fa fa-bar-chart-o"></i>
                          <span>Charts</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="morris.html">Morris</a></li>
                          <li><a  href="chartjs.html">Chartjs</a></li>
                          <li><a  href="flot_chart.html">Flot Charts</a></li>
                          <li><a  href="xchart.html">xChart</a></li>
                      </ul>
                  </li>
                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-shopping-cart"></i>
                          <span>Shop</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="product_list.html">List View</a></li>
                          <li><a  href="product_details.html">Details View</a></li>
                      </ul>
                  </li>
                  <li>
                      <a href="google_maps.html" >
                          <i class="fa fa-map-marker"></i>
                          <span>Google Maps </span>
                      </a>
                  </li>
                  <li class="sub-menu">
                      <a href="javascript:;">
                          <i class="fa fa-comments-o"></i>
                          <span>Chat Room</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="lobby.html">Lobby</a></li>
                          <li><a  href="chat_room.html"> Chat Room</a></li>
                      </ul>
                  </li>
                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-glass"></i>
                          <span>Extra</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="blank.html">Blank Page</a></li>
                          <li><a  href="sidebar_closed.html">Sidebar Closed</a></li>
                          <li><a  href="people_directory.html">People Directory</a></li>
                          <li><a  href="coming_soon.html">Coming Soon</a></li>
                          <li><a  href="lock_screen.html">Lock Screen</a></li>
                          <li><a  href="profile.html">Profile</a></li>
                          <li><a  href="invoice.html">Invoice</a></li>
                          <li><a  href="project_list.html">Project List</a></li>
                          <li><a  href="project_details.html">Project Details</a></li>
                          <li><a  href="search_result.html">Search Result</a></li>
                          <li><a  href="pricing_table.html">Pricing Table</a></li>
                          <li><a  href="faq.html">FAQ</a></li>
                          <li><a  href="fb_wall.html">FB Wall</a></li>
                          <li><a  href="404.html">404 Error</a></li>
                          <li><a  href="500.html">500 Error</a></li>
                      </ul>
                  </li>
                  <li>
                      <a  href="<?php echo Yii::$app->getUrlManager()->createUrl("home/logout"); ?>">
                          <i class="fa fa-user"></i>
                          <span>Login Page</span>
                      </a>
                  </li>

                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-sitemap"></i>
                          <span>Multi level Menu</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="javascript:;">Menu Item 1</a></li>
                          <li class="sub-menu">
                              <a  href="boxed_page.html">Menu Item 2</a>
                              <ul class="sub">
                                  <li><a  href="javascript:;">Menu Item 2.1</a></li>
                                  <li class="sub-menu">
                                      <a  href="javascript:;">Menu Item 3</a>
                                      <ul class="sub">
                                          <li><a  href="javascript:;">Menu Item 3.1</a></li>
                                          <li><a  href="javascript:;">Menu Item 3.2</a></li>
                                      </ul>
                                  </li>
                              </ul>
                          </li>
                      </ul>
                  </li-->
                  
              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
              <?php echo $content; ?>
          </section>
      </section>
      <!--main content end-->

      

      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
          	
              <?php echo date("Y") ?> &copy; Rapidfy.
              <a href="#" class="go-top">
                  <i class="fa fa-angle-up"></i>
              </a>
          </div>
      </footer>
      <!--footer end-->
  </section>
    <!-- js placed at the end of the document so the pages load faster -->
    <script src="<?php echo $this->theme->baseUrl; ?>/js/jquery.js"></script>
    <script src="<?php echo $this->theme->baseUrl; ?>/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="<?php echo $this->theme->baseUrl; ?>/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="<?php echo $this->theme->baseUrl; ?>/js/jquery.scrollTo.min.js"></script>
    <script src="<?php echo $this->theme->baseUrl; ?>/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="<?php echo $this->theme->baseUrl; ?>/js/jquery.sparkline.js" type="text/javascript"></script>
    <script src="<?php echo $this->theme->baseUrl; ?>/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>
    <script src="<?php echo $this->theme->baseUrl; ?>/js/owl.carousel.js" ></script>
    <script src="<?php echo $this->theme->baseUrl; ?>/js/jquery.customSelect.min.js" ></script>
    <script src="<?php echo $this->theme->baseUrl; ?>/js/respond.min.js" ></script>

    <!--right slidebar-->
    <script src="<?php echo $this->theme->baseUrl; ?>/js/slidebars.min.js"></script>

    <!--common script for all pages-->
    <script src="<?php echo $this->theme->baseUrl; ?>/js/common-scripts.js"></script>

    <!--script for this page-->
    <script src="<?php echo $this->theme->baseUrl; ?>/js/sparkline-chart.js"></script>
    <script src="<?php echo $this->theme->baseUrl; ?>/js/easy-pie-chart.js"></script>
    <script src="<?php echo $this->theme->baseUrl; ?>/js/count.js"></script>
    
    <?php 
    	$REQUEST_URI=$_SERVER['REQUEST_URI']; 
    	if($REQUEST_URI=="/inbox"){
    		echo "<script src='".$this->theme->baseUrl."/js/inbox.js'></script>";	
    	}
		elseif($REQUEST_URI=="/jobinbox"){
    		echo "<script src='".$this->theme->baseUrl."/js/jobinbox.js'></script>";
    	}
    ?>
    <script type="text/javascript">
		//owl carousel
	    /*$(document).ready(function() {
		$("#owl-demo").owlCarousel({
				navigation : true,
		    	slideSpeed : 300,
		        paginationSpeed : 400,
		        singleItem : true,
				autoPlay:true
			});
		});
		*///custom select box

	  $(function(){
	      $('select.styled').customSelect();
	  });

      $(window).on("resize",function(){
          //var owl = $("#owl-demo").data("owlCarousel");
          //owl.reinit();
      });

  </script>

  </body>
</html>
