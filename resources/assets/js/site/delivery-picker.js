var DeliveryPicker = (function () {
    var dates = window['disabledDeliveryDates'];

    var create = function($el) {
        $el.datepicker({
            dateFormat: "dd/mm/yy",
            firstDay: 1,
            minDate: new Date(),
            beforeShowDay: function(date) {
                if (date.getDay() == 0){
                    return [false, ""];
                }

                for(var i in dates) {
                    var mom = moment(dates[i], "YYYY-MM-DD");
                    if (mom.isSame(date, ["year", "month", "day"])) {
                        return [false, ""];
                    }
                }

                return [true, ""];
            },
            onSelect: function(str) {
                $.event.trigger({
                    type: "delivery.picker.selected",
                    date: str
                });
            }
        });
    };

    return {
        create: create,
    }
})();
