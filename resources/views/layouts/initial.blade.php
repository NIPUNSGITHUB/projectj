<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/vue-multiselect@2.1.0/dist/vue-multiselect.min.css">
 
    <!-- <script src="http://cdn.ckeditor.com/4.6.1/standard/ckeditor.js"></script> -->
    <style>
    
    body:after{
        content: "beta";
        position: fixed;
        width: 80px;
        height: 25px;
        background: #EE8E4A;
        top: 7px;
        left: -20px;
        text-align: center;
        font-size: 13px;
        font-family: sans-serif;
        text-transform: uppercase;
        font-weight: bold;
        color: #fff;
        line-height: 27px;
        transform:rotate(-45deg);
        }
    
    </style>
</head>
<body>
    <div id="app">      
 
    <nav class="navbar navbar-default">
      <div class="container">
        <div class="navbar-header">        
          
        </div>
        <div id="navbar" class="collapse navbar-collapse">

        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <header id="header">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1 class="text-center"> Digitizing Printer Industry <br><small style="visibility:hidden;">Account Login</small></h1>
          </div>
        </div>
      </div>
    </header>

    <section id="main">
      <div class="container">
        <div class="row">
         
            <main class="mt-10 py-0">   
                @yield('content')           
            </main>   
            
        </div>
      </div>
    </section>
          
    </div>  
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="{{ asset('js/bootstrap.min.js')}}"></script>
</body>
</html>
