<div class="header top-header">
    <div class="container">
        <div class="d-flex">
            <a id="horizontal-navtoggle" class="animated-arrow hor-toggle"><span></span></a><!-- sidebar-toggle-->
            <a class="header-brand" href="/">
                <img src="logo/logohoasao2.png" class="header-brand-img desktop-lgo mt-2" alt="Clont logo">
                <img src="logo/logohoasao2.png" class="header-brand-img dark-logo" alt="Clont logo">
                {{-- <img src="logo/favicon.png" class="header-brand-img mobile-logo" alt="Clont logo">
                <img src="logo/favicon1.png" class="header-brand-img darkmobile-logo" alt="Clont logo"> --}}
            </a>
           
            @if(Auth::check())
            <div class="d-flex order-lg-2 ml-auto">
                <div class="dropdown mt-3">
                    <a class="nav-link " data-toggle="dropdown">
                        <h4>{{ Auth::user()->username }}</h4>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow ">
                        <div class="text-center">
                            <a href="#" class="dropdown-item text-center user pb-0">{{ Auth::user()->name }}</a>
                            <span class="text-center user-semi-title text-dark">@foreach(Auth::user()->getRoleNames() as $v)
                               <label class="badge badge-success">{{ $v }}</label>
                            @endforeach</span>
                            <div class="dropdown-divider"></div>
                        </div>
                        <a class="dropdown-item" href="{{ route('profile.show') }}">
                            <i class="dropdown-icon mdi mdi-account-outline "></i> Profile
                        </a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        
                            <i class="dropdown-icon mdi  mdi-logout-variant"></i> Sign out
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                  {{ csrf_field() }}
                        </form>
                    </div>
                </div>
            </div>
            @endif
            
        </div>
    </div>
</div>