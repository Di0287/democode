<script type="text/javascript" src="https://yandex.st/jquery/1.7.2/jquery.min.js"></script>
<meta charset="utf-8">
<div class="form__caption">Поиск товара по артиклу</div>
<input size="40" class="pd_input_text" type="text" name="pd_input_" value="" placeholder="поиск товара по артиклу">
<input class="pd_input_submin" type="submit" value="Найти" onclick="PodborDetal();">
<BR><BR>
<div id='result_pd'></div>

<script>
function PodborDetal() {
    $.post("code.php", { name: $("input[name='pd_input_']").val() }).done(function(html_pd){
                $("div#result_pd").html(html_pd);
            });
};

function PodborDetalU(IdPr, name) {
    $.post("code.php", { IdPr: IdPr, name: name }).done(function(html_pd){
                $("div#result_pd").html(html_pd);
            });
};
</script>