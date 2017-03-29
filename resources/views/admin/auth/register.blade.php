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

                        <input type="text" class="form-control" name="name" id="name" value="">

                    </form>
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

        var apigClient = apigClientFactory.newClient({
            accessKey: 'AKIAIY6K5IKEXG7EGC6A',
            secretKey: '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',
            region: 'us-west-2'
        });

        apigClient.exchangesGet({city : 'London', country : 'UK'}, {}, {})
            .then(function(result){
                    $.each(result.data, function( index, value ) {
                        select.append("<option value='"+value.id+"'>"+value.name+"</option>");
                    });
                    select.trigger("chosen:updated");
                    // Add success callback code here.
            }).catch( function(result){
                alert('API remoting web service problem');
            });

        select.change(function () {
            console.log(select.find('option:selected').attr(''));
        })

    </script>
@endsection
