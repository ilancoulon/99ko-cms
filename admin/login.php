<!doctype html>
<!--[if IE 9]><html class="lt-ie10" lang="<?php showSiteLang(); ?>" > <![endif]-->
<html class="no-js" lang="<?php showSiteLang(); ?>">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8">	
	<title>99ko - <?php echo lang('Login'); ?></title>	
	<link rel="icon" href="assets/favicon.ico" type="image/x-icon">
	<?php showLinkTags(); ?>
	<link rel="stylesheet" href="assets/css/99ko.css" media="all">
	<?php showScriptTags(); ?>
	<?php eval(callHook('endAdminHead')); ?>	
  </head>
  
  <body class="antialiased hide-extras">
 
  <div class="row"> 
    <!-- Login Form -->
    <div class="small-5 small-centered columns login">
     <div class="panel radius">

	  <?php if (isset($_SESSION['msg_install'])) { ?>	
          <?php showMsg('<h5>' .lang('Installed !'). '</h5><strong>'.lang('99ko is installed').'<br />'.lang('Also, delete the install.php file'). '</strong>', 'success'); ?>     		     
	  <?php } ?> 
	  
           <h3><?php echo lang('Login'); ?></h3>
           <hr />
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
                 <div class="large-12 columns">
                       <ul class="button-group radius">
			<li><a href="../" class="button alert"><?php echo lang('Back to website'); ?></a></li>
			<li><button type="submit" class="button success"><?php echo lang('Go'); ?></button></li>
		       </ul>
                 </div>
              </div>                            
            </form>
      </div>
    </div>
    <!-- End Login Form -->
    
    <p class="text-center">
         <a title="<?php echo lang("NoDB CMS"); ?>" onclick="window.open(this.href);return false;" href="http://99ko.hellojo.fr"><?php echo lang("Just using <b>99ko</b>"); ?></a><a href="index.php?action=logout&token=<?php echo $token; ?>">.</a>
    </p>    
  </div><!-- /.row --> 
  
    <script src="assets/js/scripts.js"></script>
    <?php eval(callHook('endAdminBody')); ?>
</body>
</html>
