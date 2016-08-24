$(document).ready(function(){
    $('input.readonly').on('keypress',function(e){
        e.preventDefault();
    });

    var euroDollarsOnly = $('#eurodollaronly').val() == 1 ? true : false,
        special = new Date(),
        today = new Date(),
        tomorrow = new Date(),
        next_day = new Date(),
        now = new Date(),
        flag = false,
        flag2 = false,
        time_limit = 18;

    tomorrow.setDate(tomorrow.getDate() + 1);
    next_day.setDate(next_day.getDate() + 2);

    $('#collection_date').click(function() {
        flag = false;
        flag2 = false;
    });

    var disableWeekendClosedOffices = function(date) {
        if (euroDollarsOnly) {
            time_limit = 18;
        } else {
            time_limit = 13;
        }

        for (i = 0; i < bankHolidays.length; i++) {
            var d = new Date(bankHolidays[i].holiday_date);

            if (date.getDate() == d.getDate() && date.getMonth() == d.getMonth() && date.getFullYear() == d.getFullYear()){
                special.setDate(date.getDate() + 1);
                if (special.getDay() == 6) {
                    special.setDate(special.getDate() + 1);
                }

                if (special.getDay() == 0) {
                    special.setDate(special.getDate() + 1);
                }
                return [false, ""];
            }
        }


        if ($('#branch_provider').val() == 1 || $('#branch_provider').val() == 5 || $('#branch_provider').val() == 8) {

            if ($('#branch_provider').val() == 1) {

                // if current day is not Saturday or Sunday and current hour is before time_limit variable, enable current day
                if (
                    currentHour < time_limit &&
                    date.getDate() == now.getDate() &&
                    date.getMonth() == now.getMonth() &&
                    date.getFullYear() == now.getFullYear() &&
                    now.getDay() < 6 &&
                    now.getDay() > 0
                ) {
                    return [true, ""];
                }

                // if current day is Friday, Saturday or Sunday, enable next first Monday
                if (
                    (now.getDay() == 5 || now.getDay() == 6 || now.getDay() == 0) &&
                    date.getDay() == 1 &&
                    date > now &&
                    flag == false
                ) {
                    flag = true;
                    return [true, ""];
                }

                // if day is not Saturday or Sunday, enable next day after current day
                if (date.getDay() != 6 && date.getDay() != 0 && date < tomorrow && date > now) {
                    return [true, ""];
                }

                return [false, ""];

            } else {

                // if current hour is before time_limit variable, enable current day
                if (
                    currentHour < time_limit &&
                    date.getDate() == now.getDate() &&
                    date.getMonth() == now.getMonth() &&
                    date.getFullYear() == now.getFullYear()
                ) {
                    return [true, ""];
                }

                // enable next day after current day
                if (date < tomorrow && date > now) {
                    return [true, ""];
                }

                return [false, ""];
            }

        } else if ($('#branch_provider').val() == 2) {
            if (date < now) {
                return [false, ""];
            }

            if (euroDollarsOnly) {

                if ((currentHour < 16 || (currentHour == 16 && currentMinutes < 30))) {
                    if ((now.getDay() == 6 || now.getDay() == 0) && date.getDay() == 1 && flag == false) {
                        flag = true;
                        return [true, ""];
                    }

                    if (date.getDate() == tomorrow.getDate() && date.getDay() != 0) {
                        return [true, ""];
                    }

                } else {
                    //skip monday on saturday after 16.30 because of sunday
                    if (now.getDay() == 6 && date.getDate() == next_day.getDate()) {
                        return [false, ""];
                    }
                }

            } else {
                //skip monday on saturday for other currencies because of sunday
                if (now.getDay() == 6 && date.getDate() == next_day.getDate()) {
                    return [false, ""];
                }
            }

            if (now.getDay() == 0 && date.getDay() == 1) {
                return [false, ""];
            }

            if ((now.getDay() == 6 || now.getDay() == 0) && date.getDay() == 2 && flag2 == false) {
                flag2 = true;
                return [true, ""];
            }

            if (now.getDay() == 5 && date.getDay() == 1 && flag == false) {
                flag = true;
                return [true, ""];
            }

            if (date.getDate() == next_day.getDate() && date.getDay() != 0) {
                return [true, ""];
            }

            if (date.getDate() == special.getDate() && date.getMonth() == special.getMonth() && date.getFullYear() == special.getFullYear() && special.getDate() != now.getDate()) {
                return [true, ""];
            }

            return [false, ""];

        } else if ($('#branch_provider').val() == 4 || $('#branch_provider').val() == 3) {

            if (euroDollarsOnly) {
                if (currentHour < 13 && date.getDate() == now.getDate() && date.getMonth() == now.getMonth() && date.getFullYear() == now.getFullYear() && now.getDay() < 6 && now.getDay() > 0) {
                    return [true, ""];
                }

                if (currentHour >= 13 && date.getDate() == tomorrow.getDate() && date.getMonth() == tomorrow.getMonth() && date.getFullYear() == tomorrow.getFullYear() && now.getDay() < 5 && now.getDay() > 0) {
                    return [true, ""];
                }

                if ((currentHour >= 13 && now.getDay() == 5) || (now.getDay() == 6 || now.getDay() == 0)) {
                    var next_monday = new Date(now.getTime());
                    if (now.getDay() == 5) {
                        next_monday.setDate(now.getDate() + 3);
                    } else if (now.getDay() == 6) {
                        next_monday.setDate(now.getDate() + 2);
                    } else if (now.getDay() == 0) {
                        next_monday.setDate(now.getDate() + 1);
                    }

                    if (date.getDate() == next_monday.getDate() && date.getMonth() == next_monday.getMonth() && date.getFullYear() == next_monday.getFullYear()) {
                        return [true, ""];
                    }
                }

                if (date.getDate() == special.getDate() && date.getMonth() == special.getMonth() && date.getFullYear() == special.getFullYear() && special.getDate() != now.getDate()) {
                    return [true, ""];
                }

                return [false, ""];

            } else {

                var allowDate = new Date(now.getTime());
                switch (now.getDay()) {
                    case 1:
                    case 2:
                    case 3:
                        allowDate.setDate(now.getDate()+2);
                        break;
                    case 4:
                        allowDate.setDate(now.getDate()+4);
                        break;
                    case 5:
                        allowDate.setDate(now.getDate()+4);
                        break;
                    case 6:
                        allowDate.setDate(now.getDate()+3);
                        break;
                    case 0:
                        allowDate.setDate(now.getDate()+2);
                        break;
                }

                if (date.getDate() == special.getDate() && date.getMonth() == special.getMonth() && date.getFullYear() == special.getFullYear() && special.getDate() != now.getDate()) {
                    return [true, ""];
                }

                if (date.getDate() != allowDate.getDate()){
                    return [false, ""];
                }else{
                    return [true, ""];
                }
            }
        }
    }

    $("#collection_date").datepicker({
        dateFormat: "dd/mm/yy",
        firstDay: 1,
        minDate: today,
        beforeShowDay: disableWeekendClosedOffices,
        onSelect: function(str) {
            var s = str.split('/');
            var d = new Date();
            d.setFullYear(parseInt(s[2]), parseInt(s[1]) - 1, parseInt(s[0]));
            if (euroDollarsOnly) {
                $('#collection_time').val('Ready for collection');
            } else {
                var datestr = s[2] + '-' + s[1] + '-' + s[0];
                if (datestr == $('#current_date').val() && (parseInt($('#current_time').val()) >= 9 || (parseInt($('#current_time')) == 8 && parseInt($('#currentMinutes')) > 30)) && parseInt($('#current_time').val()) <= 13) {
                    $('#collection_time').val('5.30pm');
                } else {
                    $('#collection_time').val('3pm');
                }
            }
        }
    });

    $("#collection_date").focus();

    $(".submit").on('click',function( event ) {
        if($('#full-address').hasClass('invisible') && $('input[name="postcode"]').val() != '') {
            event.preventDefault();
            $('.find-address').effect( 'pulsate',2000);
        }
    });


    var orderForm = $('#orderform');
    orderForm.submit(function(e) {
        if(!orderForm[0].checkValidity()) {
            orderForm.find(':submit').click();
        } else {
            $('.light-green-btn.submit').val('Loading...').attr('disabled', 'disabled');
        }
    });

    if ($('[data-toggle="popover"]').length > 0) {
        $('[data-toggle="popover"]').webuiPopover({'trigger': 'hover'});
    }
  
});