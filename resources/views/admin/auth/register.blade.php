@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">{{ isset($oUser) ? 'Update User' : 'Create new User' }}</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ isset($oUser) ? route('user-update') : route('user-register') }}">
                        {!! csrf_field() !!}


                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-2 control-label" for="email">E-Mail Address</label>

                            <div class="col-md-10">
                                <input type="email" class="form-control" name="email" id="email" value="{{ isset($oUser) ? $oUser->email : old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('cambiu_id') ? ' has-error' : '' }}">
                            <label class="col-md-2 control-label" for="cambiu_id">Exchange Id</label>

                            <div class="col-md-10">

                                <select  name="cambiu_id" id="cambiu_id" data-placeholder="Choose a exchange..." class="chosen-select col-md-6" style="width:100%;" tabindex="4">
                                    <option value="">Select</option>
                                </select>

                                @if ($errors->has('cambiu_id'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('cambiu_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-2">
                                <a href="{{ url('admin/users') }}" class="btn btn-white" type="submit">Cancel</a>
                                <button type="submit" class="btn btn-primary">
                                    {{isset($oUser) ? 'Update' : 'Create'}}
                                </button>
                            </div>
                        </div>

                        <input type="hidden" class="form-control" name="name" id="name" value="">

                    </form>
                </div>
                <div class="modal hide" id="pleaseWaitDialog" data-backdrop="static" data-keyboard="false">
                    <div class="modal-header">
                        <h1>Please Wait</h1>
                    </div>
                    <div class="modal-body">
                        <div id="ajax_loader">
                            <img src="{!! asset('images/ellipsis.gif') !!}" style="display: block; margin-left: auto; margin-right: auto;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')

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

        apigClient.exchangesGet({city : 'London', country : 'UK'}, {}, {})
            .then(function(result){
                    $.each(result.data, function( index, value ) {
                        modal.modal('hide');
                        select.append("<option value='"+value.id+"'>"+value.name+"</option>");
                        if(parseInt(old_id) == parseInt(value.id)) {
                            select.val(value.id);
                        }
                    });
                    select.trigger("chosen:updated");
                    if(parseInt(select.val()) > 0) {
                        select.trigger('change');
                    }
                    // Add success callback code here.
            }).catch( function(result){
                alert('API remoting web service problem');
            });

        select.change(function () {
            $('#name').val(select.find('option:selected').text());
        })


        apigClient.exchangesGet({city : 'London', country : 'UK'}, {}, {})
                .then(function(result){
                    console.log(result);
                }).catch( function(result){
            alert('API remoting web service problem');
        });

    </script>
@endsection
