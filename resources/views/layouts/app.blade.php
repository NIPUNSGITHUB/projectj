<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @if (Auth::check())
        <meta name="user" content="{{ Auth::user() }}">
    @else
        <meta name="user" content="Tempory">
    @endif
    

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
    {{-- <link rel="stylesheet" href="vue-datetime.css"> --}}
    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/vue-multiselect@2.1.0/dist/vue-multiselect.min.css">
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
<body  style="background-image: url(/background.png);
background-repeat: no-repeat;background-size: cover;">
  <div id="app">
  
    <header id="header">
      <div class="container">
        <div class="row">
          <div class="col-md-9">
           
            @if (Auth::check())
              <h1><span class="glyphicon glyphicon-cog mt-2" aria-hidden="true"></span>{{Auth::user()->user_type}} Dashboard <small>Manage Your orders</small></h1>                
            @else
          
              <h1><span class="glyphicon glyphicon-cog mt-2" aria-hidden="true">Tempory Customer Dashboard <small>Manage Your orders</small></h1>                
            @endif           
            <notifications group="foo" />
          </div>
          <div class="col-md-3">
         <div class="row">
            <div class="col-md-3 pr-0">
                @if (Auth::check())
                  <img src="https://lh3.googleusercontent.com/-_mSikl2xdgc/AAAAAAAAAAI/AAAAAAAAAAA/AAKWJJOAtp0m9hdup5A6MktBbF_tzo8wJw.CMID/s83-c/photo.jpg" class="rounded-circle mt-3" alt="Cinque Terre" width="60" height="60">                   
                @else
                  <img src="https://cdn1.iconfinder.com/data/icons/flat-business-icons/128/user-512.png" class="rounded-circle mt-3" alt="Cinque Terre" width="60" height="60">                    
                @endif              
            </div>
             <div class="col-md-9">
              @if (Auth::check())
                  <h5>{{Auth::user()->name}}</h5>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                   <button type="submit" class="btn btn-success btn-block"> <i class="fa fa-sign-out" aria-hidden="true"></i> Logout</button>
                 </form>                 
              @else
                  <h5>Tempory Customer</h5> 
                  <a href="/login">Home</a>
              @endif
               
            </div>
         </div>
            
          </div>
        </div>
      </div>
    </header>

    <section id="breadcrumb">
      <div class="container">
        <ol class="breadcrumb">
          <li class="active">Dashboard</li>
        </ol>
      </div>
    </section>
       
       
        <main class="py-4">
          @if (Auth::check())
            <router-view></router-view>
          @else
            @yield('content')  
          @endif
          
        </main>


        <!-- <footer id="footer">
        <p>Copyright AdminStrap, &copy; 2017</p>
        </footer> -->
  </div> 
    <!-- <script>
     CKEDITOR.replace( 'editor1' );
    </script> -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    
    <script src="https://use.fontawesome.com/9e905f7623.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="{{ asset('js/bootstrap.min.js')}}"></script>
</body>
</html>
