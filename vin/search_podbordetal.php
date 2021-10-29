<?php
//echo "re rer";
//print_r($_POST);
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once 'ami_env.php';

//header('Content-Type: text/html; charset=utf-8');

//defined('_JEXEC') or die('Restricted access');

$domain           = "http://www.part-kom.ru";
$login                = ''; //Ваш логин для входа на сайт http://www.part-kom.ru;
$password             = ''; //Ваш пароль для входа на сайт http://www.part-kom.ru;
$searchPartUrl        = '/engine/api/v3/search/parts'; //url скрипта поиска детали
$brandsByNumberUrl    = '/engine/api/v3/search/brands';

$partNumber       = "". strtoupper($_POST['name']) .""; //артикул детали
//echo $partNumber;

if($_POST["search"] == 'PodborDetal'){
	PodborDetal($domain, $brandsByNumberUrl, $searchPartUrl, $partNumber, $login, $password);
}

if($_POST["search"] == 'PodborDetalU'){
	$makerName        = "". $_POST["IdPr"] .""; //название производителя.
	PodborDetalU($partNumber, $makerName, $domain, $searchPartUrl, $login, $password);
}
//Получаем всех возможных производителей для артикула $partNumber
function PodborDetal($domain, $brandsByNumberUrl, $searchPartUrl, $partNumber, $login, $password){
	//echo "НАХОДИМ нОМЕР";
	$ch = curl_init("{$domain}{$searchPartUrl}?number={$partNumber}&find_substitutes=0&store=0");
	
	curl_setopt($ch, CURLOPT_USERPWD, $login.':'.$password);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 200);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Accept: application/json',
		'Content-type: application/json'
	));
	
	$data = curl_exec($ch);
	curl_close($ch);
	$parts = json_decode($data);
// echo '<pre>';
// @print_r($parts);
// echo '</pre>';
//-------
	
	$ch = curl_init("{$domain}{$brandsByNumberUrl}?number={$partNumber}");

	curl_setopt($ch, CURLOPT_USERPWD, $login.':'.$password);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 200);
	curl_setopt($ch, CURLINFO_HEADER_OUT, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Accept: application/json',
		'Content-type: application/json'
	));

	$data = curl_exec($ch);
	curl_close($ch);
	$makers = json_decode($data);
	//print_r($makers);
	if(count($makers)>1){
		$description="";
		echo "<BR><BR>";
		echo "<table><tr class='vin_pr_vibor_zag'><td>Фирма</td><td>Описание</td></tr>";
		foreach ($makers as $maker) {
			foreach ($parts as $part) {
				if (strtoupper($part->makerId) == $maker->id) {
					if ($part->description != "") {
						$description = $part->description;
						break;
					}
				}
			};
			if ($description != "") {
				echo "<tr class='vin_pr_vibor' onclick='javascript:PodborDetalU(`".$partNumber."`, ".$maker->id.");'>";
					echo "<td><B>".$maker->name."</B></td><td> - ".$description."</td>";
				echo "</tr>";
			}
			$description = "";
		}
		echo "</table>";
	}elseif(count($makers)==1){
		PodborDetalU($partNumber, $makers[0]->id, $domain, $searchPartUrl, $login, $password);
		//echo "111111111111";
	}elseif(count($makers)==0){
		include ("_local/_php/db.php");
	           
		$sql = "SELECT id, name, price1, price2, custom_field_66, ext_popup_picture, custom_field_67  FROM `cms_es_items` WHERE `public` = 1 AND `id_category` != '20393' AND `custom_field_67` = '". $partNumber ."'";
		//$mysqli->real_query($sql) or die($mysqli -> error);
		
		if($mysqli->real_query($sql)){
			$res = $mysqli->use_result();
			$AVTOMODA=[];
			$AVTOMODA_ORIG=[];
			$AVTOMODA_ORIG['ext_popup_picture'] = '';
			$AVTOMODA_ORIG['id'] = '';
			$AVTOMODA_ORIG['name'] = '';
			while ($row = $res->fetch_assoc()) {
				$AVTOMODA[] = $row;
				$oTable = AMI::getResourceModel(
						'eshop_item/table',
							array(
								array(
									'extModeOnConstruct' => 'common'
								)
							)
					);
					$oItem = $oTable->find($row['id']);
				if($row['custom_field_67'] == $partNumber){
					$PartId = $row['id'];
					$AVTOMODA_ORIG = $row;
					$AVTOMODA_ORIG['linck'] = $oItem->getFullURL();
				}
			};
			$result = false;
			PodborDetalE($result, '', $AVTOMODA, $AVTOMODA_ORIG); 
		}else{$AVTOMODA=[]; echo "Ничего не удалось найти";};
		//echo "222222222";
	}else{
		echo "Ошибка запроса, обратитесь к менеджеру";
	}

}

