<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
CJSCore::Init(array("jquery"));
$APPLICATION->SetTitle("Honey Hunters Management");
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>


<style>
.container {
	/* max-width: 1140px; */
}

.Contact_Icon {
	width: 25vw;
    min-width: 50px;
	max-width: 150px;
}

.thumbnail {
	background: #E9EEF3;
}

.bl-1 {
 background: #4B596C;
}

.bl-2 {
 min-height: 360px;
}

.tx_1 {
	font-family: Roboto;
	font-style: normal;
	font-weight: 500;
	font-size: 30px;
	line-height: 35px;
	text-align: center;
	color: #FFFFFF;
	word-wrap: break-word;
}

.tx_2 {
	font-family: Roboto;
	font-style: normal;
	font-weight: 500;
	font-size: 30px;
	line-height: 35px;
	text-align: center;
	color: #6D737B;
	word-wrap: break-word;
}

.tx_3 {
	font-family: Roboto;
	font-style: normal;
	font-weight: 500;
	font-size: 26px;
	line-height: 30px;
	text-align: center;
	color: #6D737B;
	word-wrap: break-word;
}

.tx_4 {
	font-family: Roboto;
	font-style: normal;
	font-weight: 500;
	font-size: 30px;
	line-height: 35px;
	color: #FFFFFF;
	word-wrap: break-word;
}

textarea {
    resize: none;
}

.div_img {
	background: #37414E;
    border: 3px solid #454648;
    box-sizing: border-box;
    width: 40px;
    height: 40px;
    border-radius: 20px;
	position: relative!important;
}

.row img{
      display: block;
      margin: 0 auto; 
    }

.border-white:focus {
	border-color: #BE393B;
}

.form-control:focus {
  box-shadow: inset 0 0 0 #fff, 0 0 0 #fff;
  border: 1px solid #BE393B!important;
}

.btn-primary:focus {
    box-shadow: inset 0 0 0 #fff, 0 0 0 #fff;
}

.er_text {
	display: none;
}

.er_name {
	display: none;
}

.er_mail {
	display: none;
}

.er_mail2 {
	display: none;
}
</style>

<div style="background: #2D3136;">
	<div class="container">
		<div class="row">
			<div class="col-6 col-lg-4 py-4">
				<img class="img-responsive img-fluid" src="logo.png">
			</div>
		</div>
		<div class="row justify-content-center">
			<div class="col-4 py-lg-4">

			</div>	
			<div class="col-4 col-lg-3 py-lg-4 position-relative">
				<img class="img-responsive img-fluid" src="Contact_Icon.png">
			</div>
			<div class="col-4 py-lg-4">

			</div>	
		</div>
		<BR><BR>
		
<form  id="form" method="post" action="">
	<div class="row">
		<div class="col-md-5">
			<div class="row ">
				<div class="mb-5">
					<label class="list lead tx_4 mb-3">Имя <span style="color: #BE393B;">*</span></label> 
					<label class=" er_name tx_4 mb-3"><span style="color: #BE393B;">Введите имя!</span></label>
					<input id="_name" type="text"  class="bg-transparent text-white border-white form-control" required>
				</div>
			</div>
			<div class="row">
				<div class="mb-5">
					<label class="list lead tx_4 mb-3">E-mail <span style="color: #BE393B;">*</span></label>
					<label class=" er_mail tx_4 mb-3"><span style="color: #BE393B;">Введите E-mail!</span></label>
					<label class=" er_mail2 tx_4 mb-3"><span style="color: #BE393B;">Введите корректный E-mail!</span></label>
					<input id="_mail" type="email" aria-describedby="emailHelp" class="bg-transparent text-white border-white form-control" >
				</div>
			</div>
		</div>
		<div class="col-md-2"></div>
		<div class="col-md-5">
			<div class="mb-5">
				<label class="list lead tx_4 mb-3">Коментарий <span style="color: #BE393B;">*</span></label>
				<label class=" er_text tx_4 mb-3"><span style="color: #BE393B;">Введите имя!</span></label>
				<textarea id="_text" class="bg-transparent text-white border-white form-control" rows="7" required></textarea>
			</div>
		</div>
		
    </div>


	<div class="row justify-content-end px-4 mb-5">
		<input type="button" class="col-lg-1 btn btn-primary" onclick="save()" value="Записать">
	</div>
</form>
		<div class="row justify-content-end px-4 mb-5">	</div>
	</div>
</div>

<div class="container">

	<div class="lead text-center fw-bold fs-1 py-5">Вывод коментариев</div>

<div id="res" class="row coment">
		
	<div class="item col-xs-4 col-lg-4 mb-4">
		<div class="thumbnail bl-2 h-100">
		<div class="row align-items-center py-3 bl-1 g-0">
			<div class="list lead text-center tx_1">Вася</div>
		</div>
		<div class="row align-items-center py-5 g-0">
			<div class="list lead text-center tx_2">vasya@mail.ru</div>
		</div>
			<div class="lead text-center tx_3 pb-3">
				Сообщение от Василия Пупкина.
			</div>
		</div>
	</div>

 </div>
</div>

<div style="background: #2D3136;">
	<div class="container">
	<div class="row justify-content-between px-2">
		<div class="col-lg-2 col-5 py-4">
			<img class="img-responsive img-fluid" src="logo.png">
		</div>
		
		<div class="col-lg-2 col-6 py-4">
			<div class="row justify-content-between">
				<div class="col-2">
					
				</div>
				<div class="col-4">
					<div class="div_img">
						<img class="position-absolute top-50 start-50 translate-middle img-responsive img-fluid" src="vk.png">
					</div>
				</div>
				<div class="col-4">
					<div class="div_img">
						<img class="position-absolute top-50 start-50 translate-middle img-responsive img-fluid" src="fb.png">
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
</div>
		

<script>

function save(){
	var name = $('#_name').val();
	var mail = $('#_mail').val();
	var text = $('#_text').val();
	
	
	var reg     = /^\w+([\.-]?\w+)*@(((([a-z0-9]{2,})|([a-z0-9][-][a-z0-9]+))[\.][a-z0-9])|([a-z0-9]+[-]?))+[a-z0-9]+\.([a-z]{2}|(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum))$/i;
    var el_e    = $('#_mail');
    var v_email = el_e.val()?false:true;
  
	$(".er_name").css("display", "none");
	$(".er_mail").css("display", "none");
	$(".er_mail2").css("display", "none");
	$(".er_text").css("display", "none");
	
	
	
	
	if(name == ''){
		$(".er_name").css("display", "inline-block");
	}else if(v_email){
		$(".er_mail").css("display", "inline-block");
    } else if(!reg.test(el_e.val())){
      v_email = true;
      $(".er_mail2").css("display", "inline-block");
    }else if(text == ''){
		$(".er_text").css("display", "inline-block");
	}else{
		
	$.ajax({
        url: "zap.php",
        type: "POST",
        dataType: "html",
        data: {pg: 'add', name: name, mail: mail, text: text},
        success: function(data){
			$('#res').html(data);
			$('#_name').val('');
			$('#_mail').val('');
			$('#_text').val('');
        }
    });
	}
	return false;
}

function load(){
	$.ajax({
        url: "zap.php",
        type: "POST",
        dataType: "html",
        data: {pg: 'load'},
        success: function(data){
			$('#res').html(data);
        }
    });
	return false;
}

load();
$("#res").bind( 'DOMSubtreeModified',function(){
	$(".item .bl-1:odd").css("background-color", "#58AD52");
	$(".item .tx_2:odd").css("color", "#58AD52");
});

</script>




<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>

