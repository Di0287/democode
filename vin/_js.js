$.extend({
  getUrlVars: function(){
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
      hash = hashes[i].split('=');
      vars.push(hash[0]);
      vars[hash[0]] = hash[1];
    }
    return vars;
  },
  getUrlVar: function(name){
    return $.getUrlVars()[name];
  }
});

$(window).bind("load", function() {
	if ($.getUrlVars()['id_part'] !== undefined) {
		$("input[name='vin_input_']").val($.getUrlVars()['id_part']);
		PodborDetal($.getUrlVars()['id_part']);
		alert($.getUrlVars()['id']);
	};
}); 

/* //выбор марки автомобиля
$(document).ready(function(){
	// Марка автомобиля
	$("select#vin_type").change(function(){
		$("select#vin_marck").attr("disabled","disabled");
		$("select#vin_marck").html("<option>Ждите...</option>");
		var vin_type = $("select#vin_type option:selected").attr('value');
		$.ajax({ 
			url: '/_local/_include_php.php',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'}, type: "POST", dataType: "text", data: { 
				vin_type:vin_type, vin_:"marck"
			},success: function (result) {
				if($("select#vin_marck").html(result)){
					$('select#vin_type option[value=0]').remove();
					$("select#vin_marck").removeAttr("disabled");
				};
			}, error: function () {console.log("error");}
		});
	});
	
	// Модель автомобиля
	$("select#vin_marck").change(function(){
		$("select#vin_model").attr("disabled","disabled");
		$("select#vin_model").html("<option>Ждите...</option>");
		var vin_type = $("select#vin_type option:selected").attr('value');
		var vin_marck = $("select#vin_marck option:selected").attr('value');
		$.ajax({ 
			url: '/_local/_include_php.php',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'}, type: "POST", dataType: "text", data: { 
				vin_type:vin_type, vin_marck:vin_marck, vin_:"models" 
			},success: function (result) {
				if($("select#vin_model").html(result)){
					$('select#vin_marck option[value=0]').remove();
					$("select#vin_model").removeAttr("disabled");
				};
			}, error: function () {console.log("error");}
		});
	});
	
	// Модификация модели автомобиля
	$("select#vin_model").change(function(){
		var vin_json = $("select#vin_model option:selected").attr('value');
		vin_json = JSON.parse(vin_json);
		var vin_type = vin_json['type'];
		var vin_marck = vin_json['marck'];
		var vin_model = vin_json['id'];
		$("select#vin_car").attr("disabled","disabled");
		$("select#vin_car").html("<option>Ждите...</option>");
		$.ajax({ 
			url: '/_local/_include_php.php',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'}, type: "POST", dataType: "text", data: { 
				vin_type:vin_type, vin_marck:vin_marck, vin_model:vin_model, vin_:"cars" 
			},success: function (result) {
				if($("select#vin_car").html(result)){
					$('select#vin_model option[value=0]').remove();
					$("select#vin_car").removeAttr("disabled");
				};
			}, error: function () {console.log("error");}
		});
	});
	
	// Список узлов автомобиля
	$("select#vin_car").change(function(){
		PopUpShow_load();
		var vin_json = $("select#vin_car option:selected").attr('value');
		vin_json = JSON.parse(vin_json);
		console.log(vin_json);
		var vin_type = vin_json['type'];
		var vin_car = vin_json['id'];
		$.ajax({ 
			url: '/_local/_include_php.php',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'}, type: "POST", dataType: "text", data: { 
				 vin_:"sections", vin_type:vin_type, vin_car:vin_car
			},success: function (result) {
				//console.log(result);
				if($("#result_vin_uzel").html(result)){
					$('select#vin_car option[value=0]').remove();
					PopUpHide_load();
				};
			}, error: function () {console.log("error");}
		});
	});
});

// Список детелей узлов автомобиля
	function vin_detali_uzla(id, mod, group) {
		PopUpShow_load();
		$.ajax({ 
			url: '/_local/_include_php.php',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'}, type: "POST", dataType: "text", data: { 
				 vin_:"sections_parts", id:id, mod:mod, group:group
			},success: function (result) {
				console.log(result);
				if($("#result_vin_detali").html(result)){
					PopUpHide_load();
				};
			}, error: function () {console.log("error");}
		});
	};

// Раскрывающийся список
jQuery(document).ready(function() {
	$.fn.extend({
	    toggleText: function(a, b){
	        return this.text(this.text() == b ? a : b);
	    }
	});
    
	$('.list_item > a').click(function(event) {
		
		$(this).children('span').toggleText('+', '-');
		$(this).next('.second_list').slideToggle(200);
	});
	$('.second_list_item > a').click(function(event) {
		$(this).children('span').toggleText('+', '-');
		$(this).next('.third_list').slideToggle(200);
	});



}); */

