<?
class PARTSAPI
{
    public static function getMakes($group, $key) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://partsapi.ru/api.php?act=getMakes&group=$group&key=$key",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => false,
        ));
        $response = curl_exec($curl);
        $response = json_decode($response, false);
        curl_close($curl);
        return $response;
    }
}
$group=$_POST['vin_type'];
include "vin_key.php";
$result=PARTSAPI::getMakes($group, $key);
//print_r($result);
echo "<option value='0'>Выбирите марку автомобиля</option>";
foreach($result as $res){
	echo "<option value='". $res->id ."'>". $res->name ."</option>";
}