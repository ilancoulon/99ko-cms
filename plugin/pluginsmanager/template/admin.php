<?php if(!defined('ROOT')) die(); ?>
<?php include_once(ROOT.'admin/header.php') ?>

<form method="post" action="index.php?p=pluginsmanager&action=save" id="pluginsmanagerForm">
	<?php showMsg($msg, $msgType); ?>
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
		<?php foreach($plugins as $k=>$v){ ?>
		<tr>
			<td>
				<?php echo $v['name']; ?>
			</td>
			<td>
			<?php if($v['target'] && $v['activate']){ ?><a class="button tiny radius secondary" href="<?php echo $v['target']; ?>"><?php echo lang("Go to plugin"); ?></a><?php } ?> 
			<a href="#" data-reveal-id="<?php echo utilStrToUrl($v['name']); ?>" class="button tiny radius"><?php echo lang("About"); ?></a>
	        <div id="<?php echo utilStrToUrl($v['name']); ?>" class="reveal-modal small" data-reveal>
		        <h2><?php echo lang("Plugin"); ?> : <?php echo lang($v['name']); ?></h2>
		        <blockquote><?php echo lang($v['description']); ?><cite><?php echo lang("Author"); ?> :<?php echo $v['author']; ?></cite></blockquote>
		        <p><?php echo $v['authorEmail']; ?></p>
		        <p><a href="<?php echo $v['authorWebsite']; ?>" target="_blank"><?php echo $v['authorWebsite']; ?></a></p>
		        <a class="close-reveal-modal">&#215;</a>
	        </div>
			</td>
			<td><?php echo $v['version']; ?></td>
			<td><?php echo utilHtmlSelect($priority, $v['priority'], 'name="priority['.$v['id'].']" onchange="document.getElementById(\'pluginsmanagerForm\').submit();"'); ?></td>
			<td><input onchange="document.getElementById('pluginsmanagerForm').submit();" <?php if($v['activate']){ ?>checked<?php } ?> type="checkbox" name="activate[<?php echo $v['id']; ?>]"<?php if($v['locked']){ ?> style="display:none;"<?php } ?> /></td>
		</tr>
		<?php } ?>
	  </tbody>					
	</table>
</form>

<?php include_once(ROOT.'admin/footer.php') ?>