//Ищем деталь: $partNumber, id производителя = $makerId
function PodborDetalU($partNumber, $makerId, $domain, $searchPartUrl, $login, $password){
	
// @print_r($makerId);


	//echo "Ввошли в функцию";
	// НАЧАЛО Функция запроса данных
	$ch = curl_init("{$domain}{$searchPartUrl}?number={$partNumber}&maker_id={$makerId}&find_substitutes=1&store=0");

	curl_setopt($ch, CURLOPT_USERPWD, $login.':'.$password);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Accept: application/json',
		'Content-type: application/json'
	));

	$data = curl_exec($ch);
	curl_close($ch);

	$parts = json_decode($data);

	//if (count($parts) < 1) die("Не найдено ни одной детали ");
	// КОНЕЦ Функция запроса данных
	
	// НАЧАЛО Функция сортировки массива
		function sort_nested_arrays( $array, $args = array('votes' => 'desc') ){
		usort( $array, function( $a, $b ) use ( $args ){
			$res = 0;
			$a = (object) $a;
			$b = (object) $b;
			foreach( $args as $k => $v ){
				if( $a->$k == $b->$k ) continue;

				$res = ( $a->$k < $b->$k ) ? -1 : 1;
				if( $v=='desc' ) $res= -$res;
				break;
			}
			return $res;
		} );
		return $array;
	}
	// КОНЕЦ Функция сортировки массива


	// НАЧАЛО сортировка массива
		$parts = sort_nested_arrays($parts, array('number' => 'desc', 'price' => 'desc') );
	// КОНЕЦ сортировка массива

	$result = [];
	foreach($parts as $o) {
		$result[strtoupper($o->number)] = $o;
	};
	
// echo '<pre>';
// @print_r($parts);
// echo '</pre>';
	
	//$comma_separated = "'СT 1210.1','СТ 1212','171258','6ST-190N3R'";
	$comma_separated = "'".implode("','",array_keys($result))."','".$partNumber."'";

//echo $comma_separated;	
	
//ПОИСК ПО КАТАЛОГУ AD AVANTA
	// НАЧАЛО Функция запроса данных
	$ch = curl_init('https://adavanta.ru/api/v1/login/');
	curl_setopt($ch, CURLOPT_POST, true); //переключаем запрос в POST
//	curl_setopt($ch, CURLOPT_POSTFIELDS,"{ \"username\": \"demo3@avanta74.ru\", \"password\": \"OpquatBiwr\"}"); //Это POST данные
	curl_setopt($ch, CURLOPT_POSTFIELDS,"{ \"username\": \"virage-m@ya.ru\", \"password\": \"M952UXQJ\"}"); //Это POST данные

	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //Отключим проверку сертификата https
	//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); //из той же оперы
	$out = curl_exec($ch);
	$obj = json_decode($out);
	curl_close($ch);
//print_r($obj->{'token'});
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://adavanta.ru/api/v1/estimate/?number='.$partNumber.'&cross=1');
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', "Authorization: ".$obj->{'token'} ));
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //Отключим проверку сертификата https
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); //из той же оперы
	$out = curl_exec($ch);
	
	//echo "<BR>";
	$info = curl_getinfo($ch);
	//echo $info['http_code'];
	$AD_AVANTA = [];
	if($info['http_code'] == 200){
		$obj = json_decode($out);
		foreach ($obj as $arrayElement) {
			if($arrayElement->delivery_days == '0'){
				$AD_AVANTA[$arrayElement->partnumber] = $arrayElement;
			};
		};
	}elseif($info['http_code'] == 204){
		$AD_AVANTA = [];
	}
	//print_r($AD_AVANTA);
	
	
