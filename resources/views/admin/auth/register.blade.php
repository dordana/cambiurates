@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">{{ isset($oUser) ? 'Update User' : 'Create new User' }}</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ isset($oUser) ? url('admin/users/update') : url('admin/users/register') }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="col-md-2 control-label" for="name">Name</label>

                            <div class="col-md-10">
                                <input type="text" class="form-control" name="name" id="name" value="{{ isset($oUser) ? $oUser->name : old('name') }}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

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
                            <label class="col-md-2 control-label" for="cambiu_id">Cambiu Id</label>

                            <div class="col-md-10">
                                <input type="text" class="form-control" name="cambiu_id" id="cambiu_id" value="{{ isset($oUser) ? $oUser->cambiu_id : old('cambiu_id') }}">

                                @if ($errors->has('cambiu_id'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('cambiu_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-2 control-label" for="password">Password</label>

                            <div class="col-md-10">
                                <input type="password" class="form-control" name="password" id="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label class="col-md-2 control-label" for="password_confirmation">Confirm Password</label>

                            <div class="col-md-10">
                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
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

                        @if(isset($oUser))
                            <input type="hidden" name="id" value="{{$oUser->id}}"/>
                        @endif

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
