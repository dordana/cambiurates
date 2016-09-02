<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear">
                            <span class="block m-t-xs">
                                <strong class="font-bold">{{Auth::user()->name}}</strong>
                            </span>
                            <span class="text-muted text-xs block">{{Auth::user()->email}} <b class="caret"></b></span>
                        </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="{{ url('admin/logout') }}">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    cambiu
                </div>
            </li>
            <li class="@if(Request::is("admin")) active @endif">
                <a href="{{ url('admin') }}"><i class="fa fa-home"></i> <span class="nav-label">Home</span></a>
            </li>
            <li class="@if(Request::is("admin/exchangerate*")) active @endif">
                <a href="{{ url('admin/exchangerates') }}"><i class="fa fa-dollar"></i> <span class="nav-label">Exchange Rates</span>
                </a>
            </li>
            @if(Auth::user()->role == 'admin')
                <li class="@if(Request::is("admin/user*")) active @endif">
                    <a href="{{ url('admin/users') }}"><i class="fa fa-users"></i> <span class="nav-label">Users</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</nav>