//ПОИСК ПО ВНУТРЕННИМУ КАТАЛОГУ
	
	include ("_local/_php/db.php");
	           
    $sql = "SELECT id, name, price1, price2, custom_field_66, ext_popup_picture, custom_field_67  FROM `cms_es_items` WHERE `public` = 1 AND `id_category` != '20389' AND `custom_field_67` IN (".$comma_separated.")";         
    //$mysqli->real_query($sql) or die("Ошибка запроса");
	$ext_picture = '';
	if($mysqli->real_query($sql)){
		$res = $mysqli->use_result();
		$AVTOMODA=[];
		$AVTOMODA_ORIG=[];
		$AVTOMODA_ORIG['ext_popup_picture'] = '';
		$AVTOMODA_ORIG['id'] = '';
		$AVTOMODA_ORIG['name'] = '';
			while ($row = $res->fetch_assoc()) {
// echo '<pre>';
// @print_r($row);
// echo '</pre>';
				$AVTOMODA[$row['custom_field_67']] = $row;
					$oTable = AMI::getResourceModel(
						'eshop_item/table',
							array(
								array(
									'extModeOnConstruct' => 'common'
								)
							)
					);
					$oItem = $oTable->find($row['id']);
					//echo '<br>'. $row['id'] . ' - '; 
				$AVTOMODA[$row['custom_field_67']]['linck'] = $oItem->getFullURL();
				// echo "--- ".$partNumber." ---";
				if(strtoupper($row['custom_field_67']) == strtoupper($partNumber)){
					$PartId = $row['id'];
					$AVTOMODA_ORIG = $row;
					$AVTOMODA_ORIG['linck'] = $oItem->getFullURL();
				//	print_r($row['custom_field_67']);
				}
				
			};
			
	}else{$AVTOMODA=[]; echo "Ошибка запроса";}	
	
	PodborDetalE($result, $AD_AVANTA, $AVTOMODA, $AVTOMODA_ORIG);
}	
	

