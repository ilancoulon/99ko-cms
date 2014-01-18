<?php
##########################################################################################################
# 99ko http://99ko.hellojo.fr/
#
# Copyright (c) 2013-2014 Florent Fortat (florent.fortat@maxgun.fr) / Jonathan Coulet (j.coulet@gmail.com) / Frédéric Kaplon (frederic.kaplon@me.com)
# Copyright (c) 2010-2012 Florent Fortat (florent.fortat@maxgun.fr) / Jonathan Coulet (j.coulet@gmail.com)
# Copyright (c) 2010 Jonathan Coulet (j.coulet@gmail.com)
##########################################################################################################

$time = microtime(true);
define('ROOT', './');
include_once(ROOT.'common/common.php');
// hook
eval(callHook('startFrontIncludePluginFile'));
// includes plugin courant
if($runPlugin->getPublicFile()){
	include($runPlugin->getPublicFile());
	include($runPlugin->getPublicTemplate());
}
// hook
eval(callHook('endFrontIncludePluginFile'));
?>