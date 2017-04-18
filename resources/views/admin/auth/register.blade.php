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
                                <a href="{{ route('home') }}" class="btn btn-white" type="submit">Cancel</a>
                                <button type="submit" class="btn btn-primary">
                                    {{isset($oUser) ? 'Update' : 'Create'}}
                                </button>
                            </div>
                        </div>

                        <input type="hidden" class="form-control" name="name" id="name" value="">

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        showPleaseWait();
        var chains;
        var exchanges;
        apigClient.chainsGet({city : 'London', country : 'UK'}, {}, {})
                .then(function(result){
                    chains = result.data;
                    // Add success callback code here.
                }).catch( function(result){
            swal('Ups!', 'API remoting web service problem. Try refreshing the page or contact your web dev', 'warning');
        });
        apigClient.exchangesGet({city : 'London', country : 'UK'}, {}, {})
            .then(function(result){
                    exchanges = result.data;
                    $.each(result.data, function( index, value ) {
                        hidePleaseWait();
                        var address = value.address;
                        var chain = false;
                        if(value.chain_id != null) {
                            chain = value.chain_id;
                        }
                        select.append("<option value='"+value.id+"' data-name='"+ value.name +"' data-rates_policy='"+ value.rates_policy +"' data-chain-id='"+ chain +"' data-nearest_station='"+value.nearest_station+"'>"+value.name+ ((address.length > 0) ? "("+address+")" : "") + "</option>");
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
                swal('Ups!', 'API remoting web service problem. Try refreshing the page or contact your web dev', 'warning');
            });

        select.change(function () {
            var name = $('#name');
            name.val(select.find('option:selected').data('name'));
            var station = select.find('option:selected').data('nearest_station');
            var rates_policy = select.find('option:selected').data('rates_policy');
            var chain_id = select.find('option:selected').data('chain-id');
            var chain;
            if(chain_id > 0) {
                chain  = (getChainById(chain_id));
            }
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
                if(rates_policy == 'chain') {
                    name.after('<input type="hidden" class="form-control" name="chain" id="chain" value="'+chain[0]["name"]+'">');
                }
            }
        });

        function getChainById(id) {
            return chains.filter(
                    function(data){ return data.id == id }
            );
        }

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
