<script>
jQuery(document).ready(function() {
	$.fn.extend({
	    toggleText: function(a, b){
	        return this.text(this.text() == b ? a : b);
	    }
	});
    
	$('.list_item > a').click(function(event) {
		$(this).children('span').toggleText('+', '-');
		$(this).next('.res_1_list').slideToggle(200);
	});
	
	$('.res_1_list_item > a').click(function(event) {
		$(this).children('span').toggleText('+', '-');
		$(this).next('.res_2_list').slideToggle(200);
	});
	
	$('.res_2_list_item > a').click(function(event) {
		$(this).children('span').toggleText('+', '-');
		$(this).next('.res_3_list').slideToggle(200);
	});

});
</script>
<style>
a {
  text-decoration: none;
}
.list .list_item {
  padding: 12px 16px;
  border-bottom: 1px solid #ccc;
  display: flex;
  flex-wrap: wrap;
}
.list .list_item a {
  color: #000;
  font-size: 16px;
  font-family: sans-serif;
  line-height: 1.5;
  display: flex;
  flex-wrap: wrap;
  width: 100%;
}
.list .list_item span {
  margin-right: 4px;
  display: block;
  width: 16px;
  text-align: center;
}
.list .list_item .open .arrow_icon {
  margin-top: -20px;
  transform: rotate(90deg);
}
.list .list_item .arrow_icon {
  margin-left: auto;
  position: relative;
  display: block;
  width: 24px;
  height: auto;
  transition: 0.3s;
}

.list .list_item_toggler {
  width: 100%;
  display: none;
  padding-left: 10px;
  margin-top: 10px;
  border-left: 1px solid #ccc;
}
.list .list_item_toggler a {
  line-height: 32px;
}

.res_1_list, .res_2_list, .res_3_list{
  display: none;
}
.res_1_list{
  padding-left: 20px;
}
.res_2_list{
  padding-left: 40px;
}
.res_3_list{
  padding-left: 60px;
}
</style>

<?php
header('Content-Type: text/html; charset=utf-8');
class PARTSAPI
{
    public static function getSections($modification_id, $group, $section_id, $lang, $key) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://partsapi.ru/api.php?act=getSections&modification_id=$modification_id&group=$group&section_id=$section_id&lang=$lang&key=$key",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => false,
        ));
        $response = curl_exec($curl);
        $response = json_decode($response, false);
        curl_close($curl);
        return $response;
    }
}
$vin_type=$_POST['vin_type'];
$vin_car=$_POST['vin_car'];
$modification_id = $vin_car;
$group = $vin_type{0};
$section_id="0";
$lang="ru";
include_once "vin_key.php";
$result=PARTSAPI::getSections($modification_id, $group, $section_id, $lang, $key);
//print_r($result);
echo "<section class='list'>";
foreach($result as $res){
	if ($res->parentNodeId == ''){
		
		//echo $res->assemblyGroupName. "<br>";
		echo "<div class='list_item'>";
			echo "<a href='javascript:void(0);'> <span>+</span> ". $res->assemblyGroupName ." </a>";
			echo "<div class='res_1_list'>";
		
			foreach($result as $res_1){
				echo "<div class='res_1_list_item'>";
				if ($res_1->parentNodeId == $res->assemblyGroupNodeId){
					if ($res_1->hasChilds == ''){
						echo "<a href='javascript:vin_detali_uzla(". $res_1->assemblyGroupNodeId .", ". $modification_id .", `". $vin_type ."`);'><U>=> " .$res_1->assemblyGroupName. "</U></a><br>";
					}else{
						echo "<a href='javascript:void(0);'> <span>+</span> ". $res_1->assemblyGroupName ." </a>";
					}
					echo "<div class='res_2_list'>";
					
					foreach($result as $res_2){
						echo "<div class='res_2_list_item'>";
						if ($res_2->parentNodeId == $res_1->assemblyGroupNodeId){
							if ($res_2->hasChilds == ''){
								echo "<a href='javascript:vin_detali_uzla(". $res_2->assemblyGroupNodeId .", ". $modification_id .", `". $vin_type ."`);'><U>=> " .$res_2->assemblyGroupName. "</U></a><br>";
							}else{
								echo "<a href='javascript:void(0);'> <span>+</span> ". $res_2->assemblyGroupName ." </a>";
							}
							echo "<div class='res_3_list'>";
							
							foreach($result as $res_3){
								echo "<div class='res_3_list_item'>";
								if ($res_3->parentNodeId == $res_2->assemblyGroupNodeId){
									if ($res_3->hasChilds == ''){
										echo "<a href='javascript:vin_detali_uzla(". $res_3->assemblyGroupNodeId .", ". $modification_id .", `". $vin_type ."`);'><U>=> " .$res_3->assemblyGroupName. "</U></a><br>";
									}else{
										echo "<a href='javascript:void(0);'> <span>+</span> ". $res_3->assemblyGroupName ." </a>";
									}
									
								}
								unset($res_3);
								echo "</div>";
							}
							echo "</div>";
							unset($res_2);
						}
						echo "</div>";
					}
					echo "</div>";
				unset($res_1);
				}
			echo "</div>";
			}
			echo "</div>";
		echo "</div>";
	}
}
echo "</section>";
?>