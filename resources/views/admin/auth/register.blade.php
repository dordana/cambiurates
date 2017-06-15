@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">{{ isset($oUser) ? 'Update User' : 'Create new User' }}</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ isset($oUser) ? route('user-update') : route('user-register') }}">
                        {!! csrf_field() !!}
                        <input type="hidden" class="form-control" name="name" id="name" value="{{ old('name', '') }}">
                        <input type="hidden" class="form-control" name="cambiu_id" id="name" value="{{ old('cambiu_id', '') }}">
                        @if(old('cambiu_id'))
                            @if(old('chain'))
                                <input type="hidden" class="form-control" name="chain" id="chain" value="{{ old('chain', '') }}">
                            @else
                                <input type="hidden" class="form-control" name="nearest_station" id="nearest_station" value="{{ old('nearest_station', '') }}">
                            @endif
                            <input type="hidden" class="form-control" name="rates_policy" id="rates_policy" value="{{ old('rates_policy', '') }}">
                        @endif

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
                                    <option value=""></option>
                                    @foreach($chains as $chain)
                                        <option value="{{ $chain->origin_id }}" {{ (old('cambiu_id') == $chain->origin_id && !old('chain'))  ? "selected='selected'" : "" }} data-name="{{ $chain->name }}"> {{ $chain->name }}</option>
                                    @endforeach
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
                                    <option value=""></option>
                                    @foreach($exchanges as $exchange)
                                        <option value="{{ $exchange->origin_id }}"
                                                {{ (old('cambiu_id') == $exchange->origin_id && !old('chain')) ? 'selected="selected"' : '' }}
                                                data-name="{{ $exchange->name }}"
                                                data-rates_policy="{{ $exchange->rates_policy }}"
                                                data-nearest_station="{{ $exchange->nearest_station }}"
                                        >{{ $exchange->name }}, {{ $exchange->address }} ({{ $exchange->country->code }})</option>
                                    @endforeach
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
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script>

        //Defining default vars
        var exchanges = {!! $exchangesJson !!};
        var chainSelect = $('#select-chain');
        var exchangeSelect = $('#select-exchange');

        //This is either exchange_id or chain_id
        var cambiu_id = null;

        //User's vars
        var rates_policy = '<?php echo e(old('rates_policy')); ?>';

        //When the chain select changed
        chainSelect.change(function () {

            //First we need to reset exchange select
            exchangeSelect.val('').trigger('chosen:updated');

            //Then get the selected option
            var option = chainSelect.find('option:selected');
            var chainName = option.data('name');

            //Update the cambiu_id for that user
            update_cambiu_id(option.val());

            var name = $('#name');
            name.val(chainName);

            //Deleting old inputs
            delete_input_if_exists('#nearest_station');
            //Change the rates_policy with chain
            delete_input_if_exists('#rates_policy');
            name.after('<input type="hidden" class="form-control" name="rates_policy" id="rates_policy" value="chain">');

            //Change the chain with chain name
            delete_input_if_exists('#chain');
            name.after('<input type="hidden" class="form-control" name="chain" id="chain" value="'+chainName+'">');
        });

        //When the exchange select changed
        exchangeSelect.change(function () {

            //First we need to reset chain select
            chainSelect.val('').trigger('chosen:updated');

            //Then get the selected option
            var option = exchangeSelect.find('option:selected');

            //Update the cambiu_id for that user
            update_cambiu_id(option.val());

            var name = $('#name');
            name.val(option.data('name'));
            var station = option.data('nearest_station');
            var rates_policy = option.data('rates_policy');

            //Deleting old inputs
            delete_input_if_exists('#nearest_station');
            delete_input_if_exists('#rates_policy');
            delete_input_if_exists('#chain');

            //Add the new once where needed
            var isUnique = (isExchangeUnique(name.val()));
            if(station && isUnique === false) {

                //When the exchange is NOT unique set a nearest station
                name.after('<input type="hidden" class="form-control" name="nearest_station" id="nearest_station" value="'+station+'">');
            }
            if(rates_policy){
                name.after('<input type="hidden" class="form-control" name="rates_policy" id="rates_policy" value="'+rates_policy+'">');
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

        function update_cambiu_id(id){
            cambiu_id = id;
            $('input[name=cambiu_id]').val(id);
        }

        function delete_input_if_exists(selector){
            var input = $(selector);
            if(input.length > 0){
                input.remove();
            }
        }
    </script>
@endsection
