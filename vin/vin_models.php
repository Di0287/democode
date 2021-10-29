<?
class PARTSAPI
{
    public static function getModels($make, $group, $key) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://partsapi.ru/api.php?act=getModels&make=$make&group=$group&key=$key",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => false,
        ));
        $response = curl_exec($curl);
        $response = json_decode($response, false);
        curl_close($curl);
        return $response;
    }
}
$make=$_POST['vin_marck'];
$group=$_POST['vin_type'];
include_once "vin_key.php";
$result=PARTSAPI::getModels($make, $group, $key);
//print_r($result);
echo "<option value='0'>Выбирите модель автомобиля</option>";
foreach($result as $res){
	echo "<option value='{\"id\":\"". $res->id ."\", \"marck\":\"". $res->make ."\", \"type\":\"". $res->type ."\"}'>". $res->name ."</option>";
}