<!DOCTYPE html>



<html lang="es">
  <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="description" content="">
      <meta name="author" content="">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />

      @section('style')
          <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
          <link rel="stylesheet" href="{{ asset('public/Css/jquery-ui.css') }}" media="screen">    
          <link rel="stylesheet" href="{{ asset('public/Css/bootstrap.min.css') }}" media="screen">    
          <link rel="stylesheet" href="{{ asset('public/Css/sticky-footer.css') }}" media="screen">  
          <link rel="shortcut icon" href="{{ asset('public/Img/Institucionales/iconoModulo.png') }}">  
          <link rel="stylesheet" href="{{ asset('public/Css/css_datatable/jquery.dataTables.min.css') }}" media="screen">
          <link rel="stylesheet" href="{{ asset('public/Css/css_datatable/buttons.dataTables.min.css') }}" media="screen"> 
          <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.0.1/css/responsive.bootstrap.min.css">  
      @show

      @section('script')
          <script src="{{ asset('public/Js/js_datatable/jquery-1.12.3.js') }}"></script>
          <script src="{{ asset('public/Js/jquery.js') }}"></script>
          <script src="{{ asset('public/Js/jquery-ui.js') }}"></script>
          <script src="{{ asset('public/Js/bootstrap.min.js') }}"></script>
          <script src="{{ asset('public/Js/main.js') }}"></script>

          <script src="{{ asset('public/Js/js_datatable/jquery.dataTables.min.js') }}"></script>
          <script src="{{ asset('public/Js/js_datatable/dataTables.buttons.min.js') }}"></script>
          <script src="{{ asset('public/Js/js_datatable/jszip.min.js') }}"></script>
          <script type="text/javascript" language="javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
          <script src="{{ asset('public/Js/js_datatable/vfs_fonts.js') }}"></script>
          <script src="{{ asset('public/Js/js_datatable/buttons.html5.min.js') }}"></script>  
          <script src=" https://cdn.datatables.net/responsive/2.0.1/js/dataTables.responsive.min.js"></script>
          <script src=" https://cdn.datatables.net/responsive/2.0.1/js/responsive.bootstrap.min.js"></script> 
          
      @show


          
          

      <title>P.A.A</title>
  </head>

  <body>
      
       <!-- Menu Módulo -->
       <div class="navbar navbar-default navbar-fixed-top">
        <div class="container">
          <div class="navbar-header">
            <a href="#" class="navbar-brand">SIM</a>
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
          </div>
          <div class="navbar-collapse collapse" id="navbar-main">
            <ul class="nav navbar-nav">
              
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes">Configuración<span class="caret"></span></a>
                <ul class="dropdown-menu" aria-labelledby="themes">
                  <li class=”{{ Request::is( 'PresupuestoPAA') ? 'active' : '' }}”><a href="{{ URL::to( 'PresupuestoPAA') }}">Presupuesto PAA</a></li>
                  <li class=”{{ Request::is( 'personas') ? 'active' : '' }}”><a href="{{ URL::to( 'personas') }}">Usuarios</a></li>
                  <li class=”{{ Request::is( 'asignarActividad') ? 'active' : '' }}”><a href="{{ URL::to( 'asignarActividad') }}">Permisos</a></li>
                </ul>
              </li>

              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="download">PAA<span class="caret"></span></a>
                <ul class="dropdown-menu" aria-labelledby="download">
                  <li class=”{{ Request::is( 'GestionarPaa') ? 'active' : '' }}”><a href="{{ URL::to( 'GestionarPaa') }}">Gestionar PAA</a></li>
                  <li><a href="#">Mis Planes</a></li>
                </ul>
              </li>

            </ul>

            <form class="navbar-form navbar-left" role="search">

            </form>

            <ul class="nav navbar-nav navbar-right">
              <li><a href="http://www.idrd.gov.co/sitio/idrd/" target="_blank">I.D.R.D</a></li>
              <li><a href="#" target="_blank">Cerrar Sesión</a></li>
            </ul>

          </div>
        </div>
      </div>
      <!-- FIN Menu Módulo -->
        
      <!-- Contenedor información módulo -->
      </br></br>
      <div class="container">
          <div class="page-header" id="banner">
            <div class="row">
              <div class="col-lg-8 col-md-7 col-sm-6">
                <h1>MÓDULO</h1>
                <p class="lead"><h1>PLAN ANUAL DE ADQUISICIONES</h1></p>
              </div>
              <div class="col-lg-4 col-md-5 col-sm-6">
                 <div align="right"> 
                    <img src="public/Img/IDRD.JPG" width="50%" heigth="40%"/>
                 </div>                    
              </div>
            </div>
          </div>        
      </div>
      <!-- FIN Contenedor información módulo -->

      <!-- Contenedor panel principal -->
      <div class="container">
          @yield('content')
      </div>        
      <!-- FIN Contenedor panel principal -->
  </body>

</html>





