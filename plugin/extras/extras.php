<?php
defined('ROOT') OR exit('No direct script access allowed');

## Traitements à effecturer lors de l'installation du plugin
function extrasInstall(){
}

## Hook (footer admin)
function extrasEndAdminBody(){
    $data = '<script src="'.PLUGINS.'extras/other/foundation.min.js?v=5.5.2"></script>'."\n";
    $data.= '<script>$(document).foundation();</script>'."\n"; 
    echo $data;
}

## Hook (header admin)
function extrasAdminHead(){
    $data = '<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>'."\n";
    $data.= '<link href="https://cdnjs.cloudflare.com/ajax/libs/normalize/3.0.3/normalize.min.css" type="text/css" />'."\n";
    echo $data;
}

## Hook (header thème)
function extrasFrontHead(){
    $data = '<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>'."\n";
    $data.= '<link href="https://cdnjs.cloudflare.com/ajax/libs/normalize/3.0.3/normalize.min.css" type="text/css" />'."\n";
    echo $data;
}
?>