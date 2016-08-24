$('document').ready(function () {
    var contact_form = $('#contact_form'),
        customer_service_content = $('#customer_service_content');

    $('select#service').on('change',generateSecondarySelect);

    function generateSecondarySelect(option) {

        contact_form.find('li').show();

        if($('#secondary').length) {$('#secondary').parent('li').remove();}
        if($('#card_digits').length) {$('#card_digits').parent('li').remove();}


        var selOption = $(':checked', option.currentTarget);

        var secondarySelectJson = [];

        if( selOption.data('secondary').length > 0) {

            secondarySelectJson = selOption.data('secondary');
        }
        else {
            return false;
        }


        var select = '<li><label for="secondary">Enquiry specifics / branch</label><select name="secondary" id="secondary">';
        for (var i in secondarySelectJson) {
            select += '<option value="'+secondarySelectJson[i]['id']+'" data-short=""'+secondarySelectJson[i]['short']+'"">'+secondarySelectJson[i]['name']+'</option>';
        }
        select += '</select></li>';


        $( "#service").parent("li").after( select );

        var selected = $('#service').find(":selected").data('short');

        if(selected == 'acefx_ppc' || selected == 'fp_ppc') {
            var digitInput = '<li class="card-digits"><label>Please enter last four digits of prepaid card number</label><input type="text" minlength="4" maxlength="4" name="card_digits" id="card_digits" placeholder="1234" required></li>';
            $('#secondary').parent('li').after(digitInput);
        }
    }

    contact_form.on( "change", "#secondary", function() {
        var cardDigits = $('.card-digits'),
            secondary_val = $(this).val();
        if (secondary_val == 'new_customer') {
            $('#card_digits').removeAttr('required');
            cardDigits.hide();
            customer_service_content.children().hide();
            contact_form.find('li').show();
        } else if($.inArray(secondary_val,['refunds','change_address']) != -1) {
            customer_service_content.children().hide();
            $(this).parent('li').nextAll().hide();
            customer_service_content.find('#'+secondary_val).show();
        }
        else {
            $('#card_digits').attr('required', 'required');
            cardDigits.show();
            contact_form.find('li').show();
            customer_service_content.children().hide();
        }
    });
});