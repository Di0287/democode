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

$shopping_cart[$_POST['ItemId']] += $_POST['Cost'];
$shopping_cart = serialize($shopping_cart);

include ("_local/_php/db.php");

$sql = "UPDATE `cms_members` SET `shopping_cart` = '". $shopping_cart ."' WHERE `cms_members`.`id` =". $IdUser;

if($mysqli->real_query($sql)){

echo "<div class='popupWindowShadow' id='cartPopupWindow_layer' style='z-index: 100000; display: block;'></div>

<div id='cartPopupWindow' style='width: 350px; height: 300px; display: block; z-index: 100001; top: 104px; left: 617px; box-sizing: content-box; position: fixed; visibility: visible; opacity: 1;' class='amiPopup'>
	<div id='cartPopupWindow_header' class='popupHeader' style='box-sizing: border-box;'><div class='popupHeaderText'></div><div class='popupClose'></div></div>
	<div class='popupContent'>
		<div style='box-sizing: border-box; display: block;'>
			<div class='cart-small cart-small_type_success cart-small_not_empty'>
				<a href='members/cart' class='cart-small__title' style='text-decoration: underline;'>Моя корзина</a>
				<div id='cart-small__info_is_empty' class='cart-small__info cart-small__info_is_empty' style='display: none;'>Корзина пока пуста</div>
				<br>
				<div id='cart-small__success-message' class='cart-small__success-message'>
					Товар ' ". $_POST['Name'] ." ' добавлен в корзину.
				</div>
				<br>
				<div>
					<!--<a class='cart-small__order-btn' href='members/order'>Оформить заказ</a>-->
					<a class='cart-small__cont-btn popupWindowShadow' href='#' onclick='cartPopupCose(); return false;'>Продолжить покупки</a>
				</div>
			</div>
		</div>
	</div>
</div>";
}else{echo "Ошибка добавления";};