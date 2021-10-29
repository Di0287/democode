<?
include ("_local/_php/db.php");

require_once 'ami_env.php';

$oSession = AMI::getSingleton('env/session');
$oUser = $oSession->getUserData();
$IdUser = is_object($oUser) ? $oUser->getId() : 0;


$sql = "UPDATE `cms_members` SET `shopping_cart` = '' WHERE `cms_members`.`id` =". $IdUser;

if(!$mysqli->real_query($sql)){$text = "Ошибка добавление товара";}else{$text = "gotovo";};