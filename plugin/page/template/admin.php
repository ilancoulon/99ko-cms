<?php include_once(ROOT.'admin/header.php'); ?>

<?php if($mode == 'list'){ ?>
<p><a class="button round medium" href="index.php?p=page&amp;action=edit"><?php echo lang("Add"); ?></a></p>
<table style="width:100%">
  <thead>
	<tr>
		<th style="width:5%"></th>
		<th style="width:15%"><?php echo lang("Name"); ?></th>
		<th style="width:50%"><?php echo lang('Url'); ?></th>
		<th style="width:30%"><?php echo lang("Actions"); ?></th>
	</tr>
  </thead>
  <tbody>
	<?php foreach($page->getItems() as $pageItem){ ?>
	<tr>
		<td style="vertical-align: middle;"><?php if($pageItem->getIsHomepage()){ ?>&nbsp;<span data-tooltip class="has-tip tip-right" title="<?php echo lang("Homepage"); ?>"><img src="<?php echo PLUGINS; ?>page/other/house.png" alt="icon" /></span><?php } ?> 
		    <?php if($pageItem->getIsHidden()){ ?>&nbsp;<span data-tooltip class="has-tip tip-right" title="<?php echo lang("This page does not appear in the menu"); ?>"><img src="<?php echo PLUGINS; ?>/page/other/ghost.png" alt="icon" style="margin-bottom: 20px;" /></span> 
		    <?php } ?>
		</td>
		<td><?php echo $pageItem->getName(); ?></td>
		<td><input type="text" value="<?php echo getCoreConf('siteUrl'). '/' .rewriteUrl('page', array('name' => $pageItem->getName(), 'id' => $pageItem->getId())); ?>" /></td>
		<td>
		 <!-- Boutons d'actions -->
         <ul class="button-group radius">
             <li><a class="tiny button success" href="index.php?p=page&amp;action=edit&amp;id=<?php echo $pageItem->getId(); ?>"><?php echo lang("Edit"); ?></a></li>
             <?php if(!$pageItem->getIsHomepage()){ ?><li><a class="tiny button alert" href="index.php?p=page&amp;action=del&amp;id=<?php echo $pageItem->getId(). '&amp;token=' .$token; ?>" onclick = "if(!confirm('<?php echo lang("Delete this page ?"); ?>')) return false;"><?php echo lang("Delete"); ?></a></li><?php } ?>
         </ul>	
		</td>
	</tr>
<!-- Reveal Modals -->
<div id="<?php echo utilStrToUrl($pageItem->getName()); ?>" class="reveal-modal large" data-reveal>
  <h2><?php echo lang("Preview"); ?></h2>
  <div class="flex-video">
          <iframe width="990" height="450" src="<?php echo getCoreConf('siteUrl'); ?>/<?php echo rewriteUrl('page', array('name' => $pageItem->getName(), 'id' => $pageItem->getId())); ?>" frameborder="0" allowfullscreen></iframe>
  </div>
  <a class="close-reveal-modal">&#215;</a>
</div>
<!-- Reveal Modals end -->		
	<?php } ?>
  </tbody>
</table>
<p><a class="button round medium" href="index.php?p=page&amp;action=edit"><?php echo lang("Add"); ?></a></p>
<?php } elseif($mode == 'edit'){ ?>
<form method="post" action="index.php?p=page&amp;action=save">
  <?php showAdminTokenField(); ?>
  <input type="hidden" name="id" value="<?php echo $pageItem->getId(); ?>" />
  
  <div class="row">
    <div class="large-6 columns">
      <label><?php echo lang("Name"); ?></label>
      <input type="text" name="name" value="<?php echo $pageItem->getName(); ?>" />
    </div>
  </div>	
  
  <div class="row">
    <div class="large-6 columns">
      <label><?php echo lang("Page title (optional)"); ?></label>
      <input type="text" name="mainTitle" value="<?php echo $pageItem->getMainTitle(); ?>" />
    </div>
  </div>
  
  <div class="row">
    <div class="large-6 columns">
      <label><?php echo lang("Meta title tag (optional)"); ?></label>
      <input type="text" name="metaTitleTag" value="<?php echo $pageItem->getMetaTitleTag(); ?>" />
    </div>
  </div>
  
  <div class="row">
    <div class="large-6 columns">
      <label><?php echo lang("Meta description tag (optional)"); ?></label>
      <input type="text" name="metaDescriptionTag" value="<?php echo $pageItem->getMetaDescriptionTag(); ?>" />
    </div>
  </div>
    	
	<?php if($changeOrder){ ?>
  <div class="row">
    <div class="large-6 columns">
      <label><?php echo lang("link position on the menu"); ?></label>
      <input type="text" name="position" value="<?php echo $pageItem->getPosition(); ?>" />
    </div>
  </div>
	<?php } ?>

  <div class="row">
    <div class="large-6 columns">
      <input <?php if($pageItem->getIsHomepage()){ ?>checked<?php } ?> type="checkbox" name="isHomepage" /> <label for="isHomepage"><?php echo lang("Use as homepage"); ?></label> 
    </div>       
  </div>
  
  <div class="row">
    <div class="large-6 columns">
      <input <?php if($pageItem->getIsHidden()){ ?>checked<?php } ?> type="checkbox" name="isHidden" /> <label for="isHidden"><?php echo lang("Don't display in the menu"); ?></label>
    </div>       
  </div>

  <div class="row">
    <div class="large-12 columns">
      <label><?php echo lang("Content"); ?></label>
      <?php showAdminEditor('content', $pageItem->getContent()); ?>
    </div>
  </div>
  <br /> 	
  <div class="row">
    <div class="large-12 columns">
      <label><?php echo lang('Include a file instead of content (must be present in your theme folder)'); ?></label>
		<select name="file" class="large-3 columns">
			<option value="">--</option>
			<?php foreach($page->listFiles() as $file){ ?>
			<option <?php if($file == $pageItem->getFile()){ ?>selected<?php } ?> value="<?php echo $file; ?>"><?php echo $file; ?></option>
			<?php } ?>
		</select>
    </div>
  </div> 

	
	<button type="submit" class="button success radius"><?php echo lang("Save"); ?></button>
</form>
<?php } ?>

<?php include_once(ROOT.'admin/footer.php'); ?>