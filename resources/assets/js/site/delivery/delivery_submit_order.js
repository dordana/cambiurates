$('button.submit').on('click', function() {
    if ($('#full-address').hasClass('invisible')) {
        $('.find-address button').effect('pulsate', 2000);
    }

    var address1 = $('#address_name_1'),
        address1data = address1.data('full-address');

    //if(address1data.length && (address1data.match(/(\d)/gi) && address1.val() != address1data)) {
    //    alert("Please enter a door number");
    //    return false;
    //}
});

function postOrder()
{

    var email = $('#email').val(),
        f_name = $('#first_name').val(),
        l_name =$('#last_name').val(),
        phone = $('#phone').val(),
        postcode = $('#postcode').val(),
        address_name_1 = $('#address_name_1').val();
    $.ajax({
        url:rooturl + 'foreign-currency-delivery/check_client/',
        type:"POST",
        dataType:"json",
        data:{
            email:email,
            f_name:f_name,
            l_name:l_name,
            phone:phone,
            postcode:postcode,
            address_name_1:address_name_1
        }
    }).done(function(data){
        var result = JSON.parse(data);
        if(result === true)
        {
            $('select#select').show();$('select#select1').show().removeClass('hidden');
            $('#btn_order').show();
            $('select#select').removeClass('hidden').css;
            $('label#reasons').show();
            $('label#funds').show();
            $( "#dialog" ).dialog({
                modal:true,
                width:600,
                height:300,
                //buttons: {
                //   ORDER: function() {$(this).dialog("close");}
                //}
            });
              $('select').on('change',function()
              {
                  var selected = $(this).find(':selected').val();

                  if(selected === 1)
                  {
                      return false;

                  }
                    $('#dialog_submit').show().removeClass('hidden');
              });
            $('#dialog_submit').on('click',function()
            {
                var input1 = $('select#select').find(':selected').val();
                var input2 = $('select#select1').find(':selected').val();

                if(input1 == 0 || input2 == 0)
                {
                    alert('Please fill the required fields');
                    return false;
                }
                var selected_reason = $("<input>")
                    .attr("type", "hidden")
                    .attr("name", "reasons").val(input1);
                var source_of_funds = $("<input>")
                    .attr("type", "hidden")
                    .attr("name", "funds").val(input2);
                $('#orderform').attr("action", rooturl + "foreign-currency-delivery/confirm_order/");
                $('#orderform').append($(selected_reason));
                $('#orderform').append($(source_of_funds));
                $('#orderform').submit();

            });

        }
        else
        {
            var input = $("<input>")
            .attr("type", "hidden")
            .attr("name", "reasons").val("0");
            var input1 = $("<input>")
                .attr("type", "hidden")
                .attr("name", "funds").val("0");
            $('#orderform').attr("action", rooturl + "foreign-currency-delivery/confirm_order/");
            $('#orderform').append($(input));
            $('#orderform').append($(input1));
            $('#orderform').submit();
        }
    }).fail(function(xhr, status, error)
    {
        var err = eval("(" + xhr.responseText + ")");
        alert(err.Message);
    });
}