var apigClientFactory = require('aws-api-gateway-client');

var apigClient = apigClientFactory.default.newClient({
    accessKey: 'AKIAIY6K5IKEXG7EGC6A',
    secretKey: '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',
    region: 'us-west-2',
    invokeUrl: 'https://cz471val2d.execute-api.us-west-2.amazonaws.com'
});

var pathTemplate = '/production/chains';
var method = 'GET';
var additionalParams = {
    headers: {},
    queryParams: {
        country: 'UK'
    }
};

apigClient.invokeApi({}, pathTemplate, method, additionalParams, {})
    .then(function (result) {
        //Return the response data
        console.log(JSON.stringify(result.data));
    }).catch(function (result) {

});
