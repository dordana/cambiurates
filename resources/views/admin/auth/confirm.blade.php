<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <title>CAMBIU - Administration</title>

    <link href="{!! asset('styles/admin/all.css') !!}" rel="stylesheet">
    <link href="{!! asset('styles/admin/app.css') !!}" rel="stylesheet">

</head>

<body class="gray-bg">

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="loginColumns animated fadeInDown">
        <div class="row">

            <div class="col-md-6">
                <h2 class="font-bold">cambiu</h2>

                <p>
                    We sent a confirmation code email to the email address you used
                </p>
            </div>
            <div class="col-md-6">
                <div class="ibox-content">
                    <form class="m-t" role="form" method="POST" action="{{ url()->route('confirm') }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ (session('confirmation_code')) ? ' has-error' : '' }}">
                            <input type="text" name="confirmation_code" class="form-control" placeholder="Confirmation Code">

                            @if (session('confirmation_code'))
                                <span class="help-block text-danger">
                                    <strong>{{ session('confirmation_code') }}</strong>
                                </span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary block full-width m-b">Confirm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
