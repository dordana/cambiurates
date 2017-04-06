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
    var apigClient = apigClientFactory.newClient({
        accessKey: '{{ env('ACCESS_KEY') }}',
        secretKey: '{{ env('SECRET_KEY') }}',
        region: '{{ env('REGION') }}'
    });
    function showPleaseWait() {
        var modalLoading = '<div class="modal" id="pleaseWaitDialog" data-backdrop="static" data-keyboard="false role="dialog">\
        <div class="modal-dialog">\
            <div class="modal-content">\
                <div class="modal-header">\
                    <h4 class="modal-title">Please wait...</h4>\
                </div>\
                <div class="modal-body">\
                    <div class="progress">\
                      <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar"\
                      aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%; height: 40px">\
                      </div>\
                    </div>\
                </div>\
            </div>\
        </div>\
    </div>';
        $(document.body).append(modalLoading);
        $("#pleaseWaitDialog").modal("show");
    }
    /**
     * Hides "Please wait" overlay. See function showPleaseWait().
     */
    function hidePleaseWait() {
        $("#pleaseWaitDialog").modal("hide");
    }
</script>

@yield('footer')
@yield('javascript')