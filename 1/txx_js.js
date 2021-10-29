function txx_hide() {
	$.ajax({ 
		url: 'txx.php',
		headers: {'Content-Type': 'application/x-www-form-urlencoded'}, type: "POST", dataType: "text",
		success: function (result) {
			$("div#shopping_cart").html(result);
			txx_in_cart();
		}, error: function () {console.log("error");}
    });
}

function txx_in_cart() {
	$.ajax({ 
		url: 'txx_in_cart.php',
		headers: {'Content-Type': 'application/x-www-form-urlencoded'}, type: "POST", dataType: "text",
		success: function (result) {
			var ArrRes = JSON.parse(result);
			//$("div#shopping_cart").html(result);
			//$('.fox-copyright').remove();
			var ArrRes = JSON.parse(result);
			var index;
			for (var key in ArrRes) {
				// console.log(ArrRes[key]);
				$("#in_cart_" + key).html("<div id='InCart_911' class='eshop-item-tooltip' style='display: block;'><div class='eshop-item-tooltip-area'><span class='eshop-item-tooltip-title'>В корзине: "+ ArrRes[key] +"</span> </div> </div>");
			}
			
			//console.log(result);
			//console.log( JSON.parse(result));
		}, error: function () {console.log("error");}
    });
}


function txx_cart() {
	$.ajax({ 
		url: 'txx_cart.php',
		headers: {'Content-Type': 'application/x-www-form-urlencoded'}, type: "POST", dataType: "text",
		success: function (result) {
			$('#result_cart').append(result);
		}, error: function () {console.log("error");}
	});
}

function add_cart(Name, element, itemid) {
	var cost = $("form[name="+element+"] input[name='qty']").val();
	$.ajax({ 
		url: 'txx_add.php',
		headers: {'Content-Type': 'application/x-www-form-urlencoded'}, type: "POST", dataType: "text", data: { Name: Name, Cost: cost, ItemId: itemid },
		success: function (result) {
			$('body').append(result);
			//console.log(result);
			txx_hide();
			txx_in_cart();
		}, error: function () {console.log("error");}
	});
	//console.log(cost );
}

function cartPopupCose(){
		console.log("Удалленно");
		$("#cartPopupWindow_layer").remove();
		$("#cartPopupWindow").remove();
	};
	
$(document).on('click','.popupWindowShadow',function(e){
		console.log("Удалленно");
		$("#cartPopupWindow_layer").remove();
		$("#cartPopupWindow").remove();
	});

function clear_cart() {
	$.ajax({ 
		url: 'txx_clear.php',
		headers: {'Content-Type': 'application/x-www-form-urlencoded'}, type: "POST", dataType: "text",
		success: function (result) {
// 			console.log("ПРОВЕРКА0000");
// 			location.reload();
		}, error: function () {console.log("error");}
	});
}

function txx_update(itemid, type) {
	var cost = parseInt($("input[name=qty_"+ itemid +"]").val());
	console.log(cost);
	if (cost === parseInt(cost, 10) && cost != 0){
		console.log(cost);
		console.log(itemid);
		$.ajax({ 
			url: 'txx_update.php',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'}, type: "POST", dataType: "text", data: { Cost: cost, ItemId: itemid, type: type},
			success: function (result) {
				location.href=location.href;
				console.log(result);			
			}, error: function () {console.log("error");}
		});
	}else{alert('Введите целое число');};
}


