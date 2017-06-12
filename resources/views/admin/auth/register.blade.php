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
                            <label class="col-md-2 control-label" for="cambiu_id">Chain</label>

                            <div class="col-md-10">

                                <select id="select-chain" data-placeholder="Choose a chain..." class="chosen-select col-md-6" style="width:100%;" tabindex="4">
                                    <option value="">Select</option>
                                </select>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('cambiu_id') ? ' has-error' : '' }}">
                            <label class="col-md-2 control-label" for="cambiu_id">Exchange</label>

                            <div class="col-md-10">

                                <select  id="select-exchange" data-placeholder="Choose a exchange..." class="chosen-select col-md-6" style="width:100%;" tabindex="4">
                                    <option value="">Select</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-2">
                                <a href="{{ route('home') }}" class="btn btn-white" type="submit">Cancel</a>
                                <button type="submit" class="btn btn-primary">
                                    {{isset($oUser) ? 'Update' : 'Create'}}
                                </button>
                            </div>
                        </div>

                        <input type="hidden" class="form-control" name="name" id="name" value="">
                        <input type="hidden" class="form-control" name="cambiu_id" id="name" value="">

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        showPleaseWait();
        var old_id = '<?php echo e(old('cambiu_id')); ?>';
        var rates_policy = '<?php echo e(old('rates_policy')); ?>';
        console.log(rates_policy);
        var chainSelect = $('#select-chain');
        var chains;
        var exchangeSelect = $('#select-exchange');
        var exchanges;
        /*
        console.log(apigClient.countriesGet({}, {}, {}));
        */
        function processChains(result) {
            chains = result.data;
            $.each(result.data, function( index, value ) {
                hidePleaseWait();
                chainSelect.append("<option value='"+value.id+"' data-name='"+ value.name +"'>"+value.name+ "</option>");
                if(parseInt(old_id) == parseInt(value.id) && rates_policy == 'chain') {
                    chainSelect.val(value.id);
                }
            });
            chainSelect.trigger("chosen:updated");
            if(parseInt(chainSelect.val()) > 0) {
                chainSelect.trigger('change');
            }
        }

        function processExchanges(result) {

            exchanges = result.data;
            $.each(result.data, function( index, value ) {
                hidePleaseWait();
                var address = value.address;
                if(value.chain_id != null) {
                    return;
                }
                exchangeSelect.append("<option value='"+value.id+"' data-name='"+ value.name +"' data-rates_policy='"+ value.rates_policy +"'  data-nearest_station='"+value.nearest_station+"'>"+value.name+ ((address.length > 0) ? "("+address+")" : "") + "</option>");
                if(parseInt(old_id) == parseInt(value.id) && rates_policy != 'chain') {
                    exchangeSelect.val(value.id);
                }
            });
            exchangeSelect.trigger("chosen:updated");
            if(parseInt(exchangeSelect.val()) > 0) {
                exchangeSelect.trigger('change');
            }
            // Add success callback code here.
        }

        apigClient.chainsGet({country : 'UK'}, {}, {})
            .then(processChains)
            .catch( function(result){
            swal('Ups!', 'API remoting web service problem. Try refreshing the page or contact your web dev', 'warning');
        });

        apigClient.chainsGet({country : 'ISR'}, {}, {})
                .then(processChains)
                .catch( function(result){
            swal('Ups!', 'API remoting web service problem. Try refreshing the page or contact your web dev', 'warning');
        });

        chainSelect.change(function () {

            //First we need to reset exchange select
            exchangeSelect.val('').trigger('chosen:updated');

            var option = chainSelect.find('option:selected');
            var chainName = option.data('name');

            //Update the cambiu_id
            $('input[name=cambiu_id]').val(option.val());

            var name = $('#name');
            name.val(chainName);

            var $rates_policy_input = $('#rates_policy');
            if($rates_policy_input.length > 0){
                $rates_policy_input.remove();
            }
            name.after('<input type="hidden" class="form-control" name="rates_policy" id="rates_policy" value="chain">');

            var $chain_input = $('#chain');
            if($chain_input.length > 0){
                $chain_input.remove();
            }
            name.after('<input type="hidden" class="form-control" name="chain" id="chain" value="'+chainName+'">');
        });

        apigClient.exchangesGet({country : 'UK'}, {}, {})
            .then(processExchanges)
            .catch( function(result){
                swal('Ups!', 'API remoting web service problem. Try refreshing the page or contact your web dev', 'warning');
            });
        apigClient.exchangesGet({country : 'ISR'}, {}, {})
            .then(processExchanges)
            .catch( function(result){
                swal('Ups!', 'API remoting web service problem. Try refreshing the page or contact your web dev', 'warning');
            });

        exchangeSelect.change(function () {
            //First we need to reset chain select
            chainSelect.val('').trigger('chosen:updated');

            var option = exchangeSelect.find('option:selected');

            //Update the cambiu_id
            $('input[name=cambiu_id]').val(option.val());

            var name = $('#name');
            name.val(option.data('name'));
            var station = option.data('nearest_station');
            var rates_policy = option.data('rates_policy');

            var $nearestStation = $('#nearest_station');
            if($nearestStation.length > 0){
                $nearestStation.remove();
            }

            var $rates_policy_input = $('#rates_policy');
            if($rates_policy_input.length > 0){
                $rates_policy_input.remove();
            }

            var $chain_input = $('#chain');
            if($chain_input.length > 0){
                $chain_input.remove();
            }
            var isUnique = (isExchangeUnique(name.val()));
            if(station && isUnique === false) {
                name.after('<input type="hidden" class="form-control" name="nearest_station" id="nearest_station" value="'+station+'">');
            }
            if(rates_policy){
                name.after('<input type="hidden" class="form-control" name="rates_policy" id="rates_policy" value="'+rates_policy+'">');
//                if(rates_policy == 'chain') {
//                    name.after('<input type="hidden" class="form-control" name="chain" id="chain" value="'+chain[0]["name"]+'">');
//                }
            }
        });


        function isExchangeUnique(name) {
            var counter = 0;
            for (var i = 0; i < exchanges.length; i++){
                // look for the entry with a matching `code` value
                if (exchanges[i].name == name){
                   counter++;
                }
            }
            if(counter > 1) {
                return false;
            }
            return true;
        }
    </script>
@endsection
