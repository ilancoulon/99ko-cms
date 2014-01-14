<?php if($data['pageMode'] == 'list'){ ?>
<?php showMsg($data['pageMsg'], $data['pageMsgType']); ?>
<p><a class="button round small" href="index.php?p=page&action=edit"><?php echo lang("Add"); ?></a></p>
<table style="width:100%">
  <thead>
	<tr>
		<th style="width:5%"></th>
		<th style="width:10%"><?php echo lang("Name"); ?></th>
		<th style="width:55%">URL</th>
		<th style="width:30%"><?php echo lang("Actions"); ?></th>
	</tr>
  </thead>
  <tbody>
	<?php foreach($data['pageList'] as $pageItem){ ?>
	<tr>
		<td><?php if($pageItem['isHomepage']){ ?>&nbsp;<img data-tooltip class="has-tip tip-right" src="../plugin/page/other/house.png" alt="icon" title="<?php echo lang("Homepage"); ?>" /><?php } ?> <?php if($pageItem['isHidden']){ ?>&nbsp;<img data-tooltip class="has-tip tip-right" src="../plugin/page/other/ghost.png" alt="icon" title="Cette page n'apparait pas dans le menu" /> <?php } ?></td>
		<td><?php echo $pageItem['name']; ?></td>
		<td><input type="text" value="<?php echo $coreConf['siteUrl']; ?>/<?php echo rewriteUrl('page', array('name' => $pageItem['name'], 'id' => $pageItem['id'])); ?>" /></td>
		<td class="button-bar">

         <ul class="button-group radius">
             <li><button class="tiny button secondary" data-reveal-id="<?php echo utilStrToUrl($pageItem['name']); ?>"><?php echo lang("Preview"); ?></button></li>
             <li><a class="tiny button success" href="index.php?p=page&action=edit&id=<?php echo $pageItem['id']; ?>"><?php echo lang("Edit"); ?></a></li>
             <?php if(!$pageItem['isHomepage']){ ?><li><a class="tiny button alert" href="index.php?p=page&action=del&id=<?php echo $pageItem['id']; ?>&token=<?php echo $data['token']; ?>" onclick = "if(!confirm('<?php echo lang("Delete this page ?"); ?>')) return false;"><?php echo lang("Delete"); ?></a></li><?php } ?>
         </ul>		
		</td>
	</tr>
<!-- Reveal Modals -->
<div id="<?php echo utilStrToUrl($pageItem['name']); ?>" class="reveal-modal large" data-reveal>
  <h2><?php echo lang("Preview"); ?></h2>
  <div class="flex-video">
          <iframe width="990" height="450" src="<?php echo $coreConf['siteUrl']; ?>/<?php echo rewriteUrl('page', array('name' => $pageItem['name'], 'id' => $pageItem['id'])); ?>" frameborder="0" allowfullscreen></iframe>
  </div>
  <a class="close-reveal-modal">&#215;</a>
</div>
<!-- Reveal Modals end -->		
	<?php } ?>
  </tbody>
</table>
<?php } elseif($data['pageMode'] == 'edit'){ ?>
<form method="post" action="index.php?p=page&action=save">
  <?php showAdminTokenField(); ?>
  <input type="hidden" name="id" value="<?php echo $data['pageId']; ?>" />
  
  <div class="row">
    <div class="large-6 columns">
      <label><?php echo lang("Name"); ?></label>
      <input type="text" name="name" value="<?php echo $data['pageName']; ?>" />
    </div>
  </div>	
  
  <div class="row">
    <div class="large-6 columns">
      <label><?php echo lang("Page title (optional)"); ?></label>
      <input type="text" name="mainTitle" value="<?php echo $data['pageMainTitle']; ?>" />
    </div>
  </div>
  
  <div class="row">
    <div class="large-6 columns">
      <label><?php echo lang("Meta description tag (optional)"); ?></label>
      <input type="text" name="metaDescriptionTag" value="<?php echo $data['pageMetaDescriptionTag']; ?>" />
    </div>
  </div>
    	
	<?php if($data['pageChangeOrder']){ ?>
  <div class="row">
    <div class="large-6 columns">
      <label><?php echo lang("link position on the menu"); ?></label>
      <input type="text" name="position" value="<?php echo $data['pagePosition']; ?>" />
    </div>
  </div>
	<?php } ?>

  <div class="row">
    <div class="large-6 columns">
      <input <?php echo $data['pageIsHomepageChecked']; ?> type="checkbox" name="isHomepage" /> <label for="isHomepage"><?php echo lang("use as homepage"); ?></label> 
    </div>       
  </div>
  
  <div class="row">
    <div class="large-6 columns">
      <input <?php if($data['pageIsHidden']){ ?>checked<?php } ?> type="checkbox" name="isHidden" /> <label for="isHidden"><?php echo lang("Don't display in the menu"); ?></label>
    </div>       
  </div>

  <div class="row">
    <div class="large-12 columns">
      <label><?php echo lang("Content"); ?></label>
      <?php showAdminEditor('content', $data['pageContent'], '600', '400'); ?>
    </div>
  </div>
  	
  <div class="row">
    <div class="large-4 columns">
      <label><?php echo lang('Include a file instead of content (must be present in %s theme\'s folder)', 'page', $data['pageTheme']); ?></label>
		<select name="file">
			<option value="">--</option>
			<?php foreach($data['pageFiles'] as $file){ ?>
			<option <?php if($file == $data['pageFile']){ ?>selected<?php } ?> value="<?php echo $file; ?>"><?php echo $file; ?></option>
			<?php } ?>
		</select>
    </div>
  </div> 

	
	<button type="submit" class="button success radius"><?php echo lang("Save"); ?></button>
</form>
<?php } ?>