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
		        <h2><?php echo lang($v['name']); ?></h2>
		        <blockquote><?php echo lang($v['description']); ?><cite><?php echo lang("Author"); echo $v['author']; ?></cite></blockquote>
		         <ul class="no-bullet">
		            <?php
                      if(!empty($v['authorEmail'])){
                         echo '<li><strong>'.lang("Author Mail").'</strong> '.$v['authorEmail'].'</li>';
                      }
                      if(!empty($v['authorWebsite'])){
                         echo '<li><strong>'.lang("Author Site").'</strong> <a class="label secondary round" href="'.$v['authorWebsite'].'" onclick="window.open(this.href);return false;">'.$v['authorWebsite'].'</a></li>';
                      }
                    ?>
		         </ul>		        
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