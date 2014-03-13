<!doctype html>
<!--[if IE 9]><html class="lt-ie10" lang="<?php showSiteLang(); ?>" > <![endif]-->
<html class="no-js" lang="<?php showSiteLang(); ?>">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8">	
	<title>99ko - <?php echo lang('Login'); ?></title>	
	<link rel="icon" href="assets/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="assets/css/minified.css.php?v=5.2.0" media="all">
	<?php showLinkTags(); ?>
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
           <?php showAdminTokenField(); ?>
           
              <div class="row collapse">
                <div class="large-12 columns">
                   <label for="adminEmail"><?php echo lang('Email'); ?></label>
                   <input type="email" id="adminEmail" name="adminEmail" placeholder="your@mail.com" required>
                </div>
                <div class="large-12 columns">
                   <label for="adminPwd"><?php echo lang('Password'); ?></label>
                   <input type="password" id="adminPwd" name="adminPwd" placeholder="*******" required>
                </div>
              </div>                
              
              <div class="row">
                 <div class="large-10 columns">
                       <p class="left copy">
                            <a title="<?php echo lang("NoDB CMS"); ?>" onclick="window.open(this.href);return false;" href="http://99ko.hellojo.fr"><?php echo lang("Just using <b>99ko</b>"); ?></a><a href="index.php?action=logout&token=<?php echo $token; ?>">.</a>
                       </p>
                 </div>
                 <div class="large-2 columns">
                       <p class="right"><button type="submit" class="radius button"><?php echo lang('Go'); ?></button></p>
                 </div>
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
      <h3><?php echo lang('Installed !'); ?></h3>
      <hr>    	
        <?php showMsg(lang('99ko is installed').'<br />'.lang('Also, delete the install.php file'), 'success'); ?> 
    </div>
    <!-- End Sidebar -->      		     
	<?php } ?>

  </div>
 
  <!-- End Main Content and Sidebar -->
    <script src="js/all.js"></script>
    <script src="js/scripts.js"></script>
    <script>
            $(document).foundation();
    </script>  
</body>
</html>
