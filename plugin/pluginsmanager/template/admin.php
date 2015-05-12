<?php defined('ROOT') OR exit('No direct script access allowed'); ?>
<?php include_once(ROOT.'admin/header.php') ?>

<form method="post" action="index.php?p=pluginsmanager&action=save" id="pluginsmanagerForm">
	<?php showAdminTokenField(); ?>
	<table style="width:100%">
	  <thead>
		<tr>
			<th style="width:30%"><?php echo lang("Name"); ?></th>
			<th style="width:50%"><?php echo lang("Description"); ?></th>
			<th style="width:3%"><?php echo lang("Version"); ?></th>
			<th style="width:3%"><?php echo lang("Priority"); ?></th>
			<th style="width:4%"><?php echo lang("Enable"); ?></th>
		</tr>
	  </thead>
	  <tbody>			  	
		<?php foreach($pluginsManager->getPlugins() as $plugin){ ?>
		<tr>
			<td>
				<h6><?php echo lang($plugin->getInfoVal('name')); ?></h6>
			</td>
			<td>			
			<?php echo lang($plugin->getInfoVal('description')); ?><br>
			<a class="label secondary round" href="<?php echo $plugin->getInfoVal('authorWebsite'); ?>" target="_blank"><?php echo $plugin->getInfoVal('authorWebsite'); ?></a>
			</td>
			
			<td><?php echo $plugin->getInfoVal('version'); ?></td>
			
			<td><?php echo utilHtmlSelect($priority, $plugin->getconfigVal('priority'), 'name="priority['.$plugin->getName().']" onchange="document.getElementById(\'pluginsmanagerForm\').submit();"'); ?></td>
			
			<td><br /><div class="switch tiny radius"><input onchange="document.getElementById('pluginsmanagerForm').submit();" id="activate[<?php echo $plugin->getName(); ?>]" type="checkbox" name="activate[<?php echo $plugin->getName(); ?>]" <?php if($plugin->getConfigVal('activate')){ ?>checked<?php } ?> /><label for="activate[<?php echo $plugin->getName(); ?>]"></label></div></td>
		</tr>
		<?php } ?>
	  </tbody>					
	</table>
</form>

<?php include_once(ROOT.'admin/footer.php') ?>