function PodborDetal(id_part) {
	//console.log(id_part);
	if(!!!id_part){
		var id = $("input[name='vin_input_']").val();
	}else{
		var id = id_part;
	};
	//var id = $("input[name='vin_input_']").val();
	//PopUpShow_load();
if(id != ""){
	$("div#result_vin").html('<div id="pop_up_load" style="/* display:none; */" wfd-invisible="true"> <img src="../_mod_files/ce_images/loading_.gif" id="pop_up_load_result_"> </div>');
	$.ajax({ 
		url: '_include_php.php',
		headers: {'Content-Type': 'application/x-www-form-urlencoded'}, type: "POST", dataType: "text", data: { name: id, search:"PodborDetal" },
		success: function (result) {
				//console.log(result);
			if($("div#result_vin").html(result)){
				//PopUpHide_load();
			};
					//PopUpHide_load();
		}, error: function () {console.log("error");}
	});
};
};

function PodborDetalU(name, IdPr) {
    $("div#result_vin").html('<div id="pop_up_load" style="/* display:none; */" wfd-invisible="true"> <img src="../_mod_files/ce_images/loading_.gif" id="pop_up_load_result_"> </div>');
	$.ajax({ 
		url: '_include_php.php',
		headers: {'Content-Type': 'application/x-www-form-urlencoded'}, type: "POST", dataType: "text", data: { IdPr: IdPr, name: name, search:"PodborDetalU" },
		success: function (result) {
				console.log(result);
			if($("div#result_vin").html(result)){
				//PopUpHide_load();
				$("html,body").scrollTop($("div#result_vin").offset().top)
			};
					//PopUpHide_load();
		}, error: function () {console.log("error");}
	});
};


function search_add(element, number_, brand_) { 
	PopUpShow_load_add();
	$.ajax({ 
		url: '/_local/_include_php.php',
		headers: {'Content-Type': 'application/x-www-form-urlencoded'}, type: "POST", dataType: "text", data: { brand: brand_, number: number_, search_add:"search_add" },
		success: function (result_add) {
				console.log(result_add);
				if(result_add.startsWith('{"status":') || result_add.endsWith('}')){
					var result_add = JSON.parse(result_add);
				console.log(result_add['status']);
					if(result_add['status'] == true){
						$(element).attr('name', 'qty_'+result_add['id']+'_1');
						//amiCart.paymentMethod=`stub`;
						//amiCart.add('katalog/glavnaja-kategorija/katalog?itemId='+result_add[`id`]+'&num=1&offset=0&catoffset=0&action=add', result_add[`id`], 1);
						add_cart(name, 'qty_'+result_add['id']+'_1', result_add[`id`]);
					}else{
						alert("Ошибка 204.");
					};
				}else{
					alert("Ошибка запроса. Обратитесь");
				};
				PopUpHide_load_add();
		}, error: function () {console.log("error");}
	});
};


function PopUpShow_load(){
	//$("div#result_vin").append('<div id="pop_up_load" style="display:none;"><img src="../_mod_files/ce_images/loading_.gif" id="pop_up_load_result_"></div>')
    $("#pop_up_load").show();
   }
	
function PopUpHide_load(){
        $("#pop_up_load").hide();
    }
	
function PopUpShow_load_add(){
	//$("div#result_vin").append('<div id="pop_up_load" style="display:none;"><img src="../_mod_files/ce_images/loading_.gif" id="pop_up_load_result_"></div>')
    $("#pop_up_load_add").show();
   }
	
function PopUpHide_load_add(){
        $("#pop_up_load_add").hide();
    }
	
function PopUpShow_info(){
        $("#pop_up_info").fadeIn();
    }
	
function PopUpHide_info(){
        $("#pop_up_info").fadeOut();
}
    