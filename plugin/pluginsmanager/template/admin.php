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
				<?php echo lang($plugin->getInfoVal('name')); ?>
			</td>
			<td>			
			<?php echo lang($plugin->getInfoVal('description')); ?><br>
			<a class="label secondary round" href="<?php echo $plugin->getInfoVal('authorWebsite'); ?>" target="_blank"><?php echo $plugin->getInfoVal('authorWebsite'); ?></a>
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