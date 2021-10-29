<?php
//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);

//defined('_JEXEC') or die('Restricted access');

$partNumber        = "". $_POST["number"] .""; //артикул детали.
$brand       	   = "". $_POST["brand"] .""; //название производителя.

//print_r($_POST);

//ПОИСК ПО КАТАЛОГУ AD AVANTA
	// НАЧАЛО Функция запроса данных
	$ch = curl_init('https://adavanta.ru/api/v1/login/');
	curl_setopt($ch, CURLOPT_POST, true); //переключаем запрос в POST
	curl_setopt($ch, CURLOPT_POSTFIELDS,"{ }"); //Это POST данные
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //Отключим проверку сертификата https
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); //из той же оперы
	$out = curl_exec($ch);
	$obj = json_decode($out);
	curl_close($ch);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://adavanta.ru/api/v1/estimate/?number='.$partNumber.'&brand='.$brand);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', "Authorization: ".$obj->{'token'} ));
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //Отключим проверку сертификата https
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); //из той же оперы
	$out = curl_exec($ch);
	$info = curl_getinfo($ch);
	//echo $info['http_code'];
	if($info['http_code'] == 200){
		$obj = json_decode($out);
		foreach ($obj as $arrayElement) {
			if($arrayElement->delivery_days == '0'){
				$AD_AVANTA = $arrayElement;
			};
		};
	$i=
		//print_r($AD_AVANTA);
		include ("../_local/_php/vin/db.php");
		$sql = "INSERT INTO `cms_es_items` (`id`, `id_category`, `id_owner`, `name`, `public`, `price`, `price1`, `price2`, `price3`, `lang`, `date`, `custom_field_67`) VALUES (NULL, '20389', '2704', '".$AD_AVANTA->brand.". ".$AD_AVANTA->description."', '1', '".intval($AD_AVANTA->price)."', '".intval($AD_AVANTA->price*1.15)."', '".intval($AD_AVANTA->price*1.15)."', '".intval($AD_AVANTA->price*1.15)."', 'ru', NOW(), '".$AD_AVANTA->partnumber."')";
		//$mysqli->real_query($sql) or die("Ошибка запроса111");
		if($mysqli->real_query($sql)){
			//$res = $mysqli->use_result();
			$res = $mysqli->insert_id;
			//echo $res;
			$sql = "UPDATE `cms_es_items` SET `id_category` = '20389', `sku` = '". $AD_AVANTA->partnumber ." / 01', `position` = '". $res ."', `modified_date` = NOW() WHERE `cms_es_items`.`id` = ". $res;
			if($mysqli->real_query($sql)){
				//echo 'Обновилось';
				$mess = "";
				echo '{"status":true,"mess":"'. $mess .'","id":"'. $res .'","name":"'. $AD_AVANTA->description .'"}';
			}else{ $mess =  "Ошибка запроса";};
			//echo $res;
		}else{ $mess = "Ошибка запроса";};
	}elseif($info['http_code'] == 204){
		$AD_AVANTA = [];
		echo '{"status":204}';
	}	
	exit;
