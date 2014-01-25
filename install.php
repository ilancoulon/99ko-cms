<?php
##########################################################################################################
# 99ko http://99ko.hellojo.fr/
#
# Copyright (c) 2013-2014 Florent Fortat (florent.fortat@maxgun.fr) / Jonathan Coulet (j.coulet@gmail.com) / Frédéric Kaplon (frederic.kaplon@me.com)
# Copyright (c) 2010-2011 Florent Fortat (florent.fortat@maxgun.fr) / Jonathan Coulet (j.coulet@gmail.com)
# Copyright (c) 2010 Jonathan Coulet (j.coulet@gmail.com)
##########################################################################################################

session_start();
define('VERSION', '1.4 b');
define('ROOT', './');
define('DEFAULT_PLUGIN', 'page');

include_once(ROOT.'common/core.lib.php');
utilSetMagicQuotesOff();

# Chargement des langs
$langs = listLangs();
$lang = array();
# On charge la langue du core
$lang = utilReadJsonFile(ROOT.'common/lang/fr.json');

$pluginsManager = new pluginsManager();
$hooks = array();
if(file_exists(ROOT.'data/config.txt')) die(lang('Config file already exist !'));

# Obtien un tableau avec les noms de tous les modules compilés et chargés
$php_modules = get_loaded_extensions();
# On initialise les erreurs
$errors = array();
# Liste des répertoires à vérifier
$dir_array = array('data', 'plugin', 'theme');
# Vérification de la version de PHP
if (version_compare(PHP_VERSION, "5.1.2", "<")) {
    $errors['php'] = 'error';
}
# Vérification si mod_rewrite est disponible
if (function_exists('apache_get_modules')) {
    if ( ! in_array('mod_rewrite', apache_get_modules())) {
        $errors['mod_rewrite'] = 'error';
    } 
}
# Vérification que le script d'installation est accessible en écriture
if (!is_writable(__FILE__)) {
    $errors['install'] = 'error';
}
# Idem pour le fichier Htaccess
if (!is_writable('.htaccess')) {
    $errors['htaccess'] = 'error';
}
# Vérification d'écriture sur la liste des répertoires
foreach ($dir_array as $dir) {
    if (!is_writable($dir.'/')) {
        $errors[$dir] = 'error';
    }
}
/*
** Créations des fichiers nécessaires a 99ko
*/
@chmod(ROOT.'.htaccess', 0666);
if(!file_exists(ROOT.'.htaccess')){
	if(!@file_put_contents(ROOT.'.htaccess', "Options -Indexes", 0666)) $error = true;
}
if(!is_dir(ROOT.'data/') && (!@mkdir(ROOT.'data/') || !@chmod(ROOT.'data/', 0777))) $error = true;
if(!file_exists(ROOT.'data/.htaccess')){
	if(!@file_put_contents(ROOT.'data/.htaccess', "deny from all", 0666)) $error = true;
}
if(!is_dir(ROOT.'data/plugin/') && (!@mkdir(ROOT.'data/plugin/') || !@chmod(ROOT.'data/plugin/', 0777))) $error = true;
if(!is_dir(ROOT.'data/upload/') && (!@mkdir(ROOT.'data/upload/') || !@chmod(ROOT.'data/upload/', 0777))) $error = true;
if(!file_exists(ROOT.'data/upload/.htaccess')){
	if(!@file_put_contents(ROOT.'data/upload/.htaccess', "allow from all", 0666)) $error = true;
}
$key = uniqid(true);
if(!file_exists(ROOT.'data/key.php') && !@file_put_contents(ROOT.'data/key.php', "<?php define('KEY', '$key'); ?>", 0666)) $error = true;
include(ROOT.'data/key.php');

          foreach($pluginsManager->getPlugins() as $plugin){
	          if($plugin->getLibFile()){
		          include_once($plugin->getLibFile());
		          if(!$plugin->isInstalled()) $pluginsManager->installPlugin($plugin->getName());
	          }
          }
          foreach($pluginsManager->getPlugins() as $plugin){
	        foreach($plugin->getHooks() as $hookName=>$function) $hooks[$hookName][] = $function;
          }  
         
