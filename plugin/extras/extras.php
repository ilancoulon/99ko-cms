<?php
defined('ROOT') OR exit('No direct script access allowed');

## Traitements à effecturer lors de l'installation du plugin
function extrasInstall(){
}

## Hook (footer admin)
function extrasEndAdminBody(){
    $data = '<script src="https://cdnjs.cloudflare.com/ajax/libs/foundation/5.5.2/js/foundation.min.js"></script>'."\n";
    $data.= '<script>$(document).foundation();</script>'."\n"; 
    echo $data;
}

## Hook (header admin)
function extrasAdminHead(){
    $data = '<script src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>'."\n";
    $data.= '<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>'."\n";
    $data.= '<link href="https://cdnjs.cloudflare.com/ajax/libs/normalize/3.0.3/normalize.min.css" type="text/css" />'."\n";
    //$data.= '<link href="https://cdnjs.cloudflare.com/ajax/libs/foundation/5.5.2/css/foundation.min.css" type="text/css" />'."\n";
    echo $data;
}

## Hook (header thème)
function extrasFrontHead(){
    $data = '<meta name="generator" content="99ko CMS" />'."\n";
    $data.= '<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>'."\n";
    $data.= '<link href="https://cdnjs.cloudflare.com/ajax/libs/normalize/3.0.3/normalize.min.css" type="text/css" />'."\n";
    echo $data;
}
?>