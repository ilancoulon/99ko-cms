<?php
/**
 * 99ko cms
 *
 * This source file is part of the 99ko cms. More information,
 * documentation and support can be found at http://99ko.hellojo.fr
 *
 * @package     99ko
 *
 * @author      Jonathan Coulet (j.coulet@gmail.com)
 * @copyright   2013-2014 Florent Fortat (florent.fortat@maxgun.fr) / Jonathan Coulet (j.coulet@gmail.com) / Frédéric Kaplon (frederic.kaplon@me.com)
 * @copyright   2010-2012 Florent Fortat (florent.fortat@maxgun.fr) / Jonathan Coulet (j.coulet@gmail.com)
 * @copyright   2010 Jonathan Coulet (j.coulet@gmail.com)  
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
session_start();
define('ROOT', './');
// plugin par defaut
define('DEFAULT_PLUGIN', 'page');
include_once(ROOT.'common/constants.php');
include_once(COMMON.'core.lib.php');
# Gestion des erreurs PHP (Dev Mod)
if(DEBUG) error_reporting(E_ALL);
else error_reporting(E_ALL ^ E_NOTICE);
utilSetMagicQuotesOff();

/*
 *---------------------------------------------------------------
 * CHARGEMENT DE LA LANGUE (À DÉFINIR SUR LA PAGE D'INSTALLATION)
 *---------------------------------------------------------------
 */
# $languages_array = array('fr'=> lang("French"), 'en' => lang("English"));
if (isset($_POST['submit_lang'])) { 
    $_SESSION['lang'] = isset($_POST['siteLang']) ? $_POST['siteLang'] : '';
    $lang = utilReadJsonFile(LANG. $_SESSION['lang'].'.json');
}
$timezones = listTimezones();
$pluginsManager = new pluginsManager();
$hooks = array();
# Vérification que le fichier de configuration n'existe pas
if(file_exists(DATA. 'config.txt')) die(lang('Config file already exist !'));
/*
 *---------------------------------------------------------------
 * ON VÉRIFIE QUE LE SERVEUR PEUT FAIRE TOURNER 99KO
 *---------------------------------------------------------------
 */
# Obtien un tableau avec les noms de tous les modules compilés et chargés
$php_modules = get_loaded_extensions();
# On initialise les erreurs
$errors = array();
$msg = '';
$msgType = '';
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
 *---------------------------------------------------------------
 * CRÉATION DES FICHIERS NÉCESSAIRES A 99KO
 *---------------------------------------------------------------
 */
@chmod(ROOT.'.htaccess', 0666);
if(!file_exists(ROOT.'.htaccess')){
	if(!@file_put_contents(ROOT.'.htaccess', "Options -Indexes", 0666)) $error = true;
}
if(!is_dir(DATA) && (!@mkdir(DATA) || !@chmod(DATA, 0777))) $error = true;

if (!$error) {
  if(!file_exists(DATA. '.htaccess')){
  	if(!@file_put_contents(DATA. '.htaccess', "deny from all", 0666)) $error = true;
  }
  if(!is_dir(DATA_PLUGIN) && (!@mkdir(DATA_PLUGIN) || !@chmod(DATA_PLUGIN, 0777))) $error = true;
  if(!is_dir(UPLOAD) && (!@mkdir(UPLOAD) || !@chmod(UPLOAD, 0777))) $error = true;
  if(!file_exists(UPLOAD. '.htaccess')){
  	if(!@file_put_contents(UPLOAD. '.htaccess', "allow from all", 0666)) $error = true;
  }
  # Chmodd sur le fichier install.php
  if(!file_exists(__FILE__) || !@chmod(__FILE__, 0666)) $error = true;
  # Encodage du robots.txt
  $robots = 'VXNlci1hZ2VudDogKg0KRGlzYWxsb3c6IC9hZG1pbi8NCkRpc2FsbG93OiAvY29tbW9uLw0KRGlzYWxsb3c6IC9kYXRhLw0KRGlzYWxsb3c6IC9wbHVnaW4vDQpEaXNhbGxvdzogL3RoZW1lLw==';
  if(!file_exists(ROOT.'robots.txt')){
  	if(!@file_put_contents(ROOT.'robots.txt', base64_decode($robots), 0666)) $error = true;
  }

  $key = uniqid(true);
  if(!file_exists(DATA. 'key.php') && !@file_put_contents(DATA. 'key.php', "<?php define('KEY', '$key'); ?>", 0666)) $error = true;
  if(!file_exists(DATA. 'key.php')) include(DATA. 'key.php');

            foreach($pluginsManager->getPlugins() as $plugin){
  	          if($plugin->getLibFile()){
  		          include_once($plugin->getLibFile());
  		          if(!$plugin->isInstalled()) $pluginsManager->installPlugin($plugin->getName());
  	          }
            }
            foreach($pluginsManager->getPlugins() as $plugin){
  	        foreach($plugin->getHooks() as $hookName=>$function) $hooks[$hookName][] = $function;
            }
}
/*
 *---------------------------------------------------------------
 * PROCÉSSUS D'INSTALLATION LORS DU SUBMIT
 *---------------------------------------------------------------
 */                 
