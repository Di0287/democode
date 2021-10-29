<?
header('content-type: text/html; charset=UTF-8;');
require_once 'ami_env.php';

$oSession = AMI::getSingleton('env/session');
$oUser = $oSession->getUserData();
$IdUser = is_object($oUser) ? $oUser->getId() : 0;

$aItemData = AMI::getResourceModel('members/table', array(array('extModeOnConstruct' => 'common')))->find($IdUser)->getData();
$cf_dealer = $aItemData['cf_dealer'];
if($cf_dealer == ""){$cf_dealer = 0;};
$shopping_cart = unserialize($aItemData['shopping_cart']);

$tax = 0;
$cost = 0;
foreach ($shopping_cart as $key => $value) {
	$aItemPrice = AMI::getResourceModel('eshop_item/table', array(array('extModeOnConstruct' => 'common')))->find($key)->getData();
	$tax += $value * $aItemPrice['price'. $cf_dealer];
	$cost += $value;
};

echo "<span>&nbsp;x&nbsp;</span> <span id='eshop_cart_count' class='eshop_cart_count'>". $cost ."</span> <span>&nbsp;=&nbsp;</span> <span id='eshop_cart_total' class='eshop_cart_total'>". $tax ."&nbsp;₽</span>";

