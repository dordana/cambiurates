@extends('admin.layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-content forum-container">

                <div class="forum-title">
                    <div class="pull-right forum-desc">
                        <small>Total Exchange Rates: {{ number_format($aExchangeRates->total()) }}</small>
                    </div>
                    <a class="btn btn-primary btn-xs" href="{{ url('admin/exchangerate/create') }}">Add new
                        Exchange Rate</a>
                </div>

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
                <div class="table-responsive">
                    <table class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded">
                        <tr>
                            <th class="footable-first-column">Symbol</th>
                            <th>Title</th>
                            <th>Visible</th>
                            <th>Exchange Rate</th>
                            <th>Buy Markup (%)</th>
                            <th>Sell Markup (%)</th>
                            <th>TTT Sell</th>
                            <th>Profit</th>
                            <th class="text-right footable-last-column">Action</th>
                        </tr>

                        @foreach($aExchangeRates->all() as $iIdx => $oExchangeRate)
                        <tr class="footable-{{$iIdx % 2 == 0 ? 'odd' : 'even'}}" style="display: table-row;">
                            <td class="footable-first-column">
                                {{ $oExchangeRate->symbol }}
                            </td>
                            <td>
                                {{ $oExchangeRate->title }}
                            </td>
                            <?php
                            /*<td>
                                {{ $oExchangeRate->featured != 0 ? $oExchangeRate->featured . ' spot' : 'No'}}
                            </td>*/
                            ?>
                            <td>
                                @if ($oExchangeRate->visible == 1)
                                    <span class="label label-primary">Visible</span>
                                @else
                                    <span class="label label-warning">Hidden</span>
                                @endif
                            </td>
                            <td>
                                {{ $oExchangeRate->exchangeRate }}
                            </td>
                            <td>
                                {{ $oExchangeRate->buyMarkup }}
                            </td>
                            <td>
                                {{ $oExchangeRate->sellMarkup }}
                            </td>
                            <td>
                                {{ $oExchangeRate->tttSell }}
                            </td>
                            <td>
                                {{ $oExchangeRate->getProfitAttribute() }}
                            </td>
                            <td class="text-right footable-last-column">
                                <div class="btn-group">
                                    <button class="btn-white btn btn-xs"
                                            onclick="window.location='{{ url('admin/exchangerate/edit/' . $oExchangeRate->id) }}'">
                                        Edit
                                    </button>
                                    <button class="btn-white btn btn-xs"
                                            onclick="window.location='{{ url('admin/exchangerate/destroy/' . $oExchangeRate->id) }}'">
                                        Delete
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