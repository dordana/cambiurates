var apigClientFactory = require('aws-api-gateway-client');

var apigClient = apigClientFactory.default.newClient({
    accessKey: 'AKIAIY6K5IKEXG7EGC6A',
    secretKey: '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',
    region: 'us-west-2',
    invokeUrl: 'https://cz471val2d.execute-api.us-west-2.amazonaws.com'
});


var pathTemplate = '/production2/rates';
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

apigClient.invokeApi({}, pathTemplate, method, additionalParams, {})
    .then(function (result) {

        console.log(JSON.stringify(result.data));

    }).catch(function (result) {

});


