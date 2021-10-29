<?
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$domain           = "http://www.part-kom.ru";
$login                = ''; //Ваш логин для входа на сайт http://www.part-kom.ru;
$password             = ''; //Ваш пароль для входа на сайт http://www.part-kom.ru;
$searchPartUrl        = '/engine/api/v3/ref/brands'; //url скрипта поиска детали

// НАЧАЛО Функция запроса данных
	$ch = curl_init("{$domain}{$searchPartUrl}");

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
	
	$brends = array();
	foreach ($parts as $part) {
		$brends[$part->name] = $part->id;
	};
	//print_r($brends);

class PARTSAPI
{
    public static function getSectionParts($modification_id, $group, $section_id, $key) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://partsapi.ru/api.php?act=getSectionParts&modification_id=$modification_id&group=$group&section_id=$section_id&key=$key",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => false,
        ));
        $response = curl_exec($curl);
        $response = json_decode($response, false);
        curl_close($curl);
        return $response;
    }
}
$modification_id=$_POST['mod'];
$group=$_POST['group'];
$section_id=$_POST['id'];
include_once "vin_key.php";
$result=PARTSAPI::getSectionParts($modification_id, $group, $section_id, $key);
//print_r($result);
echo "Список деталей данного узла<BR><BR>";
foreach($result as $res){
	//echo $brends[$res->supplier_name];
	if (array_key_exists($res->supplier_name, $brends)) {
		echo "<div class='sections_parts' onclick='PodborDetalU(`". $res->part_number ."`, `". $brends[$res->supplier_name] ."`)'>** <B>". $res->product_name ."</B><BR>Производитель: ". $res->supplier_name .". Артикул: ". $res->part_number .".</div><hr><BR>";
	}
	
}
?>
