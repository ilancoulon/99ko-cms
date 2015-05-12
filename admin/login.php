<!doctype html>
<!--[if IE 9]><html class="lt-ie10" lang="<?php show::showSiteLang(); ?>" > <![endif]-->
<html class="no-js" lang="<?php show::showSiteLang(); ?>">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8">	
	<title>99ko - <?php echo $core->lang('Login'); ?></title>	
	<link rel="icon" href="assets/favicon.ico" type="image/x-icon">
	<?php show::showLinkTags(); ?>
	<link rel="stylesheet" href="assets/css/99ko.css" media="all">
	<?php show::showScriptTags(); ?>	
  </head>
  
  <body class="antialiased hide-extras">
 
  <div class="row"> 
    <!-- Login Form -->
    <div class="small-5 small-centered columns login">
     <div class="panel radius">

	  <?php if (isset($_SESSION['msg_install'])) { ?>	
          <?php show::showMsg('<h5>' .$core->lang('Installed !'). '</h5><strong>'.$core->lang('99ko is installed').'<br />'.$core->lang('Also, delete the install.php file'). '</strong>', 'success'); ?>     		     
	  <?php } ?> 
	  
           <h3><?php echo $core->lang('Login'); ?></h3>
           <hr />
           <?php show::showMsg($msg, 'error'); ?>
           
           <form method="post" action="index.php?action=login">   
           <?php show::showAdminTokenField(); ?>          
              <div class="row collapse">
                <div class="large-12 columns">
                   <label for="adminEmail"><?php echo $core->lang('Email'); ?></label>
                   <input type="email" id="adminEmail" name="adminEmail" placeholder="your@mail.com" required>
                </div>
                
                <div class="large-12 columns">
                   <label for="adminPwd"><?php echo $core->lang('Password'); ?></label>
                   <input type="password" id="adminPwd" name="adminPwd" placeholder="*******" required>
                </div>
              </div>                
              
              <div class="row">
                 <div class="large-12 columns">
                       <ul class="button-group radius">
			<li><a href="../" class="button alert"><?php echo $core->lang('Back to website'); ?></a></li>
			<li><button type="submit" class="button success"><?php echo $core->lang('Go'); ?></button></li>
		       </ul>
                 </div>
              </div>                            
            </form>
      </div>
    </div>
    <!-- End Login Form -->
    
    <p class="text-center">
         <a title="<?php echo $core->lang("NoDB CMS"); ?>" onclick="window.open(this.href);return false;" href="http://99ko.hellojo.fr"><?php echo $core->lang("Just using <b>99ko</b>"); ?></a><a href="index.php?action=logout&token=<?php echo $token; ?>">.</a>
    </p>    
  </div><!-- /.row --> 
  
    <script src="assets/js/scripts.js"></script>
</body>
</html>
