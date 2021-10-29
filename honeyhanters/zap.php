<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");

//print_r($_POST);

if ($_POST['pg'] == 'load'):
	load();
endif;

function load(){
	if($_POST['pr'] == 'DESC'){$sort = 'ASC';}else{$sort = 'DESC';}
	if (CModule::IncludeModule("iblock")):	
		$my_slider = CIBlockElement::GetList (
			Array("DATE_CREATE" => "ASC"),
			Array("IBLOCK_ID" => "2"), false, false,
			Array('ID',	'NAME',	'ACTIVE', 'PREVIEW_TEXT', 'DETAIL_TEXT')
		);
	endif;
	
	while($ar_fields = $my_slider->GetNext()){
?>
	<div class="item col-xs-4 col-lg-4 mb-4">
		<div class="thumbnail bl-2 h-100">
		<div class="row align-items-center py-3 bl-1 g-0">
			<div class="list lead text-center tx_1"><? echo $ar_fields['NAME'] ?></div>
		</div>
		<div class="row align-items-center py-5 g-0">
			<div class="list lead text-center tx_2"><? echo $ar_fields['PREVIEW_TEXT'] ?></div>
		</div>
			<div class="lead text-center tx_3 pb-3">
				<? echo $ar_fields['DETAIL_TEXT'] ?>
			</div>
		</div>
	</div>
<?
	}
}

if ($_POST['pg'] == 'add'):
if (CModule::IncludeModule("iblock")):
	$el = new CIBlockElement;
	$arLoadProductArray = Array(
	  "IBLOCK_ID"      => 2,
	  "DATE_ACTIVE_FROM"    => date('d.m.Y H:i:s'),
	  "NAME"           => $_POST['name'],
	  "ACTIVE"         => "Y",
	  "DETAIL_TEXT"    => $_POST['text'],
	  "PREVIEW_TEXT"    => $_POST['mail']
	  );

	if($ID = $el->Add($arLoadProductArray))
		load();
	else
	  echo "Error: ".$el->LAST_ERROR;
endif;
endif;

?>