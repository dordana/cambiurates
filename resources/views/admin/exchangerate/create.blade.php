@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="ibox">
                <div class="ibox-title"><h3>{{ isset($oExchangeRate) ? 'Update' : 'Create new'}} Exchange Rate</h3></div>
                <div class="ibox-content">
                    <form class="form-horizontal" enctype="multipart/form-data" role="form" method="POST" action="{{ isset($oExchangeRate) ? url('admin/exchangerate/update') : url('admin/exchangerate/store') }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('symbol') ? ' has-error' : '' }}">
                            <label class="col-md-2 control-label" for="symbol">Symbol</label>

                            <div class="col-md-10">
                                <input type="text" class="form-control" name="symbol" id="symbol" value="{{ isset($oExchangeRate) ? $oExchangeRate->symbol: old('symbol') }}">

                                @if ($errors->has('symbol'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('symbol') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label class="col-md-2 control-label" for="title">Title</label>

                            <div class="col-md-10">
                                <input type="text" class="form-control" name="title" id="title" value="{{ isset($oExchangeRate) ? $oExchangeRate->title: old('title') }}">

                                @if ($errors->has('title'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-2">
                                <a href="/admin/exchangerates" class="btn btn-white" type="submit">Cancel</a>
                                <button type="submit" class="btn btn-primary">
                                    {{isset($oExchangeRate) ? 'Update' : 'Create'}}
                                </button>
                            </div>
                        </div>

                        @if(isset($oExchangeRate))
                            <input type="hidden" name="id" value="{{$oExchangeRate->id}}"/>
                        @endif

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
