<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>cambiu - Administration</title>

    <link href="{!! asset('styles/admin/all.css') !!}" rel="stylesheet">
    <link href="{!! asset('styles/admin/app.css') !!}" rel="stylesheet">

    <script type="text/javascript">
        (function(a){__q=function(){return a;};$=function(f){typeof f==="function"&&a.push(arguments);return $;};jQuery=$.ready=$;}([]));
    </script>

    @yield('header')

</head>

<body class="{{ Auth::check() ? '' : 'gray-bg' }}">

@if(Auth::check())
    <div id="wrapper">

        @include('admin.partials.sidebar')

        <div id="page-wrapper" class="gray-bg">
            <main>
                @include('admin.partials.header')
                @include('admin.partials.breadcrumb')

                <div class="wrapper wrapper-content animated fadeInRight">
                    @if (Session::has('error'))
                        <div class="alert alert-danger alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                            <i class="fa fa-exclamation-triangle"></i> {{ Session::get('error') }}
                        </div>
                    @endif

                    @if (Session::has('success'))
                        <div class="alert alert-success alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                            <i class="fa fa-check"></i> {{ Session::get('success') }}
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>

            @include('admin.partials.footer')

        </div>
    </div>
@else
    <div class="wrapper wrapper-content animated fadeInRight">
        @yield('content')
    </div>
@endif

<script src="{!! asset('scripts/admin/vendor.js') !!}"></script>

{{--<!-- Mainly scripts -->--}}
<script src="{!! asset('scripts/admin/plugins/jquery-ui/jquery-ui.js') !!}"></script>
<script src="{!! asset('scripts/admin/plugins/metisMenu/jquery.metisMenu.js') !!}"></script>
<script src="{!! asset('scripts/admin/plugins/slimscroll/jquery.slimscroll.min.js') !!}"></script>
<script src="{!! asset('scripts/admin/plugins/chosen/chosen.jquery.js') !!}"></script>
<script src="{!! asset('scripts/admin/plugins/iCheck/icheck.min.js') !!}"></script>
<script src="{!! asset('scripts/admin/plugins/switch/bootstrap-switch.min.js') !!}"></script>
<script type="text/javascript">
    (function(i,s,q,l){for(q=window.__q(),l=q.length;i<l;){$.apply(this,s.call(q[i++]));}window.__q=undefined;}(0,Array.prototype.slice));
</script>

<script>
    if ($('body').width() < 1380) {
        $('body').addClass('mini-navbar');
    }
    $('.chosen-select').chosen();
</script>

@include('admin.javascript.custom-javascript')

</body>

</html>
