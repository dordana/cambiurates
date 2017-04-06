@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">{{ isset($oUser) ? 'Update User' : 'Create new User' }}</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ isset($oUser) ? route('user-update') : route('user-register') }}">
                        {!! csrf_field() !!}


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
                            <label class="col-md-2 control-label" for="cambiu_id">Exchange Id</label>

                            <div class="col-md-10">

                                <select  name="cambiu_id" id="cambiu_id" data-placeholder="Choose a exchange..." class="chosen-select col-md-6" style="width:100%;" tabindex="4">
                                    <option value="">Select</option>
                                </select>

                                @if ($errors->has('cambiu_id'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('cambiu_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-2">
                                <a href="{{ route('home') }}" class="btn btn-white" type="submit">Cancel</a>
                                <button type="submit" class="btn btn-primary">
                                    {{isset($oUser) ? 'Update' : 'Create'}}
                                </button>
                            </div>
                        </div>

                        <input type="hidden" class="form-control" name="name" id="name" value="">

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        showPleaseWait();
        apigClient.exchangesGet({city : 'London', country : 'UK'}, {}, {})
            .then(function(result){
                    $.each(result.data, function( index, value ) {
                        hidePleaseWait();
                        var address = value.address;
                        select.append("<option value='"+value.id+"' data-name='"+ value.name +"' data-nearest_station='"+value.nearest_station+"'>"+value.name+ ((address.length > 0) ? "("+address+")" : "") + "</option>");
                        if(parseInt(old_id) == parseInt(value.id)) {
                            select.val(value.id);
                        }
                    });
                    select.trigger("chosen:updated");
                    if(parseInt(select.val()) > 0) {
                        select.trigger('change');
                    }
                    // Add success callback code here.
            }).catch( function(result){
                swal('Ups!', 'API remoting web service problem. Try refreshing the page or contact your web dev', 'warning');
            });

        select.change(function () {
            var name = $('#name');
            name.val(select.find('option:selected').data('name'));
            var station = select.find('option:selected').data('nearest_station');

            var $nearestStation = $('#nearest_station');
            if($nearestStation.length > 0){
                $nearestStation.remove();
            }

            if(station){
                name.after('<input type="hidden" class="form-control" name="nearest_station" id="nearest_station" value="'+station+'">');
            }
        })
    </script>
@endsection
