$(document).ready(function() {

  function get_calendar(el_id, options) {
    var next_day_enabled = options.next_day_enabled,
        delivery_cutoff_time_other = options.delivery_cutoff_time_other,
        delivery_cutoff_time_eur_usd = options.delivery_cutoff_time_eur_usd,
        debit_card = options.debit_card,
        selected_saturday_delivery = false,
        tomorrow = new Date(),
        next_day = new Date();

    tomorrow.setDate(tomorrow.getDate() + 1);
    next_day.setDate(next_day.getDate() + 2);

    var now = new Date();
    now.setFullYear(setFullYear_y,setFullYear_m,setFullYear_d);
    now.setHours(setHours);
    now.setMinutes(setMinutes);

    var disableDays = function(date) {
      // disable sundays
      if (date.getDay() == 0){
        return [false, ""];
      }

      // disable bank holidays
      for(i =0; i<bank_holidays.length; i++){
        d = new Date(bank_holidays[i].holiday_date);

        if (date.getDate() == d.getDate() && date.getMonth() == d.getMonth() && date.getFullYear() == d.getFullYear()){
          return [false, ""];
        }
      }
      return [true, ""];
    };


    var min_date = new Date();
    min_date.setFullYear(min_year,min_month,min_day);

    min_date = min_date_calc(min_date, bank_holidays);

    var min_date_year = min_date.getFullYear()
    var min_date_month = min_date.getMonth() + 1;
    if (min_date_month < 10) min_date_month = '0' + min_date_month;
    var min_date_date = min_date.getDate();
    if (min_date_date < 10) min_date_date = '0' + min_date_date;

    function min_date_calc(min_date, bank_holidays) {
      var min_date_year = min_date.getFullYear()
      var min_date_month = min_date.getMonth() + 1;
      if (min_date_month < 10) min_date_month = '0' + min_date_month;
      var min_date_date = min_date.getDate();
      if (min_date_date < 10) min_date_date = '0' + min_date_date;

      var min_date_str = min_date_year + '-' + min_date_month + '-' + min_date_date;

      for (i = 0; i < bank_holidays.length; i++) {
        if (min_date_str == bank_holidays[i].holiday_date) {
          min_date.setDate(min_date.getDate() + 1);
          if (min_date.getDay() == 0) {
            min_date.setDate(min_date.getDate() + 1);
          }
          min_date_calc(min_date, bank_holidays);
        }
      }
      return min_date;
    }

    var selDate = min_date_date+'/'+min_date_month+'/'+min_date_year,
        isSatDelivery = $('#is_saturday_delivery');

    isSatDelivery.on('change',function(){
      if ($(this).attr('checked') == 'checked'){
        selected_saturday_delivery = true;
        $('#delivery_date1').val(satDate);
      }
      else {
        // If satDate and minDate/selDate are the same next available delivery date should be 2 days ahead.
        if(satDate == selDate) {
          var nextAvailableDateNotSat = new Date(min_date_year,min_date_month-1,parseInt(min_date_date,10)+2);
          nextAvailableDateNotSat = min_date_calc(nextAvailableDateNotSat,bank_holidays);
          var m = parseInt(nextAvailableDateNotSat.getMonth(),10) + 1,
              month = nextAvailableDateNotSat.getMonth() < 10 ? '0' + m : m,
              day = nextAvailableDateNotSat.getDate() < 10 ? '0' + nextAvailableDateNotSat.getDate() : nextAvailableDateNotSat.getDate();
          selDate = day +'/'+month+'/'+nextAvailableDateNotSat.getFullYear();
        }
        selected_saturday_delivery = false;
        $('#delivery_date1').val(selDate);
      }
    });

    var defaultDate = min_date_date + '/' + min_date_month + '/' + min_date.getFullYear();

    // is default min date is equal to Sat - make sure checkbox is selected
    if(defaultDate == satDate) {
      isSatDelivery.attr('checked', true);
      isSatDelivery.parent().addClass('checkbox_checked');
    }

    $("#" + el_id).datepicker({
      onSelect: function(dateText, inst) {
        var d = new Date(inst.selectedYear, inst.selectedMonth, inst.selectedDay);
        if (d.getDay() == 6) {
          $('#is_saturday_delivery').attr('checked', true);
          $('#is_saturday_delivery').parent().addClass('checkbox_checked');

          selected_saturday_delivery = true;

        } else {
          $('#is_saturday_delivery').attr('checked', false);
          $('#is_saturday_delivery').parent().removeClass('checkbox_checked');
        }

          if(d.getDay() == 1) {
            $('#monday_del').show();
          }
          else {
              $('#monday_del').hide();
          }
      },
      dateFormat: "dd/mm/yy",
      firstDay: 1,
      minDate : sebMinDate,
      beforeShowDay: disableDays
    });


    var min_date_date = min_date.getDate();
    if (min_date_date < 10) min_date_date = '0' + min_date_date;

    var min_date_month = min_date.getMonth() + 1;
    if (min_date_month < 10) min_date_month = '0' + min_date_month;

    $("#" + el_id).val(defaultDate);

  }

  get_calendar('delivery_date1', {
    next_day_enabled: nextDayEnabled,
    delivery_cutoff_time_other: deliveryCutoffTimeOther,
    delivery_cutoff_time_eur_usd: deliveryCutoffTimeEurUsd,
    debit_card: 1
  });
});
