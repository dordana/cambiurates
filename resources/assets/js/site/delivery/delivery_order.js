$(document).ready(function(){
  var method_arr = [],
      eurocard_total = 0,
      dollarcard_total = 0,
      globalcard_total = 0,
      card_warning_delivery = $('#card_delivery .cash_warning'),
      card_warning = $('#card_order .cash_warning'),
      cash_warning = $('#cash_order .cash_warning');

  $('.order_list').on('click', 'a.remove', function (e) {
    e.preventDefault();
    var method = $(this).parent().prev().find('.data-method').val(),
        item = method_arr.indexOf(method),
        amount_from = parseFloat($(this).siblings('input[name="amount_from[]"]').val()),
        amount_to = parseFloat($(this).siblings('input[name="amount_to[]"]').val()),
        currency = $(this).siblings('.data-id').val();

    if (item > -1) {
      method_arr.splice(item, 1);
    }

    if (method == 'cash') {
      cash_total -= amount_from;
    }
    else {
      if(currency == 35) {
        dollarcard_total -= amount_to;
      }
      else if(currency == 12) {
        eurocard_total -= amount_to;
      }
      else {
        globalcard_total -= amount_to;
      }
    }
  });

  function limit_warning(text, limit, type) {
    if (type == 'cash') {
      cash_warning.html(text + limit).hide().fadeIn(500);//.fadeOut(10000);
    }
    else {
      if (card_warning.length < 1){
        card_warning_delivery.html(text + limit).hide().fadeIn(500);//.fadeOut(10000);
      }else{
        card_warning.html(text + limit).hide().fadeIn(500);//.fadeOut(10000);
      }
    }
  }

});