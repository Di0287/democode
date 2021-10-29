<?
header('content-type: text/html; charset=UTF-8;');
require_once 'ami_env.php';

$oSession = AMI::getSingleton('env/session');
$oUser = $oSession->getUserData();
$IdUser = is_object($oUser) ? $oUser->getId() : 0;

$aItemData = AMI::getResourceModel('members/table', array(array('extModeOnConstruct' => 'common')))->find($IdUser)->getData();
//$shopping_cart = unserialize($aItemData['shopping_cart']);
//echo $aItemData['shopping_cart'];
//echo $shopping_cart;
echo json_encode( unserialize($aItemData['shopping_cart']));