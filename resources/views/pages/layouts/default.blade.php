
<!DOCTYPE html>


<html lang="en" dir="ltr">
    <!--begin::Head-->
    @include('pages.layouts.partials.head')
    <!--end::Head-->
    <!--begin::Body-->
    <body class="app">
        <!---Global-loader-->
        <div id="global-loader" >
            <img src="/assets/images/svgs/loader.svg" alt="loader">
        </div>
        <div class="page">
            <div class="page-main">
                @include('pages.layouts.partials.header')
                @include('pages.layouts.partials.menu')

                <div class="app-content page-body">
                    <div class="container">
                        @yield('content')
                    </div>
                </div>
            </div>
            @include('pages.layouts.partials.footer')
        </div>

        <!-- Back to top -->
        <a href="#top" id="back-to-top" style="display: inline;"><i class="fa fa-angle-up"></i></a>       
       
       <!--start::Page Scripts-->
        @include('pages.layouts.partials.importjs')
        <!--end::Page Scripts-->
    </body>
    <!--end::Body-->
</html>