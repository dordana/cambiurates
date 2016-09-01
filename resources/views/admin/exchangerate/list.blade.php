@extends('admin.layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-content forum-container">

                <div class="search-form">
                    <form action="" method="get">
                        <div class="input-group">
                            <input type="text" placeholder="Search ..." name="search" class="form-control input-lg" value="{{\Illuminate\Support\Facades\Input::get('search')}}">
                            <div class="input-group-btn">
                                <button class="btn btn-lg btn-primary" type="submit">
                                    Search
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="hr-line-dashed"></div>
                <button id="apply" class="btn-green btn btn-sm" style="margin: 5px">Apply</button>
                <div class="table-responsive">
                    <table class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded">
                        <tr>
                            <th class="footable-first-column">
                                <input type="checkbox" name="check-all" class="i-checks check-all">
                            </th>
                            <th>Symbol</th>
                            <th>Title</th>
                            <th>Exchange Rate</th>
                            <th style="max-width: 30px">Buy</th>
                            <th style="max-width: 30px">Sell</th>
                            <th>Visible</th>
                            <th class="text-right footable-last-column">Action</th>
                        </tr>
                        @foreach($aUserExchangeRates as $iIdx => $userExchangeRate)
                            <tr class="footable-{{$iIdx % 2 == 0 ? 'odd' : 'even'}}" style="display: table-row; background-color: #e1ffe6">
                                <td class="check-mail footable-first-column">
                                    #
                                </td>
                                <td>
                                    {{ $userExchangeRate->exchangeRate->symbol }}
                                </td>
                                <td>
                                    {{ $userExchangeRate->exchangeRate->title }}
                                </td>
                                <td>
                                    {{ $userExchangeRate->exchangeRate->exchangeRate }}
                                </td>
                                <td>
                                    <input type="text"
                                           pattern="[0-9]"
                                           title="Numbers only"
                                           value="{{ $userExchangeRate->buy or 0 }}"
                                           class="form-control buy col-md-4"
                                           name="buy[]" data-name="buy"
                                           style="width:30%;"
                                            {{ (!$userExchangeRate->type_buy || $userExchangeRate->type_buy === 'disabled') ? 'disabled' : ''}}>
                                    <select name="buy_trade[]" data-name="trade_type" data-placeholder="Choose a trade type..." class="chosen-select col-md-6" style="width:40%;" tabindex="4">
                                        <option {{ $userExchangeRate->type_buy === 'disabled' ? 'selected' : '' }} value="disabled">Disabled</option>
                                        <option {{ $userExchangeRate->type_buy === 'percent' ? 'selected' : '' }} value="percent">Margin(%)</option>
                                        <option {{ $userExchangeRate->type_buy === 'fixed' ? 'selected' : '' }} value="flat_rate">Flat Rate</option>
                                    </select>
                                </td>
                                <td>

                                    <input type="text"
                                           pattern="[0-9]"
                                           title="Numbers only"
                                           value="{{ $userExchangeRate->sell or 0 }}"
                                           class="form-control margin-rate-input col-md-4"
                                           name="sell[]" data-name="sell"
                                           style="width:30%;"
                                            {{ (!$userExchangeRate->type_sell || $userExchangeRate->type_sell === 'disabled') ? 'disabled' : ''}}>
                                    <select name="sell_trade[]" data-name="trade_type" data-placeholder="Choose a trade type..." class="chosen-select col-md-6" style="width:40%;" tabindex="4">
                                        <option {{ ( $userExchangeRate->type_sell === 'disabled') ? 'selected' : '' }} value="disabled">Disabled</option>
                                        <option {{ ($userExchangeRate->type_sell === 'percent') ? 'selected' : '' }} value="percent">Margin(%)</option>
                                        <option {{ ($userExchangeRate->type_sell === 'fixed') ? 'selected' : '' }} value="flat_rate">Flat Rate</option>
                                    </select>
                                </td>
                                <td>
                                    <div class="flag-toggle-2">
                                        <label class="checkbox-inline">
                                            <input type="checkbox" class="visible-switch"
                                                   {{ ($userExchangeRate->visible == 1) ? 'checked' : '' }}
                                                   data-id="{{ $userExchangeRate->id }}"
                                                   data-toggle="toggle"
                                                   data-size="mini"
                                                   data-on-text="Visible"
                                                   data-off-text="Hidden"
                                            >
                                            <input type="hidden" data-name="visible" value="0" name="visible" id="vs_{{ $userExchangeRate->id }}">
                                        </label>
                                    </div>
                                </td>
                                <td class="text-right footable-last-column">
                                    <div class="btn-group">
                                        <button class="btn-warning btn btn-sm single-row-update">
                                            Update
                                        </button>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @foreach($aExchangeRates->all() as $iIdx => $oExchangeRate)
                        <tr class="footable-{{$iIdx % 2 == 0 ? 'odd' : 'even'}}" style="display: table-row;" id="rate_{{ $oExchangeRate->id }}">
                            <td class="check-mail footable-first-column">
                                <input type="checkbox" name="id[]" data-name="id" value="{{ $oExchangeRate->id }}" class="i-checks">
                            </td>
                            <td>
                                {{ $oExchangeRate->symbol }}
                            </td>
                            <td>
                                {{ $oExchangeRate->title }}
                            </td>
                            <td>
                                {{ $oExchangeRate->exchangeRate }}
                            </td>
                            <td>
                                <input type="text"
                                       pattern="[0-9]"
                                       title="Numbers only"
                                       value="0"
                                       class="form-control buy col-md-4"
                                       name="buy[]"
                                       data-name="buy"
                                       style="width:30%;"
                                       disabled="disabled">
                                <select name="buy_trade[]" data-name="buy_trade_type" data-placeholder="Choose a trade type..." class="chosen-select col-md-6" style="width:40%;" tabindex="4">
                                    <option selected="selected" value="disabled">Disabled</option>
                                    <option value="percent">Margin(%)</option>
                                    <option value="flat_rate">Flat Rate</option>
                                </select>
                            </td>
                            <td>
                                <input type="text"
                                       pattern="[0-9]"
                                       title="Numbers only"
                                       value="0"
                                       class="form-control margin-rate-input col-md-4"
                                       name="sell[]"
                                       data-name="sell"
                                       style="width:30%;"
                                       disabled="disabled">
                                <select name="sell_trade[]" data-name="sell_trade_type" data-placeholder="Choose a trade type..." class="chosen-select col-md-6" style="width:30%;" tabindex="4">
                                    <option selected="selected" value="disabled">Disabled</option>
                                    <option value="percent">Margin(%)</option>
                                    <option value="flat_rate">Flat Rate</option>
                                </select>
                            </td>
                            <td>
                                <div class="flag-toggle-2">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" class="visible-switch"
                                               {{ (false) ? 'checked' : '' }}
                                               data-id="{{ $oExchangeRate->id }}"
                                               data-toggle="toggle"
                                               data-size="mini"
                                               data-on-text="Visible"
                                               data-off-text="Hidden"
                                        >
                                        <input type="hidden" name="visible" value="0" data-name="visible" id="vs_{{ $oExchangeRate->id }}">
                                    </label>
                                </div>
                            </td>
                            <td class="text-right footable-last-column">
                                <div class="btn-group">
                                    <button class="btn-green btn btn-sm single-row-apply">
                                        Apply
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

            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green'
            });

            var cbVisible = $('.visible-switch');
            cbVisible.bootstrapSwitch();
            cbVisible.on('switchChange.bootstrapSwitch', function(event, state) {
                $('#vs_' + $(this).data('id')).val(state ? 1 : 0)
            });

            $('.chosen-select').chosen();

            $('.single-row-apply').click(function () {

                var that = $(this);
                var row = that.parents('tr').first();
                var data = {};
                row.find('[data-name]').each(function () {
                     data[$(this).data('name')] =   $(this).val();
                });

                $.ajax({
                    method: "POST",
                    url: "trade/apply",
                    data: data,
                    success: function(result) {
                        if(result.success === true){
                            row.after('<div id="msg" style="position: absolute;left:30%;z-index: 1000;" class="alert alert-success"><button type="button" class="close" data-dismiss="alert">x</button> <strong>Done! </strong>The field was applied successful. Please refresh when you are ready.</div>');
                            setTimeout(function(){
                                $('#msg').remove();
                                row.remove();
                            }, 2000);
                        }


                    }, error: function (result) {
                        row.after('<div id="msg" style="position: absolute;left:30%;z-index: 1000;" class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">x</button> <strong>Error! </strong>Something is wrong. </div>');
                        setTimeout(function(){
                            $('#msg').remove();
                        }, 2000);
                    }
                })
            });

            $('.check-all').on('ifClicked', function(event){
                $('.i-checks:not(:first)').iCheck('toggle');
            });

            $('.chosen-select').on('change',function () {
                var selected = $(this).val();
                var input = $(this).parent().find('input');
                if(selected == 'disabled') {
                    input.prop('disabled', true);
                } else {
                    input.prop('disabled', false);
                }
            });

            $('#apply').click(function () {

                var data = {};
                var that = $(this);

                $('.i-checks').each(function () {

                    var row_data = {};
                    var row = $(this).parents('tr').first();
                    if ($(this).prop("checked")) {
                        row.find('[data-name]').each(function () {
                            row_data[$(this).data('name')] =  $(this).val();
                        });
                        data[row.attr('id').replace("rate_", "")] = row_data;
                    }
                });

                if(Object.keys(data).length) {
                    call_ajax(data);
                }
                function call_ajax(data) {
                    $.ajax({
                        method: "POST",
                        url: "trade/collection",
                        data: data,
                        success: function (result) {
                            for(var i in result.rate_ids){
                                $("tr[id='rate_" + result.rate_ids[i] + "']").remove();
                            }
                            that.after('<div id="msg"  class="alert alert-success"> <button type="button" class="close" data-dismiss="alert">x</button> <strong>Done! </strong>The fields was applied successful. Please refresh when you are ready. </div>');
                            setTimeout(function () {
                                $('#msg').remove();
                            }, 5000);

                        }, error: function (result) {
                            that.after('<div id="msg" class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert">x</button> <strong>Error! </strong>All fields must be numeric. </div>');
                            setTimeout(function () {
                                $('#msg').remove();
                            }, 5000);
                        }
                    });
                }
            });

            $(".single-row-update").on('click', function(){
                console.log('slap');
                var that = $(this);
                var row = that.parents('tr').first();
                var data = {};
                row.find('[data-name]').each(function () {
                    data[$(this).data('name')] =   $(this).val();
                });

                console.log(data);
                $.ajax({
                    method: "POST",
                    url: "trade/update",
                    data: data,
                    success: function(result) {
                        if(result.success === true){
                            row.after('<div id="msg" style="position: absolute;left:30%;z-index: 1000;" class="alert alert-success"><button type="button" class="close" data-dismiss="alert">x</button> <strong>Done! </strong>The field has been updated successful.</div>');
                            setTimeout(function(){
                                $('#msg').remove();
                            }, 2000);
                        }


                    }, error: function (result) {
                        row.after('<div id="msg" style="position: absolute;left:30%;z-index: 1000;" class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">x</button> <strong>Error! </strong>Something is wrong. </div>');
                        setTimeout(function(){
                            $('#msg').remove();
                        }, 2000);
                    }
                })
            });
        });
    </script>
@endsection