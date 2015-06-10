<?php defined('ROOT') OR exit('No direct script access allowed'); ?>

<br />
<div class="row">
    <div class="large-12 columns">
<p>
    <?php echo $core->lang("Clear Cache plugin can solve a bug in your site."); ?></p>
    <p><a class="button" href="index.php?p=pluginsmanager&action=cache&token=<?php echo $administrator->getToken(); ?>"><?php echo $core->lang("Clear plugins cache"); ?></a>
</p>
</div>
  </div>

</form>