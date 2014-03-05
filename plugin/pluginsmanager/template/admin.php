<?php defined('ROOT') OR exit('No direct script access allowed'); ?>
<?php include_once(ROOT.'admin/header.php') ?>

<form method="post" action="index.php?p=pluginsmanager&action=save" id="pluginsmanagerForm">
	<?php showAdminTokenField(); ?>
	<table style="width:100%">
	  <thead>
		<tr>
			<th><?php echo lang("Name"); ?></th>
			<th></th>
			<th><?php echo lang("Version"); ?></th>
			<th><?php echo lang("Priority"); ?></th>
			<th><?php echo lang("Enable"); ?></th>
		</tr>
	  </thead>
	  <tbody>			  	
		<?php foreach($pluginsManager->getPlugins() as $plugin){ ?>
		<tr>
			<td>
				<?php echo $plugin->getName();; ?>
			</td>
			<td>
			<?php if($plugin->getConfigVal('activate') && $plugin->getAdminFile()){ ?><a class="button tiny radius secondary" href="<?php echo 'index.php?p='.$plugin->getName(); ?>"><?php echo lang("Go to plugin"); ?></a><?php } ?> 
			<a href="#" data-reveal-id="<?php echo $plugin->getName(); ?>" class="button tiny radius"><?php echo lang("About"); ?></a>
	        <div id="<?php echo $plugin->getName(); ?>" class="reveal-modal small" data-reveal>
		        <h2><?php echo lang($plugin->getName()); ?></h2>
		        <blockquote><?php echo lang($plugin->getInfoVal('description')); ?><cite><?php echo lang("Author"); echo $plugin->getInfoVal('author'); ?></cite></blockquote>
		         <ul class="no-bullet">
		            <?php
                      if($plugin->getInfoVal('authorEmail') != ''){
                         echo '<li><strong>'.lang("Author Mail").'</strong> '.utilHideEmail($plugin->getInfoVal('authorEmail')).'</li>';
                      }
                      if($plugin->getInfoVal('authorWebsite') != ''){
                         echo '<li><strong>'.lang("Author Site").'</strong> <a class="label secondary round" href="'.$plugin->getInfoVal('authorWebsite').'" onclick="window.open(this.href);return false;">'.$plugin->getInfoVal('authorWebsite').'</a></li>';
                      }
                    ?>
		         </ul>		        
		        <a class="close-reveal-modal">&#215;</a>
	        </div>
			</td>
			<td><?php echo $plugin->getInfoVal('version'); ?></td>
			<td><?php echo utilHtmlSelect($priority, $plugin->getconfigVal('priority'), 'name="priority['.$plugin->getName().']" onchange="document.getElementById(\'pluginsmanagerForm\').submit();"'); ?></td>
			<td><input onchange="document.getElementById('pluginsmanagerForm').submit();" <?php if($plugin->getConfigVal('activate')){ ?>checked<?php } ?> type="checkbox" name="activate[<?php echo $plugin->getName(); ?>]" /></td>
		</tr>
		<?php } ?>
	  </tbody>					
	</table>
</form>

<?php include_once(ROOT.'admin/footer.php') ?>