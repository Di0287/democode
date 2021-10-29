<?
require_once 'ami_env.php';

$oSession = AMI::getSingleton('env/session');
$oUser = $oSession->getUserData();
$IdUser = is_object($oUser) ? $oUser->getId() : 0;

	
$aItemData = AMI::getResourceModel('members/table', array(array('extModeOnConstruct' => 'common')))->find($IdUser)->getData();
$cf_dealer = $aItemData['cf_dealer'];
if($cf_dealer == ""){$cf_dealer = 0;};
$shopping_cart = unserialize($aItemData['shopping_cart']);

if($shopping_cart != "") {

echo "
<div style='text-align: right; height: 30px; margin-right: 50px;'>
	<a style='text-decoration: underline;' onclick='clear_cart(". $IdUser ."); return false;' href='#'>Очистить корзину</a>
</div>";
$Itime = 500;
foreach ($shopping_cart as $key => $value) {
		
	$oTable = AMI::getResourceModel('eshop_item/table',	array(array('extModeOnConstruct' => 'common')));
	$aItemPrice = $oTable->find($key)->getData();
	$oItem = $oTable->find($key);
	$tax += $value * $aItemPrice['price'. $cf_dealer];
	$cost += $value;
	$js_add .= "setTimeout(function() {
		//$('#cartPopupWindow_layer').remove();
		//$('#cartPopupWindow').remove();
		amiCart.add('". $oItem->getFullURL() ."?itemId=". $key ."&num=1&offset=0&catoffset=0&action=add', ". $key .", ". $cf_dealer .");
		$('#cartPopupWindow').html(`<div id='pop_up_load' wfd-invisible='true'> <img src='../_mod_files/ce_images/loading_.gif' id='pop_up_load_result_'> </div>`);
		}, ". $Itime ."); ";
	
	$js_input .= "<form name='qty_". $key ."_1' onsubmit='return false;' class='eshop-item-small__cart-form'>
	<input class='txt cnt_qty eshop-item-small__quantity' type='text' name='qty' value='". $value ."' qty_index='0'>
</form>";
	
	$mess .= "<div class='cart_item_row' id='cart_item_row_eshop_69580_0'>
    <div class='cart_item_row__left'>
        <div style='display: table;'>
            <div style='display: table-row;'>
                <div class='cart_item_row_picture' style='display:table-cell; vertical-align: middle; text-align: center;'>
                    <img class='item_small_picture' src='". $aItemPrice['ext_img_popup'] ."' title='' alt='' width='160' height='114' border='0'>
                </div>
                <div class='cart_item_row_name' style='display:table-cell; vertical-align: middle;'>
                    <a class='cart_item_row_name__title' href='". $oItem->getFullURL() ."'>
						". $aItemPrice['header'] ."
					</a>
                    <br><br>". $aItemPrice['custom_field_67'] ."
                </div>
    		</div>
    	</div>
    </div>
	<div class='cart_item_row__right_clear' style='clear: both; display: none;'></div>   
    <div class='cart_item_row__right'>
        <div class='cart_item_row__right_tr' style='display: table;'>
            <div style='display: table-row;'>
                <div class='cart_item_row_price' style='display:table-cell; vertical-align: middle; '>
                    <span style='font-size: 16px;'>
                        ". $aItemPrice['price'. $cf_dealer] ."&nbsp;₽
                    </span>
                </div>
				<div class='cart_item_row_rest' style='display:table-cell; vertical-align: middle; font-size: 16px;' align='center'>
                    <span>x</span>
                    <input type='text' class='txt' size='7' name='qty_". $key ."' value='". $value ."' style='width: 50px;text-align: center;height: 30px;margin:5px;border-radius: 10px;' onblur='txx_update(". $key .", `cost`)' onkeydown='if(event.keyCode === 13){txx_update(". $key .", `cost`);};' onclick='this.select();AMI.Browser.Event.stopProcessing(event);'>
                </div>
                <div class='cart_item_row_total' style='display:table-cell; vertical-align: middle;  ' align='left'>
                    <span style='font-size: 18px;'>= ". $value * $aItemPrice['price'. $cf_dealer] ."&nbsp;₽</span>
                </div>
				<div style='display:table-cell; vertical-align: middle;text-align: center;'>
                    <div onclick='txx_update(". $key .", `del`);return false;' style='font-family: verdana; font-weight: 600; color: red;  text-decoration: none; display: inline-block; cursor: pointer'>
						<font style='font-size: 30px; padding: 10px;'>X</font>
					</div>
                </div>
    		</div>
    	</div>
	</div>
<div style='clear: both;'></div>
<hr style='margin: 10px 0;'>
</div>";
$Itime += 1200;
};

//echo $js_add;
echo "<div style='display: none'>". $js_input ."</div>
<script type='text/javascript'>
    function tovar() {
        $('#result_cart').css('display', 'none');
        $('#eshop-ordering__redirect-info').css('display', 'block');
        $.ajax({
            url: 'pages.php',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}, type: 'POST', dataType: 'text', data: { modlink: 'members/cart', action: 'empty' },
            success: function (result) {
               // console.log(result);
               
                ". $js_add ."
        
                setTimeout(function() {
                    //clear_cart(". $IdUser .");
                    $('#cartPopupWindow_layer').remove();
                    $('#cartPopupWindow').remove();
                    var url = './members/order';
                    $(location).attr('href',url);
                }, ". $Itime .");
            }, error: function () {console.log('error');}
        }); 
    };
</script>

";

echo $mess;

echo "<div id='cart_items' style='text-align: right;'>
    <div style='margin: 10px 50px; float: right;  '>
        <div style='padding-left: 30px; margin: 20px 0; font-size: 24px;'>Всего: <span class='discount_small'>". $tax ."&nbsp;₽</span></div>
    </div>
</div>		
<div style='clear: both; text-align: right; margin: 0 50px;'>
	<div style='display: inline-block;'>
		<br>
		<button id='cart-detailed__make-order-btn' type='button' class='cart-small__order-btn' style='display: inline-block; font-size: 18px; padding: 10px 24px;' onclick='tovar();return false;'>Оформить заказ</button>
	</div>
</div>";
} else {echo "Ваша корзина пуста";};