function PodborDetalE($result, $AD_AVANTA, $AVTOMODA, $AVTOMODA_ORIG){	
	global $partNumber;
	$part=[];
	$Original="";
	$ReplacementOriginal="";
	$ReplacementNonOriginal="";
	$Original_AD_AVANTA="";
	$ReplacementOriginal_AD_AVANTA="";
	$ReplacementNonOriginal_AD_AVANTA="";
	$guaranteedDays="";
	$Green_span = "<span class='eshop-item-small__cart-text_green' ><span id='eshop-item-small_cart-text'>В наличии</span></span>";
	$Red_span = "<span class='eshop-item-small__cart-text_red' ><span id='eshop-item-small_cart-text'>Под заказ</span></span>";
	$guaranteedDays="<BR><B>(Доставка: 1 день)</B>";

	
	if ($AVTOMODA_ORIG['ext_popup_picture'] == '') { 
		echo "<img style='max-width: 60px; max-height: 60px; border-radius: 10px; float: left;' class='eshop_no_foto_img' src='_mod_files/ce_images/no_photo.jpg' title='Изображение отсутствует' alt='Изображение отсутствует'>";
	}else{
		echo "<div style='height: auto; width: 100px; float: left;' class='eshop-item-detailed__visual'><a class='eshop-item-detailed__popup-link' href='#' onclick='AMI.UI.MediaBox.open(`". $AVTOMODA_ORIG['ext_popup_picture'] ."`, 100+`%`, 100+`%`, `". $AVTOMODA_ORIG['name'] ."`, `". $AVTOMODA_ORIG['name'] ."`); return false;'><img style='max-width: 60px; max-height: 60px;'  data-ami-mbpopup='". $AVTOMODA_ORIG['ext_popup_picture'] ."' data-ami-mbgrp='". $AVTOMODA_ORIG['name'] ."' data-ami-mbhdr='". $AVTOMODA_ORIG['name'] ."' class='eshop-item-detailed__img' src='". $AVTOMODA_ORIG['ext_popup_picture'] ."' title='". $AVTOMODA_ORIG['name'] ."' alt='". $AVTOMODA_ORIG['name'] ."' onerror='this.src = `_mod_files/ce_images/no_photo.jpg`'><br><span class='eshop-item-detailed__img-label'>Увеличить</span></a></div>";
	}; 

	if($AVTOMODA_ORIG['name'] != ''){
		echo "<DIV style='font-weight: bold; font-size: 16px; float: left; line-height: 60px;'>". $AVTOMODA_ORIG['name'] ."<BR><BR></DIV>";
	}elseif(isset($AD_AVANTA[$partNumber]) && $AD_AVANTA[$partNumber]->description != '') {
		echo "<DIV style='font-weight: bold; font-size: 16px; float: left; line-height: 60px;'>". $AD_AVANTA[$partNumber]->description ."<BR><BR></DIV>";
	}
	//echo "<DIV style='font-weight: bold; font-size: 16px; float: left; line-height: 60px;'>". $AVTOMODA_ORIG['name'] ."<BR><BR></DIV>";
	echo "<TABLE class='vin_rez_table'><TR class='vin_rez_tr'><TH>Марка</TH><TH>Номер</TH><TH>Описание</TH><TH>Цена</TH><TH>Кол-во / В корзину</TH></TR>";
	
	
	if ($AVTOMODA_ORIG['id'] != '') {
	
		$Original .= "<TR><TD>&nbsp;</TD>
			<TD>&nbsp;". $AVTOMODA_ORIG['custom_field_67'] ."&nbsp;</TD>
			<TD><a class='search_linck' href='". $AVTOMODA_ORIG['linck'] ."'><pre class='search_td_name'>&nbsp;". $AVTOMODA_ORIG['name'] ."&nbsp;</pre></a></TD>
			<TD>
				<div class='eshop-item-small__price-tag eshop-item-small__price-tag_additional'>
					". number_format($AVTOMODA_ORIG['price1'], 2, '.', ' ') ." ₽
				</div>
			</TD>
			<TD width='160px'>
				<div class='eshop-item-small__content'>
					<div class='eshop-item-small__additional-price-'>
						<form name='qty_". $AVTOMODA_ORIG['id'] ."_1' onsubmit='return false;' class='eshop-item-small__cart-form'
							onclick='add_cart(`". $AVTOMODA_ORIG['name'] ."`, `qty_". $AVTOMODA_ORIG['id'] ."_1`, ". $AVTOMODA_ORIG['id'] .");'>
								<input class='txt cnt_qty eshop-item-small__quantity' onclick='this.select();AMI.Browser.Event.stopProcessing(event);' type='text' name='qty' value='1' qty_index='0'>
								<span class='eshop-item-small__cart-text_green' ><span id='eshop-item-small_cart-text'>В наличии</span></span>
						</form>
					</div>
				</div>
				</TD></TR>
		";
	};
	
	
	//Оригинал \ Искомая AD_AVANTA
	if (array_key_exists($partNumber, $AD_AVANTA)) {
		$Original_AD_AVANTA .= "<TR><TD>". $AD_AVANTA[$partNumber]->brand ."&nbsp;</TD>
			<TD>&nbsp;". $AD_AVANTA[$partNumber]->partnumber ."&nbsp;</TD>
			<TD><pre class='search_td_name'>&nbsp;". $AD_AVANTA[$partNumber]->description ."&nbsp;". $guaranteedDays ."</B></pre></TD>
					<TD>
						<div class='eshop-item-small__price-tag eshop-item-small__price-tag_additional'>
							". number_format(floatval($AD_AVANTA[$partNumber]->price*1.15), 2, '.', ' ') ." ₽
						</div>
					</TD>
					<TD width='160px'>
						<div class='eshop-item-small__content'>
							<div class='eshop-item-small__additional-price-'>
								<form name='qty__1' onsubmit='return false;' class='eshop-item-small__cart-form' onclick='search_add(this,`". $AD_AVANTA[$partNumber]->partnumber ."`, `". $AD_AVANTA[$partNumber]->brand ."`);'>
									<input class='txt cnt_qty eshop-item-small__quantity' onclick='this.select();AMI.Browser.Event.stopProcessing(event);' type='text' name='qty' value='1' qty_index='0'>". $Red_span ."</form>
							</div>
						</div>
					</TD></TR>
					";
				};
	
	
	
	
	
	if($result != false) {
		

		foreach ($result as $part) {
			
			//Оригинал - замена
			if ($part->detailGroup == 'ReplacementOriginal') {
				if (array_key_exists($part->number, $AVTOMODA)) {
					$ReplacementOriginal .= "<TR><TD>". $part->maker ."&nbsp;</TD>
					<TD>&nbsp;". $AVTOMODA[$part->number]['custom_field_67'] ."&nbsp;</TD>
					<TD><a class='search_linck' href='". $AVTOMODA[$part->number]['linck'] ."'><pre class='search_td_name'>&nbsp;". $AVTOMODA[$part->number]['name'] ."&nbsp;</pre></a></TD>
					<TD>
						<div class='eshop-item-small__price-tag eshop-item-small__price-tag_additional'>
							". number_format($AVTOMODA[$part->number]['price1'], 2, '.', ' ') ." ₽
						</div>
					</TD>
					<TD width='160px'>
						<div class='eshop-item-small__content'>
							<div class='eshop-item-small__additional-price-'>
								<form name='qty_". $AVTOMODA[$part->number]['id'] ."_1' onsubmit='return false;' class='eshop-item-small__cart-form'
								onclick='add_cart(`". $AVTOMODA[$part->number]['name'] ."`, `qty_". $AVTOMODA[$part->number]['id'] ."_1`, ". $AVTOMODA[$part->number]['id'] .");'>
									<input class='txt cnt_qty eshop-item-small__quantity' onclick='this.select();AMI.Browser.Event.stopProcessing(event);' type='text' name='qty' value='1' qty_index='0'>
									<span class='eshop-item-small__cart-text_green' ><span id='eshop-item-small_cart-text'>В наличии</span></span>
								</form>
							</div>
						</div>
					</TD></TR>
					";
				};
				
				//Оригинал - замена AD_AVANTA
				if (array_key_exists($part->number, $AD_AVANTA)) {
					$ReplacementOriginal_AD_AVANTA .= "<TR><TD>". $AD_AVANTA[$part->number]->brand ."&nbsp;</TD>
					<TD>&nbsp;". $AD_AVANTA[$part->number]->partnumber ."&nbsp;</TD>
					<TD><pre class='search_td_name'>&nbsp;". $AD_AVANTA[$part->number]->description ."&nbsp;". $guaranteedDays ."</B></pre></TD>
					<TD>
						<div class='eshop-item-small__price-tag eshop-item-small__price-tag_additional'>
							". number_format(floatval($AD_AVANTA[$part->number]->price*1.15), 2, '.', ' ') ." ₽
						</div>
					</TD>
					<TD width='160px'>
						<div class='eshop-item-small__content'>
							<div class='eshop-item-small__additional-price-'>
								<form name='qty__1' onsubmit='return false;' class='eshop-item-small__cart-form' onclick='search_add(this,`". $AD_AVANTA[$part->number]->partnumber ."`, `". $AD_AVANTA[$part->number]->brand ."`);'>
									<input class='txt cnt_qty eshop-item-small__quantity' onclick='this.select();AMI.Browser.Event.stopProcessing(event);' type='text' name='qty' value='1' qty_index='0'>". $Red_span ."</form>
							</div>
						</div>
					</TD></TR>
					";
				};
			};
			
			//Аналог
			if ($part->detailGroup == 'ReplacementNonOriginal') {
				if (array_key_exists($part->number, $AVTOMODA)) {
					$ReplacementNonOriginal .= "<TR><TD>". $part->maker ."&nbsp;</TD>
					<TD>&nbsp;". $AVTOMODA[$part->number]['custom_field_67'] ."&nbsp;</TD>
					<TD><a class='search_linck' href='". $AVTOMODA[$part->number]['linck'] ."'><pre class='search_td_name'>&nbsp;". $AVTOMODA[$part->number]['name'] ."&nbsp;</pre></a></TD>
					<TD>
						<div class='eshop-item-small__price-tag eshop-item-small__price-tag_additional'>
							". number_format($AVTOMODA[$part->number]['price1'], 2, '.', ' ') ." ₽
						</div>
					</TD>
					<TD width='160px'>
						<div class='eshop-item-small__content'>
							<div class='eshop-item-small__additional-price-'>
								<form name='qty_". $AVTOMODA[$part->number]['id'] ."_1' onsubmit='return false;' class='eshop-item-small__cart-form'
								onclick='add_cart(`". $AVTOMODA[$part->number]['name'] ."`, `qty_". $AVTOMODA[$part->number]['id'] ."_1`, ". $AVTOMODA[$part->number]['id'] .");'>
									<input class='txt cnt_qty eshop-item-small__quantity' onclick='this.select();AMI.Browser.Event.stopProcessing(event);' type='text' name='qty' value='1' qty_index='0'>
									<span class='eshop-item-small__cart-text_green' ><span id='eshop-item-small_cart-text'>В наличии</span></span>
								</form>
							</div>
						</div>
					</TD></TR>
					";
				};
				
				//Аналог_AD_AVANTA
				if (array_key_exists($part->number, $AD_AVANTA)) {
					$ReplacementNonOriginal_AD_AVANTA .= "<TR><TD>". $AD_AVANTA[$part->number]->brand ."&nbsp;</TD>
					<TD>&nbsp;". $AD_AVANTA[$part->number]->partnumber ."&nbsp;</TD>
					<TD><pre class='search_td_name'>&nbsp;". $AD_AVANTA[$part->number]->description ."&nbsp;". $guaranteedDays ."</B></pre></TD>
					<TD>
						<div class='eshop-item-small__price-tag eshop-item-small__price-tag_additional'>
							". number_format(floatval($AD_AVANTA[$part->number]->price*1.15), 2, '.', ' ') ." ₽
						</div>
					</TD>
					<TD width='160px'>
						<div class='eshop-item-small__content'>
							<div class='eshop-item-small__additional-price-'>
								<form name='qty__1' onsubmit='return false;' class='eshop-item-small__cart-form' onclick='search_add(this,`". $AD_AVANTA[$part->number]->partnumber ."`, `". $AD_AVANTA[$part->number]->brand ."`);'>
									<input class='txt cnt_qty eshop-item-small__quantity' onclick='this.select();AMI.Browser.Event.stopProcessing(event);' type='text' name='qty' value='1' qty_index='0'>". $Red_span ."</form>
							</div>
						</div>
					</TD></TR>
					";
				};
			};
		}
	}/* else{
		//print_r($AVTOMODA);
		$Original .= "<TR><TD>&nbsp;</TD>
					<TD>&nbsp;". $AVTOMODA[0]['custom_field_67'] ."&nbsp;</TD>
					<TD><a class='search_linck' href='". $AVTOMODA[0]['linck'] ."'><pre class='search_td_name'>&nbsp;". $AVTOMODA[0]['name'] ."&nbsp;</pre></a></TD>
					<TD>
						<div class='eshop-item-small__price-tag eshop-item-small__price-tag_additional'>
							". number_format($AVTOMODA[0]['price1'], 2, '.', ' ') ." ₽
						</div>
					</TD>
					<TD width='160px'>
						<div class='eshop-item-small__content'>
							<div class='eshop-item-small__additional-price-'>
								<form name='qty_". $AVTOMODA[0]['id'] ."_1' onsubmit='return false;' class='eshop-item-small__cart-form' onclick='amiCart.paymentMethod=`stub`;amiCart.add(`katalog/glavnaja-kategorija/katalog?itemId=". $AVTOMODA[0]['id'] ."&amp;num=1&amp;offset=0&amp;catoffset=0&amp;action=add`, ". $AVTOMODA[0]['id'] .", 1);'>
									<input class='txt cnt_qty eshop-item-small__quantity' onclick='this.select();AMI.Browser.Event.stopProcessing(event);' type='text' name='qty' value='1' qty_index='0'>
									<span class='eshop-item-small__cart-text_green' ><span id='eshop-item-small_cart-text'>В наличии</span></span>
								</form>
							</div>
						</div>
					</TD></TR>
					";
	} */
	
	if($Original != "" OR $Original_AD_AVANTA != ""){
		echo "<TR class='vin_rez_tr'><TH colspan='5'> --- <B> Искомая деталь </B> --- <BR></TH></TR>";
		echo $Original;
		echo $Original_AD_AVANTA;
	}
	
	if($ReplacementOriginal != "" OR $ReplacementOriginal_AD_AVANTA != ""){
		echo "<TR class='vin_rez_tr'><TH colspan='5'> --- <B> Оригинальная замена на искомую деталь </B> --- <BR></TH></TR>";
		echo $ReplacementOriginal;
		echo $ReplacementOriginal_AD_AVANTA;
	}
	
	if($ReplacementNonOriginal != "" OR $ReplacementNonOriginal_AD_AVANTA != ""){
		echo "<TR class='vin_rez_tr'><TH colspan='5'> --- <B> Не оригинальная замена (аналог) на искомую деталь </B> --- <BR></TH></TR>";
		echo $ReplacementNonOriginal;
		echo $ReplacementNonOriginal_AD_AVANTA;
	}
	

	echo "</TABLE>";
	echo '<div id="pop_up_load_add" style="display:none;"><img src="../_mod_files/ce_images/loading_.gif" id="pop_up_load_result_"></div>';
};
