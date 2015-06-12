<?php include_once(ROOT.'admin/header.php'); ?>

<?php if ($data['menuMode'] == 'list') { ?>
<a class="button round medium" id="addLink" onclick="addLink()"><?php echo $core->lang('New link'); ?></a>
<form method="post" action="index.php?p=menu&action=save" id="formUpdate">
	<?php show::adminTokenField(); ?>
	<table id="linksList" style="width:100%">
		<thead>
			<tr>
				<th><?php echo $core->lang('Label'); ?></th>
				<th><?php echo $core->lang('Url'); ?></th>
				<th><?php echo $core->lang('Target'); ?></th>
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
							<option value="_self" <?php echo ($link->getTarget() == '_self' ? 'selected' : ''); ?>><?php echo $core->lang('Current page'); ?></option>
							<option value="_blank" <?php echo ($link->getTarget() == '_blank' ? 'selected' : ''); ?>><?php echo $core->lang('New page'); ?></option>
						</select>
					<?php } else { ?>
						<input type="hidden" name="target<?php echo $position; ?>" value="<?php echo $link->getTarget(); ?>" />
						<?php echo ($link->getTarget() == '_self' ? $core->lang('Current page') : $core->lang('New page')); ?>
					<?php } ?>
				</td>
				<td class="up">
					<?php if ($position > 0) {?>
						<a onclick="upLink(<?php echo $position; ?>)"><span data-tooltip class="has-tip tip-top" title="<?php echo $core->lang('Up'); ?>"><img src="<?php echo MENU_PLUGINPATH; ?>img/up.png" alt="<?php echo $core->lang('Up'); ?>" /></span></a>
					<?php } ?>
				</td>
				<td class="down">
					<?php if ($position < count($data['menuLinks']) - 1) {?>
						<a onclick="downLink(<?php echo $position; ?>)"><span data-tooltip class="has-tip tip-top" title="<?php echo $core->lang('Down'); ?>"><img src="<?php echo MENU_PLUGINPATH; ?>img/down.png" alt="<?php echo $core->lang('Down'); ?>" /></span></a>
					<?php } ?>
				</td>
				<td class="delete">
					<?php if ($link->getPlugin() == 'menu') {?>
						<a onclick="deleteLink(<?php echo $position; ?>)"><span data-tooltip class="has-tip tip-top" title="<?php echo $core->lang('Delete'); ?>"><img src="<?php echo MENU_PLUGINPATH; ?>img/delete.png" alt="<?php echo $core->lang('Delete'); ?>" /></span></a>
					<?php } ?>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<input type="hidden" name="number" value="<?php echo count($data['menuLinks']); ?>" />
	<div class="buttons">
		<button type="submit" class="button success radius"><?php echo $core->lang("Save"); ?></button>
		<button class="button secondary radius" onclick="window.location.reload();return false;"><?php echo $core->lang('Cancel modifications'); ?></button>
	</div>
</form>
<a class="button round medium" id="addLink" onclick="addLink()"><?php echo $core->lang('New link'); ?></a>
<?php } ?>
<script>
function addLink() {
	var position = parseInt($('#linksList tr:last').attr('id'));
	
	$('#linksList tr:last .down').html('<a onclick="downLink(' + position + ')"><span data-tooltip class="has-tip tip-top" title="<?php echo $core->lang('Down'); ?>"><img src="<?php echo MENU_PLUGINPATH; ?>img/down.png" alt="<?php echo $core->lang('Down'); ?>" /></span></a>')
	
	position += 1;
	
	$('#linksList').append(
		'<tr id="' + position + '" class="added">'+
			'<input type="hidden" name="id' + position + '" value="-1" />'+
			'<input type="hidden" name="plugin' + position + '" value="menu" />'+
			'<td class="lab">'+
				'<input type="text" name="label' + position + '" />'+
			'</td>'+
			'<td class="url">'+
				'<input type="text" name="url' + position + '" />'+
			'</td>'+
			'<td class="target">'+
				'<select name="target' + position + '">'+
					'<option value="_self"><?php echo $core->lang('Current page'); ?></option>' +
					'<option value="_blank"><?php echo $core->lang('New page'); ?></option>' +
				'</select>' +
			'</td>'+
			'<td class="up">'+
				'<a onclick="upLink(' + position + ')"><span data-tooltip class="has-tip tip-top" title="<?php echo $core->lang('Up'); ?>"><img src="<?php echo MENU_PLUGINPATH; ?>img/up.png" alt="<?php echo $core->lang('Up'); ?>" /></span></a>'+
			'</td>'+
			'<td class="down"></td>'+
			'<td class="delete">'+
				'<a onclick="deleteLink(' + position + ')"><span data-tooltip class="has-tip tip-top" title="<?php echo $core->lang('Delete'); ?>"><img src="<?php echo MENU_PLUGINPATH; ?>img/delete.png" alt="<?php echo $core->lang('Delete'); ?>" /></span></a>'+
			'</td>'+
		'</tr>'
	);
	
	$('input[name=number]').attr('value', position + 1);
}	
</script>
<?php include_once(ROOT.'admin/footer.php'); ?>
