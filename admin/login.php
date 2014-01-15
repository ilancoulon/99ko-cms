<!doctype html>
<!--[if IE 9]><html class="lt-ie10" lang="<?php showSiteLang(); ?>" > <![endif]-->
<html class="no-js" lang="<?php showSiteLang(); ?>">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8">	
	<title>99ko - <?php echo lang('Login'); ?></title>	
	<link rel="icon" href="images/favicon.ico" type="image/x-icon">
	<?php showLinkTags(); ?>
	<link rel="stylesheet" href="css/99ko.min.css?v1.0=" media="all">
	<?php showScriptTags(); ?>
	<?php eval(callHook('endAdminHead')); ?>	
  </head>
  
  <body class="antialiased hide-extras">
  <!-- Main Page Content and Sidebar -->
 
  <div class="row">
 
    <!-- Login Form -->
    <div class="<?php if (isset($_SESSION['msg_install'])) { ?>large-7<?php } else { ?>login small-5<?php } ?> columns">
 
      <h3><?php echo lang('Login'); ?></h3>
      <hr>
 
      <div class="section-container tabs" data-section>
        <section class="section">
          
          <div class="content">
           <?php showMsg($msg, 'error'); ?>
           <form method="post" action="index.php?action=login">
              <div class="row collapse">
                <div class="large-3 columns">
                  <?php showAdminTokenField(); ?>
                  <label class="inline"><?php echo lang('Email'); ?></label>
                </div>
                <div class="large-9 columns">
                  <input type="text" name="adminEmail" id="adminEmail">
                </div>
              </div>
              <div class="row collapse">
                <div class="large-3 columns">
                  <?php showAdminTokenField(); ?>
                  <label class="inline"><?php echo lang('Password'); ?></label>
                </div>
                <div class="large-9 columns">
                  <input type="password" name="adminPwd" id="adminPwd">
                </div>
              </div>
             <div class="row">
                <div class="large-2 columns"><button type="submit" class="radius button"><?php echo lang('Go'); ?></button></div>
                <div class="large-10 columns"><p class="right j"><?php echo lang('Just using'); ?><a href="index.php?action=logout&token=<?php echo $token; ?>">.</a></p></div>
             </div>              
              
            </form>
          </div>
        </section>
      </div>
    </div>
 
    <!-- End Login Form -->
 
     
	<?php if (isset($_SESSION['msg_install'])) { ?>
    <!-- Sidebar -->
    <div class="large-5 columns"> 
      <h3>Installation</h3>
      <hr>    	
        <?php showMsg($_SESSION['msg_install'], 'success'); ?> 
    </div>
    <!-- End Sidebar -->      		     
	<?php } ?>

  </div>
 
  <!-- End Main Content and Sidebar -->
</body>
</html>