@extends('admin.layouts.master')
@section('title', 'Exchange Rate')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-content forum-container">

                <div class="search-form">
                    <form action="" method="get">
                        <div class="input-group" style="width: 100%">
                            <input type="text" autocomplete="off" placeholder="Filter by symbol ..." name="search" style="width: 100%" class="form-control input-lg" value="{{\Illuminate\Support\Facades\Input::get('search')}}">
                        </div>

                    </form>
                </div>

                <div class="hr-line-dashed"></div>
                @if(env('APP_ENV') == 'local' || \Auth::user()->role == 'user')
                    <h4>Change type</h4>
                    <div id="change-type-wrapper">
                        <div class="btn-group" role="group" aria-label="...">
                            <button type="button" value="percent" class="btn btn-primary change-type">Margin(%)</button>
                            <button type="button" value="fixed" class="btn btn-default change-type">Flat</button>
                        </div>
                        <div class="btn-group pull-right" role="group" aria-label="...">
                            <button type="button" class="btn btn-warning update-all">Update all</button>
                        </div>
                    </div>
                @endif
                <div class="hr-line-dashed"></div>
                <div class="table-responsive" data-first-pos="{{ (isset($oUserOnlyRates->first()->pos)) ? $oUserOnlyRates->first()->pos : 0 }}">
                    <table id="currency-table" class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded">
                        <tr>
                            <th style="min-width: 6px;">Add</th>
                            <th>Symbol</th>
                            <th>Margin/Flat</th>
                            <th>Updated at</th>
                            <th>Buy</th>
                            <th style="display:none">Buy Rate</th>
                            <th>Sell</th>
                            <th style="display:none">Sell Rate</th>
                            <th class="text-center footable-last-column" style="min-width: 10%;">Action</th>
                        </tr>
                        @foreach($oUserOnlyRates as $iIdx => $oExchangeRate)
                            <tr id="rate_{{ $oExchangeRate->id }}" class="footable-{{$iIdx % 2 == 0 ? 'odd' : 'even'}}"
                                data-symbol="{{ $oExchangeRate->symbol }}"
                                data-id="{{ $oExchangeRate->id }}"
                                data-rate="{{ $oExchangeRate->exchangeRate }}">
                                <td>
                                    @if(++$iIdx === ($oUserOnlyRates->count()))
                                        <button id="more-currency" class="btn btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                    @endif
                                </td>
                                <td class="currency-symbol">
                                    {{ $oExchangeRate->symbol }}
                                </td>
                                @if(env('APP_ENV') == 'local' || \Auth::user()->role == 'user')
                                    <td>
                                        <input type="radio" name="change_type_{{$oExchangeRate->id}}" class="rate-type"
                                               {{ $oExchangeRate->type_sell === 'percent' || $oExchangeRate->type_sell === 'disabled' ? 'checked' : '' }} value="percent"/>Margin(%)
                                        <input type="radio" name="change_type_{{$oExchangeRate->id}}" class="rate-type"
                                               {{ $oExchangeRate->type_sell === 'fixed' ? 'checked' : '' }} value="fixed"/>Flat
                                        Rate
                                    </td>
                                @endif
                                <td>
                                    {{ $oExchangeRate->updatedAt }}
                                </td>
                                <td>
                                    <input type="text"
                                           pattern="[0-9]"
                                           title="Numbers only"
                                           value="{{ sprintf('%01.6f', $oExchangeRate->buy) }}"
                                           class="form-control buy col-md-4 rate-value-input"
                                           name="buy[]" data-name="buy"
                                           style="width:50%;">
                                    @if($oExchangeRate->type_buy == 'percent')
                                        <i class="percent-sign">%</i>
                                    @endif
                                </td>
                                <td class="buy_rate" data-original="{{ $oExchangeRate->getBuyRateAttribute() }}" style="display:none">
                                    {{ $oExchangeRate->getBuyRateAttribute() }}
                                </td>
                                <td>
                                    <input type="text"
                                           pattern="[0-9]"
                                           title="Numbers only"
                                           value="{{ sprintf('%01.6f', $oExchangeRate->sell) }}"
                                           class="form-control margin-rate-input col-md-4 rate-value-input"
                                           name="sell[]" data-name="sell"
                                           style="width:50%;">
                                    @if($oExchangeRate->type_sell == 'percent')
                                        <i class="percent-sign">%</i>
                                    @endif
                                </td>
                                <td class="sell_rate" data-original="{{ $oExchangeRate->getSellRateAttribute() }}" style="display:none">
                                    {{ $oExchangeRate->getSellRateAttribute() }}
                                </td>
                                <td class="text-center footable-last-column">
                                    <input type="hidden" name="id[]" data-name="id" value="{{ $oExchangeRate->id }}">
                                    <div class="btn-group">
                                        <button class="btn-warning btn btn-sm single-row-update">
                                            Update
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="9">
                                <form class="pick-currency-form" style="display:{{ ($oUserOnlyRates->count() === 0) ? "block" : "none" }}">
                                    <div class="form-group">
                                        <select name="pick-currency" id="pick-currency" style="width: 100%" data-placeholder="Pick up a currency">
                                            <option value=""></option>
                                            @foreach($aCurrencies as $oCurrency)
                                                <option data-id="{{ $oCurrency->id }}" value="{{ $oCurrency->symbol }}">[{{ $oCurrency->symbol }}] {{ ucfirst(strtolower($oCurrency->title)) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        {{--<tr>--}}
                            {{--<td colspan="8" class="footable-visible">--}}
                                {{--@if($aExchangeRates->render() != '')--}}
                                    {{--{{ $aExchangeRates->appends(\Illuminate\Support\Facades\Input::except(array('page')))->render() }}--}}
                                {{--@endif--}}
                            {{--</td>--}}
                        {{--</tr>--}}
                    </table>
                </div>

                @if(empty($oUserOnlyRates))
                    <div class="alert alert-info alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        You don't have any exchangeRates!
                    </div>
                @endif
            </div>
        </div>

    </div>
    <table style="display: none;" id="copy-change-table">
        @foreach($oNoUserRates as $iIdx => $oExchangeRate)
            <tr style="display:none" class="footable-{{$iIdx % 2 == 0 ? 'odd' : 'even'}}"
                data-symbol="{{ $oExchangeRate->symbol }}"
                data-id="{{ $oExchangeRate->id }}"
                data-rate="{{ $oExchangeRate->exchangeRate }}">
                <td>
                    <button id="more-currency" class="btn btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                </td>
                <td class="currency-symbol">
                    {{ $oExchangeRate->symbol }}
                </td>
                @if(env('APP_ENV') == 'local' || \Auth::user()->role == 'user')
                    <td>
                        <input type="radio" name="change_type_{{$oExchangeRate->id}}" class="rate-type"
                               {{ $oExchangeRate->type_sell === 'percent' || $oExchangeRate->type_sell === 'disabled' ? 'checked' : '' }} value="percent"/>Margin(%)
                        <input type="radio" name="change_type_{{$oExchangeRate->id}}" class="rate-type"
                               {{ $oExchangeRate->type_sell === 'fixed' ? 'checked' : '' }} value="fixed"/>Flat
                        Rate
                    </td>
                @endif
                <td>
                    {{ $oExchangeRate->updatedAt }}
                </td>
                <td>
                    <input type="text"
                           pattern="[0-9]"
                           title="Numbers only"
                           value="{{ sprintf('%01.6f', $oExchangeRate->buy) }}"
                           class="form-control buy col-md-4 rate-value-input"
                           name="buy[]" data-name="buy"
                           style="width:50%;">
                    @if($oExchangeRate->type_buy != 'fixed')
                        <i class="percent-sign">%</i>
                    @endif
                </td>
                <td class="buy_rate" data-original="{{ $oExchangeRate->getBuyRateAttribute() }}" style="display:none">
                    {{ $oExchangeRate->getBuyRateAttribute() }}
                </td>
                <td>
                    <input type="text"
                           pattern="[0-9]"
                           title="Numbers only"
                           value="{{ sprintf('%01.6f', $oExchangeRate->sell) }}"
                           class="form-control margin-rate-input col-md-4 rate-value-input"
                           name="sell[]" data-name="sell"
                           style="width:50%;">
                    @if($oExchangeRate->type_sell != 'fixed')
                        <i class="percent-sign">%</i>
                    @endif
                </td>
                <td class="sell_rate" data-original="{{ $oExchangeRate->getSellRateAttribute() }}" style="display:none">
                    {{ $oExchangeRate->getSellRateAttribute() }}
                </td>
                <td class="text-center footable-last-column">
                    <input type="hidden" name="id[]" data-name="id" value="{{ $oExchangeRate->id }}">
                    <div class="btn-group">
                        <button class="btn-warning btn btn-sm single-row-update">
                            Update
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
    </table>
@stop

@section('footer')
    <script type="text/javascript">
        $(document).ready(function () {

            var currency_table = $("#currency-table");
            var currency_picker = $("#pick-currency");

            currency_table.on('click', '#more-currency', function(e){
                $(".pick-currency-form").show();
                currency_picker.val('').trigger('change');
                $(this).remove();
            });

            currency_picker.select2().on("change", function (e) {

                //Do not do anything if we do not have value :)
                if($(this).val() == ''){
                    return;
                }

                //Which one currency we have?
                var symbol = $(this).val();

                //Now remove it from the select
                $("option[value=" + symbol + "]").remove();

                //Move this rate from copy-change table to currency table
                var tr_new = $("#copy-change-table tr[data-symbol="+symbol+"]").clone();
                tr_new.css('display', '').attr('id', 'rate_' + tr_new.data('id'));
                $("table#currency-table tr:last").before(tr_new);

                //After the movement we need to delete the select
                $(".pick-currency-form").hide();

//                apigClient.ratesGet({city: 'London', country: 'UK', type: 'reference'}, {})
//                        .then(function (result) {
//                        }).catch(function (result) {
//                    var errorMsg =  (result) ? result : 'Try refreshing the page or contact your web dev';
//                    swal('Ups!', 'API remoting web service problem. Message: ' + errorMsg, 'warning');
//                });
            });

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            //Local level (row level) changing type
            currency_table.on('change',  '.rate-type', function () {

                var row = $(this).parents('tr').first();
                //Perform a calculation
                applyCalculationForCurrency(row);
                
                //Set percent after the rate change input
                setPercentIfMargin(row);
            });
            
            //Global level changing type
            $("#change-type-wrapper").on('click', '.change-type',function () {

                //Set all them inactive
                $('.change-type').attr('class', 'btn btn-default change-type');
                $(this).attr('class', 'btn btn-primary change-type');
                var change_type = $(this).val();

                //We change all local rates
                $('#currency-table input.rate-type').each(function(key, val){
                    $(val).prop('checked', ($(val).val() == change_type));
                });

                //Perform a calculation
                triggerItForAnyRow(function(row){
                    applyCalculationForCurrency(row);
                    setPercentIfMargin(row);
                });
            });

            //It checks if there is a margin set it percent sign after the input
            function setPercentIfMargin(row){

                var change_type = row.find('.rate-type:checked').val();
                if(change_type == 'percent'){

                    if(row.find('.percent-sign').length == 0){
                        row.find("input[name^=buy]").after('<i class="percent-sign">%</i>');
                        row.find("input[name^=sell]").after('<i class="percent-sign">%</i>');
                    }
                }else{
                    row.find('.percent-sign').remove();
                }
            }

            currency_table.on('focusout', '.rate-value-input', function(){
                    if ($(this).val() == '') {
                        $(this).val('0.000000');
                    }
            }).on('change keyup','.rate-value-input',function (event) {

                    var row = $(this).parents('tr').first();

                    applyCalculationForCurrency(row);
            });

            function applyCalculationForCurrency(row){
                var buy_val = parseFloat(row.find('input[name^=buy]').val());
                var sell_val = parseFloat(row.find('input[name^=sell]').val());
                if(isNaN(buy_val)) {
                    buy_val = 0;
                }
                if(isNaN(sell_val)) {
                    sell_val = 0;
                }

                var change_type = row.find('.rate-type:checked').val();
                var exchange_rate = parseFloat(row.data('rate'));
                if(change_type == 'percent') {
                    calculateBuyRate(row, buy_val, exchange_rate, false);
                    calculateSellRate(row, sell_val, exchange_rate, false);
                } else if (change_type == 'fixed') {
                    calculateBuyRate(row , buy_val , exchange_rate , true);
                    calculateSellRate(row , sell_val , exchange_rate , true);
                }

                //See is there any differences
                //For Sell
                var sell = row.find('.sell_rate');
                var sell_origin = sell.attr('data-original');
                var sell_current = sell.text();
                //For Buy
                var buy = row.find('.buy_rate');
                var buy_origin = buy.attr('data-original');
                var buy_current = buy.text();

                //Do it
                if(buy_origin != buy_current || sell_origin != sell_current){
                    somethingIsGoingOn(row);
                }else{
                    nothingIsGoingOn(row);
                }
            }

            function calculateBuyRate(row, value, exchange_rate, flatRate) {
                var field = row.find('.buy_rate');
                if(flatRate) {
                    field.text(value.toFixed(6));
                } else {
                    field.text( (exchange_rate * ((value + 100) / 100)).toFixed(6) );
                }
            }

            function calculateSellRate(row, value, exchange_rate, flatRate) {

                var field = row.find('.sell_rate');
                if(flatRate) {
                    field.text(value.toFixed(6));
                } else {
                    field.text( (exchange_rate * ((100 - value) / 100)).toFixed(6) );
                }
            }

            function somethingIsGoingOn(row) {
                row.css('background-color','lightyellow').addClass('triggered');
            }


            //Do not have funny with this one! I had no choice
            function nothingIsGoingOn(row) {
                row.css('background-color','').removeClass('triggered');
            }

            //Multiple rows update
            $(".update-all").on('click', function(){

                //Update all rows
                triggerItForAnyRow(currencyRowUpdate)
            });

            currency_table.on('click', '.single-row-update', function(){
                currencyRowUpdate($(this).parents('tr').first())
            });

            function currencyRowUpdate(row){
                var rate_sell = parseFloat(row.find('input[name^=sell]').val());
                var rate_buy = parseFloat(row.find('input[name^=buy]').val());
                var currency = row.find('.currency-symbol').text().trim();
                var data = {};
                var change_type = row.find('.rate-type:checked').val();
                row.find('[data-name]').each(function () {
                    data[$(this).data('name')] =   $(this).val();
                });

                data.type_sell = data.type_buy = change_type;

                row.find('.update-indicator').remove();
                var update_button = row.find('.single-row-update');
                update_button.html('<i class="fa fa-circle-o-notch fa-spin"></i> Updating').prop('disabled',true);

                //We need to update the API to Cambiu first. More info at http://redmine.zenlime.com/redmine/issues/997
                sendUpdateRateRequest(currency, {sell:rate_sell,buy:rate_buy}, change_type, function(){
                    $.ajax({
                        method: "POST",
                        url: "trade/update",
                        data: data,
                        success: function(result) {
                            if(result.success === true) {
                                update_button.prop('disabled',false).html('Update');
                                update_button.after('<p style="position: absolute; top:28px; left:8px; font-size:11px; font-weight: 900" class="text text-success update-indicator">Done <i class="fa fa-check" aria-hidden="true"></i></p>');
                                if(row.hasClass('triggered')){
                                    row.css('background-color','rgba(59, 198, 30, 0.11)').removeClass('triggered');
                                }
                                //Change original value
                                changeOriginalRateWithCurrent(row);
                            }
                        }, error: function (xhr, status, error) {
                            var data = JSON.parse(xhr.responseText);
                            for(var i in data){
                                for(var ii in data[i]){
                                    swal('Warning!', data[i], 'warning');
                                }
                            }
                            that.prop('disabled',false).html('Update');
                        }
                    });
                });
            }
        });

        //Cambiu API
        var name = '{{ \Auth::user()->name }}';
        var nearest_station = '{{ \Auth::user()->nearest_station }}';
        var rates_policy = '{{ \Auth::user()->rates_policy }}';
        var chain = '{{ \Auth::user()->chain }}';

        function sendUpdateRateRequest(currency, rates, type, callMe) {

            var body = {
                currency: currency
            };

            //if we do margin provide "type: reference" param http://redmine.zenlime.com/redmine/issues/1086
            if(type == 'percent'){
                body.type = 'reference'
            }

            if(rates_policy == 'chain') {
                body.chain = chain;
            } else {
                body.name = name;
//                if(nearest_station) {
//                    body.nearest_station = nearest_station;
//                }
            }
            for(var i in rates){
                body[i] = rates[i];
            }
            apigClient.ratesPost({city: 'London', country: 'UK'}, body, {})
                    .then(function (result) {
                        if (result.data.status == 'ok' && callMe) {
                            //The promise is done so call the provided function
                            callMe();
                        }else{
                            var data = result.data.errors;
                            for(var i in data){
                                for(var ii in data[i]){
                                    //We just throw the error
                                    throw data[i];
                                }
                            }
                        }
                    }).catch(function (result) {
                        var errorMsg =  (result) ? result : 'Try refreshing the page or contact your web dev';
                        swal('Ups!', 'API remoting web service problem. Message: ' + errorMsg, 'warning');
                    });
        }

        $("input[name=search]").on('keyup mouseup', function(){
            var term = $(this).val();
            if(term.length > 0){
                $("tr[id^=rate_]").each(function(key, val){
                    var symbol = $(val).data('symbol');
                    if(symbol.toLowerCase().indexOf(term.toLowerCase()) < 0){
                        $(val).hide();
                    }else{
                        $(val).show();
                    }
                });
            }else{
                $("tr[id^=rate_]").show();
            }
        });

        function triggerItForAnyRow(callMe){
            $("tr[id^=rate_]").each(function(key, val){
                callMe($(val));
            })
        }

        function changeOriginalRateWithCurrent(row){
            var buy_rate = row.find(".buy_rate");
            var sell_rate = row.find(".sell_rate");
            buy_rate.attr('data-original', buy_rate.text());
            sell_rate.attr('data-original', sell_rate.text());
        }

        //Show save before go msg: Read more on: http://redmine.zenlime.com/redmine/issues/1124
        window.onbeforeunload = function(){
            if($(".triggered").length > 0){
                return 'Are you sure?';
            }
        };
    </script>
@endsection