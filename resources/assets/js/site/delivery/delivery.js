$(document).ready(function(){
    var method_arr = [],
        cashcard_del = $('#cashandcard_del'),
        card_del = $('#card_del'),
        del_cost = $('.del_cost').find('em');

    var updateCashCurrency = function() {
        var amountSterling = parseFloat($('.order-cash .amount_from').val());
        var currency = $('.order-cash select option:selected').data('code');
        $('.order-cash .amount_to').val(Currency.currency(amountSterling, currency));
    }

    var updateCashSterling = function() {
        var amountCurrency = parseFloat($('.order-cash .amount_to').val());
        var currency = $('.order-cash select option:selected').data('code');
        $('.order-cash .amount_from').val(Currency.sterling(amountCurrency, currency));
    }

    var updateCardCurrency = function() {
        var amountSterling = parseFloat($('.order-card .amount_from').val());
        var currency = $('.order-cash select option:selected').data('code');
        $('.order-card .amount_to').val(Currency.currency(amountSterling, currency));
    }

    var updateCardSterling = function() {
        var amountCurrency = parseFloat($('.order-card .amount_to').val());
        var currency = $('.order-cash select option:selected').data('code');
        $('.order-card .amount_from').val(Currency.sterling(amountCurrency, currency));
    }

    $('.order-cash .amount_from').keyup(function() {
        updateCashCurrency();
    });

    $('.order-cash select').change(function() {
        updateCashCurrency();
    });

    $('.order-cash .amount_to').keyup(function() {
        updateCashSterling();
    });

    $('.order-card .amount_from').keyup(function() {
        updateCardCurrency();
    });

    $('.order-card select').change(function() {
        updateCardCurrency();
    });

    $('.order-card .amount_to').keyup(function() {
        updateCardSterling();
    });

    $(document).on('delivery.picker.selected', function(e) {
        var str = e.date;
        
        var s = str.split('/');
        var d = new Date();
        d.setFullYear(parseInt(s[2]), parseInt(s[1]) - 1, parseInt(s[0]));

        if (d.getDay() == 6) {
            $('#is_saturday_delivery').attr('checked', true);
            $('#is_saturday_delivery').parent().addClass('checkbox_checked');
            selected_saturday_delivery = true;
            return;
        }

        $('#is_saturday_delivery').attr('checked', false);
        $('#is_saturday_delivery').parent().removeClass('checkbox_checked');
    })

    DeliveryPicker.create( $("#delivery_date1") );

    function updateTotal(checked) {
        var saturday = 0,
            cost = 0,
            checked = typeof checked !== 'undefined' ? checked : false,
            html = '';
        if (checked) {
            saturday = 2;
        }

        // order total
        if (0 < $('#free_delivery_limit').val()) {
            cost = 5;
        }

        html = (cost + saturday) == 0 ? 'FREE' : (cost + saturday).toString();
        del_cost.html(html);
    }
});