/*
** Lance l'installation quand on clique sur le bouton
*/
if (isset($_POST['install_submit'])) {

    	$siteName = isset($_POST['siteName']) ? $_POST['siteName'] : '';
    	$siteDescription = isset($_POST['siteDescription']) ? $_POST['siteDescription'] : '';
    	$siteTimezone = isset($_POST['siteTimezone']) ? $_POST['siteTimezone'] : '';
    	$adminPwd = isset($_POST['adminPwd']) ? encrypt($_POST['adminPwd']) : ''; 
    	$adminEmail = isset($_POST['adminEmail']) ? $_POST['adminEmail'] : '';
    	$siteUrl = isset($_POST['siteUrl']) ? $_POST['siteUrl'] : '';
    	$defaultPlugin = isset($_POST['defaultPlugin']) ? $_POST['defaultPlugin'] : '';
    	$urlRewriting = isset($_POST['urlRewriting']) ? $_POST['urlRewriting'] : '';
    	$theme = isset($_POST['theme']) ? $_POST['theme'] : '';
    	$siteLang = isset($_POST['siteLang']) ? $_POST['siteLang'] : '';
    	$hideTitles = isset($_POST['hideTitles']) ? $_POST['hideTitles'] : '';
    	
        # Ecriture du fichier de configuration
    	$config = array(
           'siteName'        => $siteName,
           'siteDescription' => $siteDescription,
           'siteTimezone'    => $siteTimezone,
           'adminPwd'        => $adminPwd,
           'adminEmail'      => $adminEmail,
           'siteUrl'         => $siteUrl,        
           'urlRewriting'    => '0',
           'theme'           => 'default',
           'siteLang'        => $siteLang,
           'hideTitles'      => '0',
           'defaultPlugin'   => 'page',
        );  		
        if(!@file_put_contents(ROOT.'data/config.txt', json_encode($config)) ||	!@chmod('data/config.txt', 0666)) $error = true;

        if($error){
	      $data['msg'] = lang('Problem when installing');
	      $data['msgType'] = "error";
        }
        else{              
	      $data['msg'] = lang('99ko is installed') . '<br />' . lang('Also, delete the install.php file');
	      $data['msgType'] = "success";
	      eval(callHook('installSuccess'));
	      $_SESSION['msg_install'] = $data['msg'];
	      header('location:admin/index.php');
	      die();
        }  
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?php echo lang("99ko installer"); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="admin/css/foundation.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700,900,400italic' type='text/css' rel='stylesheet' />
    <link href='http://fonts.googleapis.com/css?family=Audiowide' rel='stylesheet' type='text/css'>
    <script src="plugin/extras/other/modernizr.js"></script>
    <script src="plugin/extras/other/jquery.min.js"></script>	
    <script src="admin/js/all.min.js"></script>
	<style>
		.container {
			max-width: 600px;
			margin: 100px auto 40px auto;
		}
		body {
	        font-family: "Source Sans Pro","Helvetica","Arial",sans-serif;        
	        font-size: 16px;
	        line-height: 26px;
	        color: #333;
	    }
		h1 {
			font-size: 126px;
			font-family: 'Audiowide', cursive;
			color: #333;
		}
		h1 img{
			padding: 0 20px 20px 0;
		}		
		.step-1 ul li {
		    -webkit-font-smoothing: subpixel-antialiased;
		    -webkit-box-shadow: 0 1px 3px rgba(0,0,0,.13);
		            box-shadow: 0 1px 3px rgba(0,0,0,.13);
		    margin-bottom: 15px;
		    padding: 5px;
		}
	</style>
	<script>
		$(document).ready(function() {
		    $('#btReload').click(function() { location.reload(true); });
			$('.continue').click(function() {
				$('.step-1').addClass('hide');
				$('.step-2').removeClass('hide');
			});
		});
	</script>
  </head>
  
  <body>
    <div class="container">
	   <h1><img src="admin/images/logo.png" alt="99ko" /> 99ko</h1>
	   
       <div class="row panel">
        <noscript>
            <div class="alert-box warning radius">
                <?php echo lang("99ko installer requires JavaScript. I will only be visible if you have it disabled."); ?>
            </div>
        </noscript> 
                      
		<div class="step-1">
		    <h3 class="subheader"><?php echo lang("Verifying the installation"); ?></h3>
		    <hr />
 			<ul class="no-bullet">
            <?php

                if (version_compare(PHP_VERSION, "5.1.2", "<")) {
                    echo '<li class="alert-box alert radius">'.lang('You must have a server equipped with PHP 5.1.2 or more !').'</li>';
                } else {
                    echo '<li class="alert-box success radius">PHP Version <b>'.PHP_VERSION.'</b></li>';
                }

                if (function_exists('apache_get_modules')) {
                    if ( ! in_array('mod_rewrite',apache_get_modules())) {
                        echo '<li class="alert-box alert radius">'.lang('Apache Mod Rewrite is required').'</li>';
                    } else {
                        echo '<li class="alert-box success radius">'.lang('Module Mod Rewrite is installed').'</li>';
                    }
                } else {
                    echo '<li class="alert-box success radius">'.lang('Module Mod Rewrite is installed').'</li>';
                }

                foreach ($dir_array as $dir) {
                    if (is_writable($dir.'/')) {
                        echo '<li class="alert-box success radius">'.lang('Directory').': <b> '.$dir.' </b> '.lang('writable').'</li>';
                    } else {
                        echo '<li class="alert-box alert radius">'.lang('Directory').': <b> '.$dir.' </b> '.lang('not writable').'</li>';
                    }
                }

                if (is_writable(__FILE__)) {
                    echo '<li class="alert-box success radius">'.lang('Install script writable').'</li>';
                } else {
                    echo '<li class="alert-box alert radius">'.lang('Install script not writable').'</li>';
                }

                if (is_writable('.htaccess')) {
                    echo '<li class="alert-box success radius">'.lang('Main .htaccess file writable').'</li>';
                } else {
                    echo '<li class="alert-box alert radius">'.lang('Main .htaccess file not writable').'</li>';
                }
            ?>
            </ul>
            <?php
				if (count($errors) == 0) {
			?>
				<a class="button radius right continue"><?php echo lang("Continue"); ?></a>
			<?php
				} else {
            ?>
            <a class="button radius secondary right" disabled><?php echo lang("Continue"); ?></a> <a id="btReload" class="button radius right"><?php echo lang("If ok reload"); ?></a>
            <?php } ?>
		</div>


		<div class="step-2 hide">		
		<h3 class="subheader"><?php echo lang("99ko installer"); ?> <?php echo VERSION; ?></h3>
		<hr />
		<form role="form" method="post">
		
		  <div class="row">
		     <div class="large-12 columns">
                 <label for="siteName"><?php echo lang("Site name"); ?></label>
                 <input type="text" name="siteName" id="siteName" placeholder="<?php echo lang("Site name"); ?>" required>
		     </div>
		  </div>

		  <div class="row">
		     <div class="large-12 columns">
                 <label for="siteDescription"><?php echo lang("Site description"); ?></label>
                 <input type="text" name="siteDescription" id="siteDescription" placeholder="<?php echo lang("Site description"); ?>" required>
		     </div>
		  </div>
		  		  		
		  <div class="row">
		     <div class="large-4 columns">
                 <label for="siteLang"><?php echo lang("Lang"); ?></label>
                 <select name="siteLang">
                     <option value="fr">Français</option>
                     <option value="en">English</option>
                 </select>
		     </div>
		  </div>
		  		  
		  <div class="row">
		     <div class="large-12 columns">
                 <label for="siteUrl"><?php echo lang("URL of the site (no trailing slash)"); ?></label>
                 <input type="text" name="siteUrl" id="siteUrl" placeholder="<?php echo getSiteUrl(); ?>" value="<?php echo getSiteUrl(); ?>" required>
		     </div>
		  </div>
		  
		  <div class="row">
		     <div class="large-12 columns">
                 <label for="adminEmail"><?php echo lang("Admin mail"); ?></label>
                 <input type="text" name="adminEmail" id="adminEmail" placeholder="admin@mysite.com" required>
		     </div>
		  </div>
		  
		  <div class="row">
		     <div class="large-12 columns">
                 <label for="adminPwd"><?php echo lang('Password'); ?></label>
                 <input type="password" name="adminPwd" id="adminPwd" placeholder="********" required>
		     </div>
		  </div>		  		  

		  <div class="row">
		     <div class="large-12 columns">
                 <label for="siteTimezone"><?php echo lang("Time zone"); ?></label>
                 <select class="form-control" name="siteTimezone">
                     <option value="Kwajalein">(GMT-12:00) International Date Line West</option>
                     <option value="Pacific/Samoa">(GMT-11:00) Midway Island, Samoa</option>
                     <option value="Pacific/Honolulu">(GMT-10:00) Hawaii</option>
                     <option value="America/Anchorage">(GMT-09:00) Alaska</option>
                     <option value="America/Los_Angeles">(GMT-08:00) Pacific Time (US &amp; Canada)</option>
                     <option value="America/Tijuana">(GMT-08:00) Tijuana, Baja California</option>
                     <option value="America/Denver">(GMT-07:00) Mountain Time (US &amp; Canada)</option>
                     <option value="America/Chihuahua">(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
                     <option value="America/Phoenix">(GMT-07:00) Arizona</option>
                     <option value="America/Regina">(GMT-06:00) Saskatchewan</option>
                     <option value="America/Tegucigalpa">(GMT-06:00) Central America</option>
                     <option value="America/Chicago">(GMT-06:00) Central Time (US &amp; Canada)</option>
                     <option value="America/Mexico_City">(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
                     <option value="America/New_York">(GMT-05:00) Eastern Time (US &amp; Canada)</option>
                     <option value="America/Bogota">(GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
                     <option value="America/Indiana/Indianapolis">(GMT-05:00) Indiana (East)</option>
                     <option value="America/Caracas">(GMT-04:30) Caracas</option>
                     <option value="America/Halifax">(GMT-04:00) Atlantic Time (Canada)</option>
                     <option value="America/Manaus">(GMT-04:00) Manaus</option>
                     <option value="America/Santiago">(GMT-04:00) Santiago</option>
                     <option value="America/La_Paz">(GMT-04:00) La Paz</option>
                     <option value="America/St_Johns">(GMT-03:30) Newfoundland</option>
                     <option value="America/Argentina/Buenos_Aires">(GMT-03:00) Buenos Aires</option>
                     <option value="America/Sao_Paulo">(GMT-03:00) Brasilia</option>
                     <option value="America/Godthab">(GMT-03:00) Greenland</option>
                     <option value="America/Montevideo">(GMT-03:00) Montevideo</option>
                     <option value="America/Argentina/Buenos_Aires">(GMT-03:00) Georgetown</option>
                     <option value="Atlantic/South_Georgia">(GMT-02:00) Mid-Atlantic</option>
                     <option value="Atlantic/Azores">(GMT-01:00) Azores</option>
                     <option value="Atlantic/Cape_Verde">(GMT-01:00) Cape Verde Is.</option>
                     <option value="Europe/London">(GMT) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London</option>
                     <option value="Atlantic/Reykjavik">(GMT) Monrovia, Reykjavik</option>
                     <option value="Africa/Casablanca">(GMT) Casablanca</option>
                     <option value="Europe/Belgrade">(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
                     <option value="Europe/Sarajevo">(GMT+01:00) Sarajevo, Skopje, Warsaw, Zagreb</option>
                     <option value="Europe/Brussels">(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
                     <option value="Africa/Algiers">(GMT+01:00) West Central Africa</option>
                     <option value="Europe/Amsterdam">(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
                     <option value="Africa/Cairo">(GMT+02:00) Cairo</option>
                     <option value="Europe/Helsinki">(GMT+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius</option>
                     <option value="Europe/Athens">(GMT+02:00) Athens, Bucharest, Istanbul</option>
                     <option value="Asia/Jerusalem">(GMT+02:00) Jerusalem</option>
                     <option value="Asia/Amman">(GMT+02:00) Amman</option>
                     <option value="Asia/Beirut">(GMT+02:00) Beirut</option>
                     <option value="Africa/Windhoek">(GMT+02:00) Windhoek</option>
                     <option value="Africa/Harare">(GMT+02:00) Harare, Pretoria</option>
                     <option value="Asia/Kuwait">(GMT+03:00) Kuwait, Riyadh</option>
                     <option value="Asia/Baghdad">(GMT+03:00) Baghdad</option>
                     <option value="Europe/Minsk">(GMT+03:00) Minsk</option>
                     <option value="Africa/Nairobi">(GMT+03:00) Nairobi</option>
                     <option value="Asia/Tbilisi">(GMT+03:00) Tbilisi</option>
                     <option value="Asia/Tehran">(GMT+03:30) Tehran</option>
                     <option value="Asia/Muscat">(GMT+04:00) Abu Dhabi, Muscat</option>
                     <option value="Asia/Baku">(GMT+04:00) Baku</option>
                     <option value="Europe/Moscow">(GMT+04:00) Moscow, St. Petersburg, Volgograd</option>
                     <option value="Asia/Yerevan">(GMT+04:00) Yerevan</option>
                     <option value="Asia/Karachi">(GMT+05:00) Islamabad, Karachi</option>
                     <option value="Asia/Tashkent">(GMT+05:00) Tashkent</option>
                     <option value="Asia/Kolkata">(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
                     <option value="Asia/Colombo">(GMT+05:30) Sri Jayawardenepura</option>
                     <option value="Asia/Katmandu">(GMT+05:45) Kathmandu</option>
                     <option value="Asia/Dhaka">(GMT+06:00) Astana, Dhaka</option>
                     <option value="Asia/Yekaterinburg">(GMT+06:00) Ekaterinburg</option>
                     <option value="Asia/Rangoon">(GMT+06:30) Yangon (Rangoon)</option>
                     <option value="Asia/Novosibirsk">(GMT+07:00) Almaty, Novosibirsk</option>
                     <option value="Asia/Bangkok">(GMT+07:00) Bangkok, Hanoi, Jakarta</option>
                     <option value="Asia/Beijing">(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
                     <option value="Asia/Krasnoyarsk">(GMT+08:00) Krasnoyarsk</option>
                     <option value="Asia/Ulaanbaatar">(GMT+08:00) Irkutsk, Ulaan Bataar</option>
                     <option value="Asia/Kuala_Lumpur">(GMT+08:00) Kuala Lumpur, Singapore</option>
                     <option value="Asia/Taipei">(GMT+08:00) Taipei</option>
                     <option value="Australia/Perth">(GMT+08:00) Perth</option>
                     <option value="Asia/Seoul">(GMT+09:00) Seoul</option>
                     <option value="Asia/Tokyo">(GMT+09:00) Osaka, Sapporo, Tokyo</option>
                     <option value="Australia/Darwin">(GMT+09:30) Darwin</option>
                     <option value="Australia/Adelaide">(GMT+09:30) Adelaide</option>
                     <option value="Australia/Sydney">(GMT+10:00) Canberra, Melbourne, Sydney</option>
                     <option value="Australia/Brisbane">(GMT+10:00) Brisbane</option>
                     <option value="Australia/Hobart">(GMT+10:00) Hobart</option>
                     <option value="Asia/Yakutsk">(GMT+10:00) Yakutsk</option>
                     <option value="Pacific/Guam">(GMT+10:00) Guam, Port Moresby</option>
                     <option value="Asia/Vladivostok">(GMT+11:00) Vladivostok</option>
                     <option value="Pacific/Fiji">(GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
                     <option value="Asia/Magadan">(GMT+12:00) Magadan, Solomon Is., New Caledonia</option>
                     <option value="Pacific/Auckland">(GMT+12:00) Auckland, Wellington</option>
                     <option value="Pacific/Tongatapu">(GMT+13:00) Nukualofa</option>
                 </select>
		     </div>		     
		  </div>		  		  
		  <input type="submit" name="install_submit" class="button success large radius right" value="<?php echo lang("Install"); ?>">
		</form>
       		
		</div>
       </div> <!-- row & pannel Fin -->		
    </div>
  </body>
</html>
