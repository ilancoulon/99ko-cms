<?php defined('ROOT') OR exit('No direct script access allowed'); ?>

<?php include_once(THEMES.getCoreConf('theme').'/header.php') ?>
<?php
if($pageItem->getFile()) include_once(THEMES.getCoreConf('theme').'/'.$pageItem->getFile());
else echo $pageItem->getContent();
?>
<?php include_once(THEMES.getCoreConf('theme').'/footer.php') ?>