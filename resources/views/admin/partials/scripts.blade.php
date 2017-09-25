<?php
    $environment = $app->environment();
    $sdk_path = "apiGateway-js-sdk";
    if( $environment === 'dev'){
        $sdk_path = "apiGateway-js-sdk-dev";
    }
?>

<script type="text/javascript" src="{!! asset('scripts/site/amazon/'.$sdk_path.'/lib/axios/dist/axios.standalone.js') !!}"></script>
<script type="text/javascript" src="{!! asset('scripts/site/amazon/'.$sdk_path.'/lib/CryptoJS/rollups/hmac-sha256.js') !!}"></script>
<script type="text/javascript" src="{!! asset('scripts/site/amazon/'.$sdk_path.'/lib/CryptoJS/rollups/sha256.js') !!}"></script>
<script type="text/javascript" src="{!! asset('scripts/site/amazon/'.$sdk_path.'/lib/CryptoJS/components/hmac.js') !!}"></script>
<script type="text/javascript" src="{!! asset('scripts/site/amazon/'.$sdk_path.'/lib/CryptoJS/components/enc-base64.js') !!}"></script>
<script type="text/javascript" src="{!! asset('scripts/site/amazon/'.$sdk_path.'/lib/url-template/url-template.js') !!}"></script>
<script type="text/javascript" src="{!! asset('scripts/site/amazon/'.$sdk_path.'/lib/apiGatewayCore/sigV4Client.js') !!}"></script>
<script type="text/javascript" src="{!! asset('scripts/site/amazon/'.$sdk_path.'/lib/apiGatewayCore/apiGatewayClient.js') !!}"></script>
<script type="text/javascript" src="{!! asset('scripts/site/amazon/'.$sdk_path.'/lib/apiGatewayCore/simpleHttpClient.js') !!}"></script>
<script type="text/javascript" src="{!! asset('scripts/site/amazon/'.$sdk_path.'/lib/apiGatewayCore/utils.js') !!}"></script>
<script type="text/javascript" src="{!! asset('scripts/site/amazon/'.$sdk_path.'/apigClient.js') !!}"></script>

@yield('footer')
@yield('javascript')
