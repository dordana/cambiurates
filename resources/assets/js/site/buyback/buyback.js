$(document).ready(function() {

    var margin = 0;
    $('#add_currency').click(function (e) {
        e.preventDefault();
        //margin = margin + 66;
        $('#total').css('margin-top',margin);
        $('#add_currency').css('margin-top',margin + 10);
        var form = $('.currency_form:last').clone();

        form.find('input:text').val('0');
        form.find('.data-id').val('0');
        form.find('.data-buy').val('1');
        form.find('span').text('UK Pounds');
        form.appendTo('#currency_form');

        calculateBuyBackByPost();

    });

    $('.amount').focus(function(){
        $(this).val('');
    });

    $(document).on('click','#buyback .select span',function(){

        hideSelectFields();

        var ul = $(this).next();

        ul.slimScroll({
            height: '250px',
            width: '215px',
            alwaysVisible: true,
            railVisible: true,
            disableFadeOut: true,
            size: '10px',
            start: 'top',
            distance: '3px',
            opacity : 0.8,
            color: '#fff',
            wheelStep: 25

        });
        $('.slimScrollDiv').css('z-index',100);
        ul.show();
    });

    $(document).on('click','#buyback .select ul li',function(){

        var parent = $(this).parents('.currency_form').first();
        parent.find('.data-buy').val($(this).data('buy'));
        parent.find('span').text($(this).text());
        hideSelectFields();
    });

    $(document).click(function(event) {
        if(!$(event.target).closest('#buyback .select').length &&
            !$(event.target).is('#buyback .select')) {
            if($('#buyback .select').is(":visible")) {
                hideSelectFields();
            }
        }
    });

    $(document).on('change keyup','.amount',function(){
        calculateBuyBackByPost();
    });

    $(document).on('DOMSubtreeModified','#buyback .select span',function(){
        calculateBuyBackByPost();
    });

    function hideSelectFields() {
        $('#buyback .currency_form ul').each(function(){
            $(this).slimScroll({destroy: true}).hide();
        });
    }

    function calculateBuyBackByPost() {

        var total = 0;
        var sum = 0;
        $('.currency_form').each(function () {
            sum = parseFloat($(this).find('.amount').val()) / parseFloat($(this).find('.data-buy').val());
            if(isNaN(sum)) {
                sum = 0;
            }
            total += sum;
        });

        $('.converted').val("£" + total.toFixed(2));

    }

});