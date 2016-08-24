var Currency = (function () {

    // Keep this variable private inside this closure scope
    var currencies = window['currencies'];

    var currency = function(sterlingAmount, currency) {
        return parseFloat(currencies[currency] * parseFloat(sterlingAmount)).toFixed(2);
    };

    var sterling = function(currencyAmount, currency) {
        return parseFloat(currencyAmount / currencies[currency]).toFixed(2);
    };

    return {
        sterling: sterling,
        currency: currency
    }
})();
