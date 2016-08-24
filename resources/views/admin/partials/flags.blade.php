<a id="flag_btn" class="btn btn-primary minimalize-styl-2" data-toggle="flag_collapse" href="#">
    Flags
</a>
<span id="flag_collapse">
    @foreach($flags AS $flag)
        <div class="flag-toggle-2">
            <label class="checkbox-inline">
                {{ $flag }}
            </label>
        </div>
    @endforeach
</span>

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function () {
            $("#flag_btn").on('click', function () {
                $('#flag_collapse').animate({
                    width: 'toggle'
                }, "normal");
            });

            var cbSelector = $(".flag-checkbox");

            cbSelector.bootstrapSwitch();
            cbSelector.on('switchChange.bootstrapSwitch', function (event, state) {
                var theCb = $(this);
                $.ajax({
                    'method': 'POST',
                    'url': 'http://' + document.domain + '/admin/flags/active',
                    'data': {
                        'id': $(this).val(),
                        'state': state ? 1 : 0,
                        'key': $(this).attr('name')
                    },
                    success: function (data) {
                        if (data.success !== true) {
                            theCb.bootstrapSwitch('state', !state, true);
                        }
                    },
                    error: function () {
                        theCb.bootstrapSwitch('state', !state, true);
                    }
                });
            });
        });
    </script>
    @parent
@endsection
