<?
class PARTSAPI
{
    public static function getCars($make, $model, $group, $key) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://partsapi.ru/api.php?act=getCars&make=$make&model=$model&group=$group&key=$key",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => false,
        ));
        $response = curl_exec($curl);
        $response = json_decode($response, false);
        curl_close($curl);
        return $response;
    }
}
$model=$_POST['vin_model'];
$make=$_POST['vin_marck'];
$group=$_POST['vin_type'];
include_once "vin_key.php";
$result=PARTSAPI::getCars($make, $model, $group, $key);
//print_r($result);
echo "<option value='0'>Выбирите модификацию модели автомобиля</option>";
foreach($result as $res){
	echo "<option value='{\"id\":\"". $res->id ."\", \"type\":\"". $res->type ."\"}'>". $res->name ."</option>";
}