if (isset($_POST['install_submit'])) {
        $error = array();
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
           'adminEmail'      => $adminEmail, # A SECURISER !!!!!
           'siteUrl'         => $siteUrl,        
           'urlRewriting'    => '0',
           'theme'           => 'default',
           'siteLang'        => $siteLang,
           'hideTitles'      => '0',
           'defaultPlugin'   => 'page',
           'checkUrl'        => 'http://99ko.hellojo.fr/version',
           'gzip'            => '1',
        );  		
        if(!@file_put_contents(DATA. 'config.txt', json_encode($config)) ||	!@chmod(DATA. 'config.txt', 0666)) $error = true;

        if($error){
	      $data['msg'] = lang('Problem when installing');
	      $data['msgType'] = "error";
        }
		elseif(!utilIsEmail(trim($_POST['adminEmail']))){
			$msg = lang("Invalid email.");
			$msgType = 'error';
		}        
        else{              
	      $_SESSION['msg_install'] = true;
	      header('location:admin/index.php');
	      die();
        }  
} 
/*
 *---------------------------------------------------------------
 * RENDUS HTML DE LA PAGE D'INSTALLATION
 *---------------------------------------------------------------
 */ 
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?php echo lang("99ko installer"); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo ADMIN_PATH ?>assets/css/minified.css.php?v=5.2.1" media="all">
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700,900,400italic' type='text/css' rel='stylesheet' />
    <link href='http://fonts.googleapis.com/css?family=Audiowide' rel='stylesheet' type='text/css'>
    <script src="plugin/extras/other/modernizr.js"></script>
    <script src="plugin/extras/other/jquery.min.js"></script>	
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
	   <h1><img src="admin/assets/logo.png" alt="99ko" /> 99ko</h1>
	   
	   <form role="form" method="post">  
	   <div class="row"> 
               <div class="large-6 columns"></div> 
                           
               <div class="large-6 columns">
                 <div class="row collapse">
                    <div class="small-8 columns">
                       <select name="siteLang">
                          <option value="fr"><?php echo lang("French"); ?></option>
                          <option value="en"><?php echo lang("English"); ?></option>
                       </select>	
                    </div>
                    <div class="small-4 columns">
                       <input type="submit" name="submit_lang" class="button postfix" value="<?php echo lang("Go"); ?>">
                   </div>
                 </div>
               </div>
 
       </div>		    
	   </form>	
	   	   
       <div class="row panel">
                <noscript>
                    <?php showMsg(lang("Javascript must be enabled in your browser to take full advantage of features 99ko."), "error"); ?> 
                </noscript> 
                <?php showMsg($msg, $msgType); // Affichage de toutes les Notifications ?>
                      
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
		<?php showAdminTokenField(); ?>
		
		  <div class="row">
		     <div class="large-12 columns">
                 <label for="siteName"><?php echo lang("Site name"); ?> :</label>
                 <input type="text" name="siteName" id="siteName" autocomplete="off" required />
		     </div>
		  </div>

		  <div class="row">
		     <div class="large-12 columns">
                 <label for="siteDescription"><?php echo lang("Site description"); ?> :</label>
                 <input type="text" name="siteDescription" id="siteDescription" autocomplete="off" required />
		     </div>
		  </div>
		  		  		
		  <div class="row">
		     <div class="large-4 columns">
                 <label for="siteLang"><?php echo lang("Lang"); ?> :</label>
                 <select name="siteLang">
                     <option value="fr"><?php echo lang("French"); ?></option>
                     <option value="en"><?php echo lang("English"); ?></option>
                 </select>
		     </div>
		     
		     <div class="large-8 columns">
                 <label for="siteTimezone"><?php echo lang("Time zone"); ?> :</label>
                 <select name="siteTimezone">
                     <?php foreach($timezones as $k=>$v){ ?>
                     <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                     <?php } ?>
                 </select>  
		     </div>			     
		  </div>
		  		  
		  <div class="row">
		     <div class="large-12 columns">
                 <label for="siteUrl"><?php echo lang("URL of the site (no trailing slash)"); ?> :</label>
                 <input type="url" name="siteUrl" id="siteUrl" value="<?php echo getSiteUrl(); ?>" required />
		     </div>
		  </div>
		  
		  <div class="row">
		     <div class="large-12 columns">
                 <label for="adminEmail"><?php echo lang("Admin mail"); ?> :</label>
                 <input type="email" name="adminEmail" id="adminEmail" autocomplete="off" required />
		     </div>
		  </div>
		  
		  <div class="row">
		     <div class="large-12 columns">
                 <label for="adminPwd"><?php echo lang('Password'); ?> :</label>
                 <input type="password" name="adminPwd" id="adminPwd" autocomplete="off" required />
		     </div>
		  </div>		  		  
		  		  
		  <input type="submit" name="install_submit" class="button success large radius right" value="<?php echo lang("Install"); ?>">
		</form>
       		
		</div>
       </div> <!-- row & pannel Fin -->	
       
       <p class="text-center">
               <a title="<?php echo lang("NoDB CMS"); ?>" onclick="window.open(this.href);return false;" href="http://99ko.hellojo.fr"><?php echo lang("Just using <b>99ko</b>"); ?></a>
       </p>	
       
    </div>
  </body>
</html>