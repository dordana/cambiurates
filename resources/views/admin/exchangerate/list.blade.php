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
                <div class="table-responsive" data-first-pos="{{ $aExchangeRates->first()->pos }}">
                    <table class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded">
                        <tr>
                            <th>Symbol</th>
                            <th>Updated at</th>
                            <th>Margin/Flat</th>
                            <th>Buy</th>
                            <th>Buy Rate</th>
                            <th>Sell</th>
                            <th>Sell Rate</th>
                            <th class="text-center footable-last-column" style="min-width: 10%;">Action</th>
                        </tr>
                        @foreach($aExchangeRates->all() as $iIdx => $oExchangeRate)
                        <tr class="footable-{{$iIdx % 2 == 0 ? 'odd' : 'even'}}" id="rate_{{ $oExchangeRate->id }}" data-symbol="{{ $oExchangeRate->symbol }}" data-rate="{{ $oExchangeRate->exchangeRate }}">
                            <td class="currency-symbol">
                                {{ $oExchangeRate->symbol }}
                            </td>
                            <td>
                                {{ $oExchangeRate->updatedAt }}
                            </td>
                            @if(env('APP_ENV') == 'local' || \Auth::user()->role == 'user')
                                <td>
                                    <input type="radio" name="change_type_{{$oExchangeRate->id}}" class="rate-type change-type" {{ $oExchangeRate->type_sell === 'percent' || $oExchangeRate->type_sell === 'disabled' ? 'checked' : '' }} value="percent"/>Margin(%)
                                    <input type="radio" name="change_type_{{$oExchangeRate->id}}" class="rate-type change-type" {{ $oExchangeRate->type_sell === 'fixed' ? 'checked' : '' }} value="fixed"/>Flat Rate
                                </td>
                            @endif

                            <td>
                                <input type="text"
                                       pattern="[0-9]"
                                       title="Numbers only"
                                       value="{{ sprintf('%01.6f', $oExchangeRate->buy) }}"
                                       class="form-control buy col-md-4 rate-value-input"
                                       name="buy[]" data-name="buy"
                                       style="width:50%;">
                            </td>
                            <td class="buy_rate">
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
                            </td>
                            <td class="sell_rate">
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
                            <td colspan="7" class="footable-visible">
                                @if($aExchangeRates->render() != '')
                                    {{ $aExchangeRates->appends(\Illuminate\Support\Facades\Input::except(array('page')))->render() }}
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>

                @if(empty($aExchangeRates->all()))
                    <div class="alert alert-info alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        You don't have any exchangeRates!
                    </div>
                @endif
            </div>
        </div>

    </div>
@stop

@section('footer')
    <script type="text/javascript">
        $(document).ready(function () {

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $('.visible-switch')
                .bootstrapSwitch()
                .on('switchChange.bootstrapSwitch', function(event, state) {
                   var elem = $('#vs_' + $(this).data('id')).val(state ? 1 : 0);
                    somethingIsGoingOn(elem.parents('tr').first());
                });

            $('.rate-type')
                .on('change',function () {

                    var row = $(this).parents('tr').first();
                    somethingIsGoingOn(row);
                    applyCalculationForCurrency(row);
                });

            $('.rate-value-input')
                .focusout(function(){
                    if ($(this).val() == '') {
                        $(this).val('0.000000');
                    }
                })
                .on('change keyup',function (event) {

                    var row = $(this).parents('tr').first();

                    if(event.type == 'keyup') {
                        somethingIsGoingOn(row);
                    }
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

                var exchange_rate = parseFloat(row.data('rate'));
                var select = row.find('.change-type:checked').val();
                if(select == 'percent') {
                    calculateBuyRate(row, buy_val, exchange_rate, false);
                    calculateSellRate(row, sell_val, exchange_rate, false);
                } else if (select == 'fixed') {
                    calculateBuyRate(row , buy_val , exchange_rate , true);
                    calculateSellRate(row , sell_val , exchange_rate , true);
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

            $(".single-row-update").on('click', function(){
                var that = $(this);
                var row = that.parents('tr').first();
                var rate_sell = parseFloat(row.find('.sell_rate').text());
                var rate_buy = parseFloat(row.find('.buy_rate').text());
                var currency = row.find('.currency-symbol').text().trim();
                var data = {};
                row.find('[data-name]').each(function () {
                    data[$(this).data('name')] =   $(this).val();
                });

                data.type_sell = data.type_buy = row.find('.change-type:checked').val();

                if(data.type_buy == 'disabled' || rate_buy < 0){
                    rate_buy = 0;
                }

                if( data.type_sell == 'disabled' || rate_sell < 0){
                    rate_sell = 0;
                }

                that.parent().find('.update-indicator').remove();
                that.html('<i class="fa fa-circle-o-notch fa-spin"></i> Updating').prop('disabled',true);

                //We need to update the API to Cambiu first. More info at http://redmine.zenlime.com/redmine/issues/997
                sendUpdateRateRequest(currency, {sell:rate_sell,buy:rate_buy}, function(){
                    $.ajax({
                        method: "POST",
                        url: "trade/update",
                        data: data,
                        success: function(result) {
                            if(result.success === true) {
                                that.prop('disabled',false).html('Update');
                                that.after('<p style="position: absolute; top:28px; left:8px; font-size:11px; font-weight: 900" class="text text-success update-indicator">Done <i class="fa fa-check" aria-hidden="true"></i></p>');
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
            });
        });

        //Cambiu API
        var name = '{{ \Auth::user()->name }}';
        var nearest_station = '{{ \Auth::user()->nearest_station }}';
        var rates_policy = '{{ \Auth::user()->rates_policy }}';
        var chain = '{{ \Auth::user()->chain }}';

        function sendUpdateRateRequest(currency, rates, callMe) {

            var body = {
                currency: currency
            };

            if(rates_policy == 'chain') {
                body.chain = chain;
            } else {
                body.name = name;
//                if(nearest_station) {
//                    body.nearest_station = nearest_station;
//                }
            }
            console.log(rates);
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
    </script>
@endsection