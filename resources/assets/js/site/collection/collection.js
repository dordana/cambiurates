$(document).ready(function() {
    $('.collection_container select').select2({
        minimumResultsForSearch: Infinity
    });

    var $sterling = $('#currency1');
    var $currency = $('#currency2');
    var $currencies = $('#select_currency');

    $(document).on('change', '.currency_options select', function (e) {
        modifyValue($sterling, e);
    });

    $(document).on('keyup change', '.number input', function (e) {
        //key up
        if (e.which === 38) {
            e.preventDefault();

            modifyValue($(this), e);
            return;
        }

        if (e.which === 40) {
            e.preventDefault();

            modifyValue($(this), e);
            return;
        }

        modifyValue($(this), e);
    });

    function modifyValue(field, event) {

        //if field doesn't exists, return
        if (field.length == 0) return;

        var rate = $currencies.find('option:selected').attr('data-rate');
        var rate_symbol = $currencies.val();

        var val = parseInt(field.val(), 10);


        if (field.val().indexOf('0') === 0) {
            field.val(field.val().substring(1));
        }

        if (isNaN(val) || val < 0) {
            field.val(0);
        } else if (event != undefined && typeof event != false && event.type == 'click') {
            if (event.target.className == 'up' && val < collectionCashLimit) {
                field.val(val + 1);
            } else if (event.target.className == 'down' && val > 0) {
                field.val(val - 1);
            }
        }

        if ($(field).attr('name') == 'sterling') {
            $currency.val(parseFloat(rate * parseFloat(field.val())).toFixed(2)).css('color', 'black');
            $sterling.css('color', 'black');
        } else {
            $sterling.val(parseFloat(field.val() / rate).toFixed(2));
        }

        if (parseFloat($sterling.val()) > collectionCashLimit) {
            $sterling.css('color', 'red');
        } else if (parseFloat($sterling.val()) < collectionMinOrder) {
            $sterling.css('color', 'red');
        }

        $("label[for='currency2']").html(rate_symbol + ":");

    }
});