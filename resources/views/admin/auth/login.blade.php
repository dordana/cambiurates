@extends('admin.layouts.master')

@section('content')

<div class="loginColumns animated fadeInDown">
    <div class="row">

        <div class="col-md-6">
            <h2 class="font-bold">CAMBIU</h2>

            <p>
                Please enter your email address and password
            </p>

        </div>
        <div class="col-md-6">
            <div class="ibox-content">
                <form class="m-t" role="form" method="POST" action="{{ url('admin/login/confirm') }}">
                    {!! csrf_field() !!}

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <input type="email" name="email" class="form-control" placeholder="Email">

                        @if ($errors->has('email'))
                                <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <input type="password" placeholder="Password" class="form-control" name="password">

                        @if ($errors->has('password'))
                                <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

                    <label>
                        <input type="checkbox" name="remember"> Remember me
                    </label>

                    <a class="btn btn-sm btn-white btn-block" href="{{ url('admin/password/reset') }}">Forgot password?</a>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
