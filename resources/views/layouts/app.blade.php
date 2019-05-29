<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Tayeboon2Tayebat</title>

    

    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css"> --}}

    

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @yield('css')


</head>
<body>
    <div id="app">
        
        @include('includes.navbar')

        <main class="py-4">
            <div id="messages" class="container">
                @include("includes.messages")
            </div>  


            @yield('content')

        </main>


        @include('includes.footer')
        
          
              
    </div>

    @if(Auth::check())
    
        @include('includes.feedback')

    @endif


    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    @yield("javascript")


</body>
</html>
