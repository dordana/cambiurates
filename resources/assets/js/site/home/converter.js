function roundNumber(num, dec) {
    return Math.round(num*Math.pow(10,dec))/Math.pow(10,dec);
}

$(document).ready(function () {
    $('.currency-converter [name="currency"]').ezMark();
    $('.currency-converter [name="type"]').ezMark({radioCls:'ez-checkbox', selectedCls:'ez-checked'});
    $('.currency-converter select').select2({
        minimumResultsForSearch: Infinity
    });

    var $select = $('.currency-converter select');
    var $selectedCurrency = $select.find(':selected');
    var $type = $('input[name="currency"]');
    var $receivable = $('input[name="type"]');
    var $amountFrom = $('#amount_from');
    var $amountTo = $('#amount_to');
    var $rate = $('#rate');
    var $labelAmountFrom = $('#label_amount_from');
    var $labelAmountTo = $('#label_amount_to');
    var $dataID = $select.find('input.data-id');
    var $dataBuy = $select.find('input.data-buy');
    var $dataSell = $select.find('input.data-sell');
    var $warning = $('p.cash_warning');
    var $form = $('#homepage_form');
    var mode = 'buy';

    calculateBuy();

    $type.change(function() {
        $(this).val() == 'buy' ? calculateBuy() : calculateSell();
        mode = $(this).val();

        $amountFrom.val('');
        $amountTo.val('');

        if (mode == 'sell') {
            $amountTo.attr('readonly', true);
            $('#collection').hide();
            $('#delivery').hide();
            calculateSell();
        }

        if (mode == 'buy') {
            $amountTo.attr('readonly', false);
            $('#collection').show();
            $('#delivery').show();
            calculateBuy();
        }
    });

    $receivable.change(function() {
        generateSubmitUrl();
    });

    $select.change(function() {
        $selectedCurrency = $(this).find(':selected');
        mode == 'buy' ? calculateBuy('from') : calculateSell('from');
    });

    $amountFrom.focus(function () {
        $(this).val('');
    });

    $amountFrom.keyup(function (e) {
        mode == 'buy' ? calculateBuy('from') : calculateSell('from');
    });

    $amountTo.keyup(function (e) {
        mode == 'buy' ? calculateBuy('to') : calculateSell('to');
    });

    $form.submit(function(e) {
        var $receive = $('input:radio[name="type"]:checked');

        if ($receive.val() == 'delivery') {
            if ($amountFrom.val() > cash_limit) {
                warning('The maximum insured cash per home delivery is &pound;' + cash_limit + '.<br/>For larger amounts please make multiple orders.<br/>', '', 'cash');
                return false;
            }
        } else {
            if ($amountFrom.val() > cash_limit) {
                if (cash_limit == 3500) {
                    warning('Cash orders are limited to &pound;' + cash_limit + ', for larger orders, please <a href="/contact/">contact</a> the branch to reserve', '', 'cash');
                } else {
                    warning('Cash orders are limited to &pound;', cash_limit, 'cash');
                }
                return false;
            }
        }

        return true;
    });

    function calculateBuy(input) {
        input = (input == 'undefined' ? 'from' : input);

        $rate.html('Rate:' + $selectedCurrency.attr('data-sell'));
        $labelAmountFrom.html('GBP');
        $labelAmountTo.html($selectedCurrency.attr('data-code'));

        $dataID.val($select.val());
        $dataBuy.val($selectedCurrency.attr('data-buy'));
        $dataSell.val($selectedCurrency.attr('data-sell'));

        if ($amountFrom.val() != '') {
            if (input == 'from') {
                $amountTo.val(roundNumber($amountFrom.val() * $selectedCurrency.attr('data-sell'), 2));
            } else {
                $amountFrom.val(roundNumber($amountTo.val() / $selectedCurrency.attr('data-sell'), 2));
            }
        } else {
            $amountFrom.val('');
            $amountTo.val('');
        }

        generateSubmitUrl();
    }

    function calculateSell(input) {
        input = (input == 'undefined' ? 'from' : input);

        $rate.html('Rate:' + $selectedCurrency.attr('data-buy'));
        $labelAmountFrom.html($selectedCurrency.attr('data-code'));
        $labelAmountTo.html('GBP');

        $dataID.val($select.val());
        $dataBuy.val($selectedCurrency.attr('data-buy'));
        $dataSell.val($selectedCurrency.attr('data-sell'));

        if ($amountFrom.val() != '') {
            if (input == 'from') {
                $amountTo.val(roundNumber($amountFrom.val() / $selectedCurrency.attr('data-buy'), 2));
            } else {
                $amountFrom.val(roundNumber($amountTo.val() * $selectedCurrency.attr('data-buy'), 2));
            }
        } else {
            $amountFrom.val('');
            $amountTo.val('');
        }

        generateSubmitUrl();
    }

    function generateSubmitUrl() {
        var $receive = $('input:radio[name="type"]:checked');

        if (mode == 'sell') {
            $form.attr("action", "/buy-back-currency-by-post/");
        }

        if (mode == 'buy') {
            if ($receive.val() == 'delivery') {
                $form.attr("action", "/foreign-currency-delivery/details/");
            } else {
                $form.attr("action", "/foreign-currency-collection/branches/");
            }
        }
    }

    function warning(text, limit, type) {
        if (type == 'cash') {
            $warning.html(text + limit).hide().fadeIn(500);//.fadeOut(10000);
        }
        else {
            if ($warning.length < 1) {
                $warning.html(text + limit).hide().fadeIn(500);//.fadeOut(10000);
            } else {
                $warning.html(text + limit).hide().fadeIn(500);//.fadeOut(10000);
            }
        }
    }

    $('.slides').owlCarousel({
        animateOut: 'fadeOut',
        autoplay:true,
        loop:true,
        items:1,
        autoWidth:true
    });
});