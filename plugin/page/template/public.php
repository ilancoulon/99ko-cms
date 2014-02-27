<?php defined('ROOT') OR exit('No direct script access allowed'); ?>
<?php include_once(THEMES .$coreConf['theme'].'/header.php') ?>
<?php
if($data['pageFile']) include_once($data['pageFile']);
else echo $data['pageContent'];
?>
<?php if(isset($hideTitles) && $hideTitles){ ?>
<script type="text/javascript">
    $(".page h1").hide();
</script>
<?php } ?>
<?php include_once(THEMES .$coreConf['theme'].'/footer.php') ?>