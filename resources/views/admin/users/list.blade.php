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
                        <th class="footable-first-column">Name</th>
                        <th>Email</th>
                        <th>Exchange Id</th>
                        <th class="text-right footable-last-column">Action</th>
                    </tr>

                    @foreach($aUsers as $iIdx => $oUser)
                        <tr class="footable-{{$iIdx % 2 == 0 ? 'odd' : 'even'}}" style="display: table-row;">
                            <td class="footable-first-column">
                                {{ $oUser->name }}
                            </td>
                            <td>
                                {{ $oUser->email }}
                            </td>
                            <td>
                                {{ $oUser->cambiu_id }}
                            </td>
                            <td class="text-right footable-last-column">
                                <div class="btn-group">
                                    @if(Auth::user()->role == 'admin')
                                        {{--<a type="button" class="btn-white btn btn-xs" href="{{url('admin/users/edit/' . $oUser->id)}}"> Edit</a>--}}
                                        @if($oUser->id != Auth::user()->id)
                                            <a type="button" class="btn-white btn btn-xs" onclick="return confirm('Are you sure you want to delete this item?');" href="{{ route('user-destroy', ['id' => $oUser->id] )}}"> Delete</a>
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
@stop