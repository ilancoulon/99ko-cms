<?php defined('ROOT') OR exit('No direct script access allowed'); ?>
<?php include_once(ROOT.'admin/header.php') ?>
<?php eval(callHook('startAdminHome')); ?>

	<div id="notifs" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
			<h2 id="modalTitle">Notifications</h2>
			<?php eval(callHook('notifsAdminHome')); ?>
			<p>Nouveau hook 'notifsAdminHome', on pourrais donc compter le nombre de notifications en homepage de l'admin et indiquer ce nombre dans le menu (header.php). Cela permet une meilleur visibilité de cette page d'accueil dont on charge le plugin page par défaut.</p>
			<p>Ensuite on pourrait remplacer le paramètre de la sidebar en config :<pre>    "sidebarTitle" : "",
    "sidebarCallFunction" : "",</pre> par : <pre> "HomePage" : "1"</pre></p>
    		<p>Quand penses-tu ?</p>
			<a class="close-reveal-modal" aria-label="Close">&#215;</a>
	</div>

	<div class="panel"> 
	   <h3 class="subheader">
          <?php echo lang('Download a more recent version, plugins and themes on the site official.'); ?><br />
	      <?php echo lang('In case of problem with 99ko, go to the support forum.'); ?>
	   </h3>
	</div>
	<ul class="button-group radius">
	    <li><a class="button secondary" href="http://99ko.hellojo.fr" onclick="window.open(this.href);return false;"><?php echo lang('Official site'); ?></a></li> 
	    <li><a class="button" href="http://99ko.hellojo.fr/forum" onclick="window.open(this.href);return false;"><?php echo lang('Board support'); ?></a></li>
   </ul>
   <?php eval(callHook('endAdminHome')); ?>
<?php include_once(ROOT.'admin/footer.php') ?>
