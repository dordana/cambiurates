<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <title>ACE-FX - Administration</title>

    <link href="{!! asset('styles/admin/all.css') !!}" rel="stylesheet">
    <link href="{!! asset('styles/admin/app.css') !!}" rel="stylesheet">

</head>

<body class="gray-bg">

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="loginColumns animated fadeInDown">
        <div class="row">

            <div class="col-md-6">
                <h2 class="font-bold">ACE FX</h2>

                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Id magni modi nulla numquam quaerat quia reprehenderit soluta ullam unde vel. Accusantium amet debitis earum libero maiores nobis reprehenderit sequi vitae!
                </p>

                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Id magni modi nulla numquam quaerat quia reprehenderit soluta ullam unde vel. Accusantium amet debitis earum libero maiores nobis reprehenderit sequi vitae!
                </p>

                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Id magni modi nulla numquam quaerat quia reprehenderit soluta ullam unde vel. Accusantium amet debitis earum libero maiores nobis reprehenderit sequi vitae!
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
                    <p class="m-t">
                        <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
