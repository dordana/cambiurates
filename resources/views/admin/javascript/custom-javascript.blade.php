<script type="text/javascript" src="{!! asset('scripts/site/amazon/apiGateway-js-sdk/lib/axios/dist/axios.standalone.js') !!}"></script>
<script type="text/javascript" src="{!! asset('scripts/site/amazon/apiGateway-js-sdk/lib/CryptoJS/rollups/hmac-sha256.js') !!}"></script>
<script type="text/javascript" src="{!! asset('scripts/site/amazon/apiGateway-js-sdk/lib/CryptoJS/rollups/sha256.js') !!}"></script>
<script type="text/javascript" src="{!! asset('scripts/site/amazon/apiGateway-js-sdk/lib/CryptoJS/components/hmac.js') !!}"></script>
<script type="text/javascript" src="{!! asset('scripts/site/amazon/apiGateway-js-sdk/lib/CryptoJS/components/enc-base64.js') !!}"></script>
<script type="text/javascript" src="{!! asset('scripts/site/amazon/apiGateway-js-sdk/lib/url-template/url-template.js') !!}"></script>
<script type="text/javascript" src="{!! asset('scripts/site/amazon/apiGateway-js-sdk/lib/apiGatewayCore/sigV4Client.js') !!}"></script>
<script type="text/javascript" src="{!! asset('scripts/site/amazon/apiGateway-js-sdk/lib/apiGatewayCore/apiGatewayClient.js') !!}"></script>
<script type="text/javascript" src="{!! asset('scripts/site/amazon/apiGateway-js-sdk/lib/apiGatewayCore/simpleHttpClient.js') !!}"></script>
<script type="text/javascript" src="{!! asset('scripts/site/amazon/apiGateway-js-sdk/lib/apiGatewayCore/utils.js') !!}"></script>
<script type="text/javascript" src="{!! asset('scripts/site/amazon/apiGateway-js-sdk/apigClient.js') !!}"></script>
<script>
    var select = $('#cambiu_id');
    var old_id = '{{ old('cambiu_id') }}';
    var modal = $('#pleaseWaitDialog');
    modal.modal();

    var apigClient = apigClientFactory.newClient({
        accessKey: '{{ env('ACCESS_KEY') }}',
        secretKey: '{{ env('SECRET_KEY') }}',
        region: '{{ env('REGION') }}'
    });
</script>
@yield('footer')
@yield('javascript')