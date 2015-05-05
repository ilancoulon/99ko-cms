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
$_SESSION['token'] = sha1(uniqid(mt_rand()));
define('ROOT', './');
define('EXTRAS', ROOT.'plugin/extras/other/');
# plugin par defaut
define('DEFAULT_PLUGIN', 'page');
include_once(ROOT.'common/constants.php');
include_once(COMMON.'core.lib.php');
# Gestion des erreurs PHP (Dev Mod)
if(DEBUG) error_reporting(E_ALL).ini_set('display_errors', 1);
else error_reporting(E_ALL ^ E_NOTICE);
utilSetMagicQuotesOff();

/*
 *---------------------------------------------------------------
 * CHARGEMENT DE LA LANGUE (À DÉFINIR SUR LA PAGE D'INSTALLATION)
 *---------------------------------------------------------------
 */
$langs_select = array('fr'=> 'French', 'en' => 'English');
if (isset($_POST['submit_lang'])) { 
    $_SESSION['lang'] = isset($_POST['siteLang']) ? $_POST['siteLang'] : '';
    $lang = utilReadJsonFile(LANG. $_SESSION['lang'].'.json');
} else {
	$_SESSION['lang'] = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
	$lang = $_SESSION['lang'];
}
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
if (version_compare(PHP_VERSION, '5.2', '<')) {
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
$error = '';
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

  $key = uniqid(true);
  if(!file_exists(DATA. 'key.php') && !@file_put_contents(DATA. 'key.php', "<?php define('KEY', '$key'); ?>", 0666)) $error = true;
  if(!file_exists(DATA. 'key.php')) include(DATA. 'key.php');

            foreach($pluginsManager->getPlugins() as $plugin){
  	          if($plugin->getLibFile()){
  		          include_once($plugin->getLibFile());
  		          if(!$plugin->isInstalled()) $pluginsManager->installPlugin($plugin->getName());
			  $plugin->setConfigVal('activate', '1');
			  $pluginsManager->savePluginConfig($plugin);
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
    	$adminPwd = isset($_POST['adminPwd']) ? encrypt($_POST['adminPwd']) : ''; 
    	$adminEmail = isset($_POST['adminEmail']) ? $_POST['adminEmail'] : '';
    	$siteUrl = isset($_POST['siteUrl']) ? $_POST['siteUrl'] : '';
    	$defaultPlugin = isset($_POST['defaultPlugin']) ? $_POST['defaultPlugin'] : '';
    	$urlRewriting = isset($_POST['urlRewriting']) ? $_POST['urlRewriting'] : '';
    	$theme = isset($_POST['theme']) ? $_POST['theme'] : '';
    	$siteLang = isset($lang) ? $lang : '';
    	$hideTitles = isset($_POST['hideTitles']) ? $_POST['hideTitles'] : '';
    	$checkUrl = base64_decode('aHR0cDovLzk5a28uaGVsbG9qby5mci92ZXJzaW9u');
    	
        # Ecriture du fichier de configuration
    	$config = array(
           'siteName'        => $siteName,
           'siteDescription' => $siteDescription,
           'adminPwd'        => $adminPwd,
           'adminEmail'      => $adminEmail, # A SECURISER !!!!!
           'siteUrl'         => $siteUrl,        
           'urlRewriting'    => '0',
           'theme'           => 'default',
           'siteLang'        => $siteLang,
           'hideTitles'      => '0',
           'defaultPlugin'   => 'page',
           'checkUrl'        => $checkUrl,
           'debug'           => '0',
        );  		
        if(!@file_put_contents(DATA. 'config.txt', json_encode($config)) ||	!@chmod(DATA. 'config.txt', 0666)) $error = true;

        if($error){
	      $data['msg'] = lang('Problem when installing');
	      $data['msgType'] = "error";
        }
		elseif(!util::isEmail(trim($_POST['adminEmail']))){
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
    <link rel="stylesheet" href="<?php echo EXTRAS; ?>admin.css" media="all">
    <link rel="stylesheet" href="<?php echo EXTRAS; ?>foundation.min.css?v=5.2.2" media="all">
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700,900,400italic" type="text/css" rel="stylesheet" />
    <link href="http://fonts.googleapis.com/css?family=Audiowide" type="text/css" rel="stylesheet">
    <script src="<?php echo EXTRAS; ?>admin.js"></script>	
	<style>
	.container {max-width: 600px; margin: 100px auto 40px auto;}
    body {font-family: "Source Sans Pro","Helvetica","Arial",sans-serif; font-size: 16px; line-height: 26px; color: #333;}
    h1 {font-size: 126px; font-family: 'Audiowide', cursive; color: #333;}
    h1 img {padding: 0 20px 20px 0}
    .panel {-webkit-font-smoothing: subpixel-antialiased; -webkit-box-shadow: 0 1px 3px rgba(0,0,0,.13); box-shadow: 0 1px 3px rgba(0,0,0,.13); margin-bottom: 15px;}
	</style>
  </head>
  
  <body>
    <div class="container">
	   <h1><img src="admin/assets/logo.png" alt="99ko" /> 99ko</h1>

	   <div class="row">	   
	   <form role="form" method="post">   
               <div class="large-6 columns"></div> 
                           
               <div class="large-6 columns">
                 <div class="row collapse">
                    <div class="small-8 columns">
						<select name="siteLang">
							<?php foreach($langs_select as $k => $v) { ?>
							<option <?php if($k == $lang){ ?>selected="selected"<?php } ?> value="<?php echo $k; ?>"><?php echo lang($v); ?></option>
							<?php }?>			
	  					</select>	                    	
                    </div>
                    <div class="small-4 columns">
                       <input type="submit" name="submit_lang" class="button postfix" value="<?php echo lang("Go"); ?>">
                   </div>
                 </div>
               </div>
 	   </form>
       </div>		    	
	   	   
       <div class="row panel">
                <noscript>
                    <?php showMsg(lang("Javascript must be enabled in your browser to take full advantage of features 99ko."), "error"); ?> 
                </noscript> 
                <?php showMsg($msg, $msgType); // Affichage de toutes les Notifications ?>
		
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

       </div> <!-- row & pannel Fin -->	
       
       <p class="text-center">
               <a title="<?php echo lang("NoDB CMS"); ?>" onclick="window.open(this.href);return false;" href="http://99ko.hellojo.fr"><?php echo lang("Just using <b>99ko</b>"); ?></a>
       </p>	
       
    </div>
  </body>
</html>
