<form method="post" action="index.php?p=page&action=saveconfig">
	<?php showAdminTokenField(); ?>
  <div class="row">
    <div class="large-12 columns">
      <label>Titres</label>
      <input <?php if($hideTitles){ ?>checked<?php } ?> type="checkbox" name="hideTitles" /> <label for="hideTitles"><?php echo lang("Hide pages titles"); ?></label>
  </div>
  <p><button type="submit" class="button success radius"><?php echo lang("Save"); ?></button></p>

</form>