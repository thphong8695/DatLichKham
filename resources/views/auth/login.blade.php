{{-- <x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-jet-label for="username" value="{{ __('Username') }}" />
                <x-jet-input id="username" class="form-control block mt-1 w-full" type="text" name="username" :value="old('username')" required autofocus />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="form-control block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-jet-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-jet-button class="ml-4">
                    {{ __('Login') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
 --}}
 <!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>

        <!-- Meta data -->
        <meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
        <meta content="Clont - Bootstrap Webapp Responsive Dashboard Simple Admin Panel Premium HTML5 Template" name="description">
        <meta content="Spruko Technologies Private Limited" name="author">
        <meta name="keywords" content="Admin, Admin Template, Dashboard, Responsive, Admin Dashboard, Bootstrap, Bootstrap 4, Clean, Backend, Jquery, Modern, Web App, Admin Panel, Ui, Premium Admin Templates, Flat, Admin Theme, Ui Kit, Bootstrap Admin, Responsive Admin, Application, Template, Admin Themes, Dashboard Template"/>

        <!-- Title -->
        <title>Đặt lịch - 106X</title>

        <!--Favicon -->

        <!-- Style css -->
        <link href="assets/css/style.css" rel="stylesheet" />

        <!---Icons css-->
        <link href="assets/plugins/web-fonts/icons.css" rel="stylesheet" />
        <link href="assets/plugins/web-fonts/font-awesome/font-awesome.min.css" rel="stylesheet">
        <link href="assets/plugins/web-fonts/plugin.css" rel="stylesheet" />

    </head>

<body class="h-100vh">
    <div class="page">
        <div class="page-single">
            <div class="container">
                <div class="row">
                    <div class="col mx-auto">
                        
                        <div class="row justify-content-center">
                            
                            
                            <div class="col-md-8">
                                <div class="card-group mb-0">

                                    <div class="card p-4">
                                        <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="card-body">
                                            @if(count($errors)>0)
                                            <div class="alert alert-danger" role="alert">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                @foreach($errors->all() as $err)
                                                {{ $err }}<br>
                                                @endforeach

                                            </div>
                                            @endif
                                            
                                            <div class="input-group mb-3">
                                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                <input type="text" name="username" class="form-control" placeholder="Username" value="{{ old('username') }}" autofocus="">
                                            </div>
                                            <div class="input-group mb-4">
                                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                                <input type="password" name="password" class="form-control" placeholder="Password">
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                                                </div>
                                                {{-- <div class="col-12">
                                                    <a href="forgot-password.html" class="btn btn-link box-shadow-0 px-0">Forgot password?</a>
                                                </div> --}}
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                    <div class="card text-white bg-primary py-5 d-md-down-none ">
                                        <div class="card-body text-center justify-content-center ">
                                            <h2>Lưu ý:</h2>
                                            <p>Hỗ trợ tốt trên trình duyệt chrome.</p>
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery js-->
    <script src="assets/js/vendors/jquery-3.4.0.min.js"></script>

    <!-- Bootstrap4 js-->
    <script src="assets/plugins/bootstrap/popper.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

    <!--Othercharts js-->
    <script src="assets/plugins/othercharts/jquery.sparkline.min.js"></script>

    <!-- Circle-progress js-->
    <script src="assets/js/vendors/circle-progress.min.js"></script>

    <!-- Jquery-rating js-->
    <script src="assets/plugins/rating/jquery.rating-stars.js"></script>

</body>
</html>
