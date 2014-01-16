<?php include_once(ROOT.'admin/header.php'); ?>

<?php if ($data['menuMode'] == 'list') { ?>
<a class="button round small" id="addLink" onclick="addLink()"><?php echo lang('New link'); ?></a>
<form method="post" action="index.php?p=menu&action=save">
	<?php showAdminTokenField(); ?>
	<table id="linksList" style="width:100%">
		<thead>
			<tr>
				<th><?php echo lang('Label'); ?></th>
				<th><?php echo lang('Url'); ?></th>
				<th><?php echo lang('Target'); ?></th>
				<th></th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($data['menuLinks'] as $position=>$link) { ?>
			<tr id="<?php echo $position; ?>">
				<input type="hidden" name="id<?php echo $position; ?>" value="<?php echo $link->getId(); ?>" />
				<input type="hidden" name="plugin<?php echo $position; ?>" value="<?php echo $link->getPlugin(); ?>" />
				<td class="lab1">
					<?php if ($link->getPlugin() == 'menu') {?>
						<input type="text" name="label<?php echo $position; ?>" value="<?php echo $link->getLabel(); ?>" />
					<?php } else { ?>
						<input type="hidden" name="label<?php echo $position; ?>" value="<?php echo $link->getLabel(); ?>" />
						<?php echo $link->getLabel(); ?>
					<?php } ?>
				</td>
				<td class="url">
					<?php if ($link->getPlugin() == 'menu') {?>
						<input type="text" name="url<?php echo $position; ?>" value="<?php echo $link->getUrl(); ?>" />
					<?php } else { ?>
						<input type="hidden" name="url<?php echo $position; ?>" value="<?php echo $link->getUrl(); ?>" />
						<?php echo $link->getUrl(); ?>
					<?php } ?>
				</td>
				<td class="target">
					<?php if ($link->getPlugin() == 'menu') {?>
						<select name="target<?php echo $position; ?>">
							<option value="_self" <?php echo ($link->getTarget() == '_self' ? 'selected' : ''); ?>><?php echo lang('Current page'); ?></option>
							<option value="_blank" <?php echo ($link->getTarget() == '_blank' ? 'selected' : ''); ?>><?php echo lang('New page'); ?></option>
						</select>
					<?php } else { ?>
						<input type="hidden" name="target<?php echo $position; ?>" value="<?php echo $link->getTarget(); ?>" />
						<?php echo ($link->getTarget() == '_self' ? lang('Current page') : lang('New page')); ?>
					<?php } ?>
				</td>
				<td class="up">
					<?php if ($position > 0) {?>
						<a onclick="upLink(<?php echo $position; ?>)" data-tooltip class="has-tip tip-top" title="<?php echo lang('Up'); ?>"><img src="<?php echo MENU_PLUGINPATH; ?>img/up.png" alt="<?php echo lang('Up'); ?>" /></a>
					<?php } ?>
				</td>
				<td class="down">
					<?php if ($position < count($data['menuLinks']) - 1) {?>
						<a onclick="downLink(<?php echo $position; ?>)" data-tooltip class="has-tip tip-top" title="<?php echo lang('Down'); ?>"><img src="<?php echo MENU_PLUGINPATH; ?>img/down.png" alt="<?php echo lang('Down'); ?>" /></a>
					<?php } ?>
				</td>
				<td class="delete">
					<?php if ($link->getPlugin() == 'menu') {?>
						<a onclick="deleteLink(<?php echo $position; ?>)" data-tooltip class="has-tip tip-top" title="<?php echo lang('Delete'); ?>"><img src="<?php echo MENU_PLUGINPATH; ?>img/delete.png" alt="<?php echo lang('Delete'); ?>" /></a>
					<?php } ?>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<input type="hidden" name="number" value="<?php echo count($data['menuLinks']); ?>" />
	<div class="buttons">
		<button type="submit" class="button success radius"><?php echo lang("Save"); ?></button>
		<button class="button secondary radius" onclick="window.location.reload();return false;"><?php echo lang('Cancel modifications'); ?></button>
	</div>
</form>
<?php } ?>

<?php include_once(ROOT.'admin/footer.php'); ?>
