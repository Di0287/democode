<?

	$host     = 'localhost';
    $user     = 'avtomoda_test';
    $password = '_test_00';
    $db     = 'avtomoda_test';            
    $mysqli = new mysqli($host, $user, $password, $db);
    $mysqli->set_charset("utf8");
    if ($mysqli->connect_errno) {
      echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
//id - номер заказа
$id_member = '2704'; // id пользователя
$id_site = '0';
$name = 'Пробный заказ'; // Имя ИМ
$order_date = '2020-12-07 00:06:15'; // Дата заказа
$approve_date = '0000-00-00 00:00:00';
$status = 'accepted'; // Статус заказа
$status_details = '';
$statuses_history = 'a:2:{i:1607281576;a:4:{s:4:"type";s:4:"user";s:6:"status";s:8:"accepted";s:2:"ip";s:15:"176.215.202.123";s:8:"comments";s:0:"";}}';
$firstname = 'Имя';
$lastname = 'Фамилия';
$username = 'Moon';
$email = 'di0287@ya.ru';
$company = 'MoonMoon';
$custinfo = 'a:11:{s:13:"get_type_name";s:16:"Доставка";s:7:"company";s:7:"AVT_OPT";s:7:"address";s:0:"";s:3:"inn";s:0:"";s:3:"kpp";s:0:"";s:4:"bank";s:0:"";s:3:"bik";s:0:"";s:7:"account";s:0:"";s:12:"corr_account";s:0:"";s:18:"shipping_conflicts";s:17:"show_intersection";s:7:"contact";s:4:"9999";}';
$sysinfo = 'a:6:{s:11:"person_type";s:9:"juridical";s:2:"ip";s:15:"176.215.202.123";s:6:"driver";s:4:"stub";s:11:"fee_percent";s:4:"0.00";s:8:"fee_curr";s:0:"";s:9:"fee_const";s:4:"0.00";}';
$card = '';
$card_exp = '';
$comments = '';
$adm_comments = '';
$tracking_number = '';
$tax = '';
$excise_tax = '';
$shipping_tax = '';
$shipping = '';
$total = '1000.00'; // Обшая цена заказа
$owners = ';eshop;';
$lang = 'ru';
$ext_data = 'a:5:{s:13:"base_currency";a:2:{s:4:"code";s:3:"RUR";s:8:"exchange";s:1:"1";}s:12:"buy_currency";a:2:{s:4:"code";s:3:"RUR";s:8:"exchange";s:1:"1";}s:14:"shipping_const";d:0;s:8:"currency";a:3:{s:0:"";a:5:{s:4:"name";s:0:"";s:6:"prefix";s:0:"";s:7:"postfix";s:12:"&nbsp;руб";s:8:"exchange";i:1;s:7:"is_base";b:0;}s:3:"RUR";a:10:{s:4:"name";s:6:"Руб";s:10:"code_digit";s:3:"810";s:6:"prefix";s:0:"";s:7:"postfix";s:3:"р.";s:8:"exchange";s:1:"1";s:6:"source";s:0:"";s:14:"fault_attempts";s:1:"0";s:7:"is_base";s:1:"1";s:8:"on_small";s:1:"0";s:2:"id";s:1:"1";}s:3:"USD";a:10:{s:4:"name";s:3:"USD";s:10:"code_digit";s:3:"840";s:6:"prefix";s:0:"";s:7:"postfix";s:0:"";s:8:"exchange";s:7:"0.03749";s:6:"source";s:0:"";s:14:"fault_attempts";s:1:"0";s:7:"is_base";s:1:"0";s:8:"on_small";s:1:"1";s:2:"id";s:1:"3";}}s:15:"discountForUser";a:0:{}}';
$id_external = '';
$modified_date = '2020-12-07 00:06:15';
$export_date = '';
$show_in_admin = '1';


$sql = "INSERT INTO `cms_es_orders` (`id`, `id_member`, `id_site`, `name`, `order_date`, `approve_date`, `status`, `status_details`, `statuses_history`, `firstname`, `lastname`, `username`, `email`, `company`, `custinfo`, `sysinfo`, `card`, `card_exp`, `comments`, `adm_comments`, `tracking_number`, `tax`, `excise_tax`, `shipping_tax`, `shipping`, `total`, `owners`, `lang`, `ext_data`, `id_external`, `modified_date`, `export_date`, `show_in_admin`) VALUES (NULL, '". $id_member ."', '". $id_site ."', '". $name ."', '". $order_date ."', '". $approve_date ."', '". $status ."', '". $status_details ."', '". $statuses_history ."', '". $firstname ."', '". $lastname ."', '". $username ."', '". $email ."', '". $company ."', '". $custinfo ."', '". $sysinfo ."', '". $card ."', '". $card_exp ."', '". $comments ."', '". $adm_comments ."', '". $tracking_number ."', '". $tax ."', '". $excise_tax ."', '". $shipping_tax ."', '". $shipping ."', '". $total ."', '". $owners ."', '". $lang ."', '". $ext_data ."', '". $id_external ."', '". $modified_date ."', '". $export_date ."', '". $show_in_admin ."')";

if($mysqli->real_query($sql)){
	$res = $mysqli->insert_id;
	"INSERT INTO `cms_es_order_items` (`id`, `id_order`, `id_product`, `id_prop`, `owner_name`, `price`, `price_number`, `qty`) VALUES (NULL, '0', '0', '0', 'eshop', '0', '0', '0');";
}else{ $mess = "Ошибка запроса";};
