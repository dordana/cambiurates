@extends('admin.layouts.master')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-content forum-container">

                <div class="forum-title">
                    <div class="pull-right forum-desc">
                        <small>Total Users: {{ number_format(App\Models\User::count()) }}</small>
                    </div>
                    <a class="btn btn-primary btn-xs" href="{{ route('user-register')}}">Add new User</a>
                </div>

                <div class="search-form">
                    <form action="" method="get">
                        <div class="input-group">
                            <input type="text" placeholder="Search ..." name="search" class="form-control input-lg"
                                   value="{{\Illuminate\Support\Facades\Input::get('search')}}">
                            <div class="input-group-btn">
                                <button class="btn btn-lg btn-primary" type="submit">
                                    Search
                                </button>
                            </div>
                        </div>

                    </form>
                </div>

                <div class="hr-line-dashed"></div>

                <table class="footable table table-stripped toggle-arrow-tiny default breakpoint footable-loaded">
                    <tr>
                        <th class="footable-first-column">Email</th>
                        <th>Exchange</th>
                        <th class="text-right footable-last-column">Action</th>
                    </tr>

                    @foreach($aUsers as $iIdx => $oUser)
                        <tr class="footable-{{$iIdx % 2 == 0 ? 'odd' : 'even'}}" style="display: table-row;">
                            <td class="footable-first-column">
                                {{ $oUser->email }}
                            </td>
                            <td>
                                {{ $oUser->name }}
                            </td>
                            <td class="text-right footable-last-column">
                                <div class="btn-group">
                                    @if(Auth::user()->role == 'admin')
                                        {{--<a type="button" class="btn-white btn btn-xs" href="{{url('admin/users/edit/' . $oUser->id)}}"> Edit</a>--}}
                                        @if($oUser->id != Auth::user()->id)
                                            <a class="change-password btn-white btn btn-xs" data-toggle="modal" data-target="#change-password-modal" data-user-email="{{ $oUser->email }}">Change Password</a>
                                            <a type="button" class="btn btn-danger btn btn-xs" onclick="return confirm('Are you sure you want to delete this item?');" href="{{ route('user-destroy', ['id' => $oUser->id] )}}"> Delete</a>
                                        @endif
                                    @endif

                                    {{--@if(Auth::user()->role == 'user' && $oUser->role != 'admin')--}}
                                        {{--<a type="button" class="btn-white btn btn-xs" href="{{url('admin/users/edit/' . $oUser->id)}}"> Edit</a>--}}
                                        {{--@if($oUser->id != Auth::user()->id)--}}
                                            {{--<a type="button" class="btn-white btn btn-xs" href="{{url('admin/users/destroy/' . $oUser->id)}}"> Delete</a>--}}
                                        {{--@endif--}}
                                    {{--@endif--}}
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    <tr>
                        <td colspan="3" class="footable-visible">
                            @if($aUsers->render() != '')
                                {{ $aUsers->appends(\Illuminate\Support\Facades\Input::except(array('page')))->render() }}
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="change-password-modal" tabindex="-1" role="dialog" aria-labelledby="change-password-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('change-password') }}" method="POST">
                    <input type="hidden" name="token" value="{{ csrf_token() }}">
                    <input type="hidden" name="email" value="">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="change-password-modal">Changing user's password</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="password">New Password:</label>
                            <input type="text" name="password" class="form-control" id="password" placeholder="">
                            <label for="password_confirmation">Repeat New Password:</label>
                            <input type="text" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('footer')
    <script>
        var email = null;
        $(".change-password").on('click', function(e){
            e.preventDefault();
            email = $(this).attr('data-user-email');
        });
        $('#change-password-modal').on('shown.bs.modal', function () {
            $('input[name=password]').focus();
            $('input[name=email]').val(email);
        });
    </script>
@endsection