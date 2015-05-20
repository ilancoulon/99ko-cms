<?php defined('ROOT') OR exit('No direct script access allowed'); ?>
<?php include_once(ROOT.'admin/header.php') ?>

<br />
<div class="row">
    <div class="large-12 columns">
<p>
    <a class="button" href="index.php?p=pluginsmanager&action=cache&token=<?php echo $administrator->getToken(); ?>"><?php echo $core->lang("Clear plugins cache"); ?></a>
</p>
</div>
  </div> 

<?php include_once(ROOT.'admin/footer.php') ?>