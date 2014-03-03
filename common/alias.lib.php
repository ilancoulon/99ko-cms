<?php

/**
 * 99ko cms
 *
 * This source file is part of the 99ko cms. More information,
 * documentation and support can be found at http://99ko.hellojo.fr
 *
 * @package     99ko
 *
 * @author      Jonathan Coulet (j.coulet@gmail.com)
 * @copyright   2013-2014 Florent Fortat (florent.fortat@maxgun.fr) / Jonathan Coulet (j.coulet@gmail.com) / Frédéric Kaplon (frederic.kaplon@me.com)
 * @copyright   2010-2012 Florent Fortat (florent.fortat@maxgun.fr) / Jonathan Coulet (j.coulet@gmail.com)
 * @copyright   2010 Jonathan Coulet (j.coulet@gmail.com)  
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

defined('ROOT') OR exit('No direct script access allowed');

/*
 * alias (fonctions depreciees)
 *
 */

function utilSetMagicQuotesOff(){
    return util::setMagicQuotesOff();
}

function utilSort2DimArray($data, $key, $mode){
    return util::sort2DimArray($data, $key, $mode);
}

function utilStrToUrl($str){
    return util::strToUrl($str);
}

function utilIsEmail($email){
    return util::isEmail($email);
}

function is_valid_email($email) {
    return util::isValidEmail($email);
}

function utilSendEmail($from, $reply, $to, $subject, $msg){
    return util::sendEmail($from, $reply, $to, $subject, $msg);
}

function utilHideEmail($email){               
    return util::hideEmail($email);
}    

function utilGetFileExtension($file){
    return util::getFileExtension($file);
}

function utilScanDir($folder, $not = array()){
    return util::scanDir($folder, $not);
}

function utilPhpVersion(){
    return util::phpVersion();
}

function utilWriteJsonFile($file, $data){
    return util::writeJsonFile($file, $data);
}

function utilReadJsonFile($file, $assoc = true){
    return util::readJsonFile($file, $assoc);
}

function utilUploadFile($k, $dir, $name, $validations = array()){
    return util::uploadFile($k, $dir, $name, $validations);
}

function utilHtmlTable($cols, $vals, $params = ''){
    return util::htmltable($cols, $vals, $params);
}

function utilHtmlSelect($options, $selected = '', $params = ''){
    return util::htmlSelect($options, $selected, $params);
}

function utilFormatDate($date, $langFrom = 'en', $langTo = 'en'){
    return util::formateDate($date, $langFrom, $langTo);
}

function showMsg($msg, $type) {
   return show::showMsg($msg, $type);
}

function showLinkTags($format = '<link href="[file]" rel="stylesheet" type="text/css" />'){
   return show::showLinkTags($format);
}

function showScriptTags($format = '<script type="text/javascript" src="[file]"></script>'){
   return show::showScriptTags($format);
}

function showAdminEditor($name, $content, $id='editor', $class='editor') {
   return show::showAdminEditor($name, $content, $id, $class);
}

function showAdminTokenField() {
   return show::showAdminTokenField();
}

function showTitleTag() {
   return show::showTitleTag();
}

function showMetaDescriptionTag() {
   return show::showMetaDescriptionTag();
}

function showMainTitle($format = '<h1>[mainTitle]</h1>') {
   return show::showMainTitle($format);
}

function showSiteName() {
   return show::showSiteName();
}

function showSiteDescription() {
   return show::showSiteDescription();
}

function showSiteUrl() {
   return show::showSiteUrl();
}

function showSiteLang() {
   return show::showSiteLang();
}

function showExecTime() {
   return show::showExecTime();
}

function showMainNavigation($format = '<li><a href="[target]">[label]</a></li><li class="divider"></li>') {
   return show::showMainNavigation($format);
}

function showTheme($format = '<a target="_blank" href="[authorWebsite]">[name]</a>') {
   return show::showTheme($format);
}

function showSidebarItems($format = '<div class="panel" id="[id]"><h2>[title]</h2>[content]</div>') {
   return show::showSidebarItems($format);
}

function showPluginId(){
   return show::showPluginId();
}

?>