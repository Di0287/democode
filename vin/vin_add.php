<?php
//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);

defined('_JEXEC') or die('Restricted access');

$partNumber        = "". $_POST["number"] .""; //название производителя.
$makerId       	   = "". $_POST["IdPr"] .""; //артикул детали
$providerId        = "". $_POST["providerId"] .""; //артикул склада

//echo "ВИН <BR><BR>";
//print_r($_POST);
//echo "<BR><BR>";
//$partNumber = htmlspecialchars(stripslashes($partNumber));
//$makerId = htmlspecialchars(stripslashes($makerId));

$domain           = "http://www.part-kom.ru";
$login                = ''; //Ваш логин для входа на сайт http://www.part-kom.ru;
$password             = ''; //Ваш пароль для входа на сайт http://www.part-kom.ru;
$searchPartUrl        = '/engine/api/v3/search/parts'; //url скрипта поиска детали

// НАЧАЛО Функция запроса данных
	$ch = curl_init("{$domain}{$searchPartUrl}?number={$partNumber}&maker_id={$makerId}&find_substitutes=0&store=0");

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
	
	foreach ($parts as $part) {
				if (strtoupper($part->providerId) == $providerId) {
					$add_part = $part;
					//print_r($part);
					break;
				}
			};
	//print_r($add_part);
include ("../_local/_php/vin/db.php");

$sql = "INSERT INTO `cms_es_items` (`id`, `id_category`, `id_owner`, `name`, `price`, `price1`, `price2`, `price3`, `lang`, `date`, `custom_field_67`) VALUES (NULL, '20361', '2701', '". $add_part->description ."', '". intval($add_part->price*1.15) ."', '". intval($add_part->price*1.15) ."', '". intval($add_part->price*1.15) ."', '". intval($add_part->price*1.15) ."', 'ru', NOW(), ". $partNumber .")";
    //$mysqli->real_query($sql) or die("Ошибка запроса");
	if($mysqli->real_query($sql)){
		//$res = $mysqli->use_result();
		$res = $mysqli->insert_id;
		//echo $res;
		$sql = "UPDATE `cms_es_items` SET `id_category` = '20361', `sku` = '". $res ."', `position` = '". $res ."', `modified_date` = NOW() WHERE `cms_es_items`.`id` = ". $res;
		if($mysqli->real_query($sql)){
			//echo 'Обновилось';
			$mess = "";
		}else{ $mess =  "Ошибка запроса";}
		//echo $res;
	}else{ $mess = "Ошибка запроса";}
	
	echo '{"status":true,"mess":"'. $mess .'","id":"'. $res .'"}';
