var apigClientFactory = require('aws-api-gateway-client');

var apigClient = apigClientFactory.newClient({
    accessKey: 'AKIAIY6K5IKEXG7EGC6A',
    secretKey: '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',
    region: 'us-west-2',
    invokeUrl: 'https://cz471val2d.execute-api.us-west-2.amazonaws.com'
});


var pathTemplate = '/staging/rates';
var method = 'GET';
var additionalParams = {
    headers: {
        city: 'London',
        country: 'UK',
        type: 'reference'
    },
    queryParams: {
        city: 'London',
        country: 'UK',
        type: 'reference'
    }
};

var mysql = require('mysql');
var connection = mysql.createConnection({
    host: '127.0.0.1',
    user: 'root',
    password: '1q2w3e4r',
    database: 'cambiurates',
    multipleStatements: 'true'
});

console.log(processInfoPrint('Start'));

var ratesQuery = '';
var visibleRates = [];
apigClient.invokeApi({}, pathTemplate, method, additionalParams, {})
    .then(function (result) {

        // Add success callback code here.
        var rates = result.data[0].rates;

        for (var index in rates) {

            var rate = rates[index];
            if (rate.buy == null) {
                continue;
            }

            visibleRates.push(rate.currency);
            ratesQuery += ratesQueryBuilder(rate.currency, rate.buy, rate.updated_at); // use buy as base rate ?
        }

        updateQuery(ratesQuery,visibleRatesQueryBuilder(visibleRates));

    }).catch(function (result) {

});

function ratesQueryBuilder(symbol, rate, updated_at) {
    var updated_date = new Date(updated_at).toISOString().substring(0, 19).replace('T', ' ');
    return 'UPDATE exchange_rates set exchange_rate = "' + rate + '", updated_at = "' + updated_date + '", is_visible = 1 WHERE symbol ="' + symbol + '";'
}

function visibleRatesQueryBuilder(rates) {

    var rates = rates.map(function(rates){
        return '"' + rates + '"';
    }).join();

    return 'UPDATE exchange_rates set is_visible = 0 WHERE symbol NOT IN ('+rates+');' +
           'UPDATE exchange_rates set is_visible = 1 WHERE symbol IN ('+rates+');';
}

function updateQuery(ratesQuery,visibleRatesQuery) {

    connection.connect();

    connection.query(ratesQuery, function (error, results, fields) {
        if (error) throw error;

        var countRows = 0;
        for (var index in results) {
            countRows += results[index].affectedRows;
        }
        console.log('Affected ' + countRows + ' rates');
    });

    connection.query(visibleRatesQuery, function (error, results, fields) {
        if (error) throw error;
    });

    connection.end();

    console.log(processInfoPrint('End'));

}

function processInfoPrint(status) {
    var currentdate = new Date();
    return status + " : " + currentdate.getDate() + "/"
        + (currentdate.getMonth() + 1) + "/"
        + currentdate.getFullYear() + " @ "
        + currentdate.getHours() + ":"
        + currentdate.getMinutes() + ":"
        + currentdate.getSeconds();
}


