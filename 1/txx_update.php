<?
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

header('content-type: text/html; charset=UTF-8;');
require_once 'ami_env.php';

$oSession = AMI::getSingleton('env/session');
$oUser = $oSession->getUserData();
$IdUser = is_object($oUser) ? $oUser->getId() : 0;

$aItemData = AMI::getResourceModel('members/table', array(array('extModeOnConstruct' => 'common')))->find($IdUser)->getData();
$shopping_cart = unserialize($aItemData['shopping_cart']);

if($_POST['type'] == "cost"){
	$shopping_cart[$_POST['ItemId']] = $_POST['Cost'];
	$shopping_cart = serialize($shopping_cart);

	include ("_local/_php/db.php");

	$sql = "UPDATE `cms_members` SET `shopping_cart` = '". $shopping_cart ."' WHERE `cms_members`.`id` =". $IdUser;

	if($mysqli->real_query($sql)){echo "Товар обновлен";}else{echo "Ошибка";};
};

if($_POST['type'] == "del"){
	unset($shopping_cart[$_POST['ItemId']]);
	$shopping_cart = serialize($shopping_cart);

	include ("_local/_php/db.php");

	$sql = "UPDATE `cms_members` SET `shopping_cart` = '". $shopping_cart ."' WHERE `cms_members`.`id` =". $IdUser;

	if($mysqli->real_query($sql)){echo "Товар удален";}else{echo "Ошибка";};
};