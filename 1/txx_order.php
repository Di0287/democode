<script type="text/javascript" src="https://yandex.st/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="txx_js.js"></script>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
 
    <div class="eshop-order__shippings">
    <div class="eshop-ordering__caption">Контактная информация
        

    </div>

    <div class="eshop-ordering__field">
        <div class="eshop-ordering__field-name">Имя*:</div>
        <input id="Ffirstname" type="text" class="eshop-ordering__textfield" name="firstname" size="30" value="Moon">
    </div>

    <div class="eshop-ordering__field" style="display: none;">
        <div class="eshop-ordering__field-name">Фамилия*:</div>
        <input id="Flastname" type="text" class="eshop-ordering__textfield" name="lastname" size="30" value="Light">
    </div>

    <div class="eshop-ordering__field">
        <div class="eshop-ordering__field-name">Адрес email*:</div>
        <input id="Femail" type="email" class="eshop-ordering__textfield" name="email" size="30" value="di0287@yandex.ru">
    </div>

    <div class="eshop-ordering__field">
        <div class="eshop-ordering__field-name">Телефон*:</div>
        <input id="Fcontact" type="text" class="eshop-ordering__textfield" name="contact" size="30" value="9999999" maxlength="24">
    </div>


  
<div class="eshop-ordering__field">

<div class="eshop-ordering__caption">Как вы предпочитаете получить заказ?</div>
		<div class="eshop-ordering__field">
    <label for="shipping_method_11_11" class="eshop-ordering__radio-label">
        <input type="radio" class="eshop-ordering__radio" id="shipping_method_11_11" name="get_type" value="11" >
        <div class="eshop-ordering__shipping-description">
            <div class="eshop-ordering__shipping-name">
                Самовывоз
            </div>
        </div>
    </label>
</div>

<div class="eshop-ordering__field">
    <label for="shipping_method_11_12" class="eshop-ordering__radio-label">
        <input type="radio" class="eshop-ordering__radio" id="shipping_method_11_12" name="get_type" value="12" >
        <div class="eshop-ordering__shipping-description">
            <div class="eshop-ordering__shipping-name">
                Доставка
            </div>
        </div>
    </label>
</div>



        
        <div class="eshop-ordering__caption">Выберите способ оплаты:</div>

<div class="eshop-ordering__field">
    <label for="paymentformstub" class="eshop-ordering__radio-label">
        <input type="radio" class="eshop-ordering__radio" id="paymentformstub" name="paymentMethods" value="stub" >
        <div class="eshop-ordering__shipping-description">
            <div class="eshop-ordering__shipping-name">
                Наличный расчет 
            </div>
        </div>
    </label>
</div>

<div class="eshop-ordering__field">
    <label for="paymentformprint" class="eshop-ordering__radio-label">
        <input type="radio" class="eshop-ordering__radio" id="paymentformprint" name="paymentMethods" value="print" >
        <div class="eshop-ordering__shipping-description">
            <div class="eshop-ordering__shipping-name">
                Безналичный расчет 
            </div>
        </div>
    </label>
</div>
    </div>


<div style="visibility: hidden;" id="info_custom_shipping">
    <div class="eshop-ordering__caption">Информация для доставки:</div>
</div>



        
        <div>* — Обязательные поля</div>
        <div id="eshop-ordering__price-total" class="eshop-ordering__price-total">Общая стоимость Вашего заказа: <span class="eshop-ordering__price-total-value">43 560.90&nbsp;р.</span></div>
        <button type="buttom" onclick='javascript:txx_save()' class="eshop-ordering__submit">Оформить заказ</button>
