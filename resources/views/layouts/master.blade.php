<!DOCTYPE HTML>
<html>
   <head>
      <meta charset="utf-8">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>Spirit Prototype</title>
      <link rel="stylesheet" href="{{URL::asset('/css/base.css')}}"/>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/lumen/bootstrap.min.css"/>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
      <script src="{{URL::asset('/js/base.js')}}"></script>
      <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
      <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
      <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
   </head>
   <body>
      <nav class="navbar navbar-default navbar-fixed-top">
	 <div class="container-fluid">
	     <div class="navbar-header">
	       <a class="navbar-brand" href="/">
		  <img alt="Logo" src="/img/logo_nav.png">
	       </a>
	     </div>
	 <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-left">
              <li class="active"><a href="/">Checks</a></li>
              <li class="dropdown">
                <a href="/vehicles" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Vehicles<span class="caret"></span></a>
                <ul class="dropdown-menu">
		  <li><a href="/vehicles">Vehicles</a></li>
                  <li><a href="/types">Types</a></li>
                </ul>
              </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li class="dropdown">
                <a href="/user" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Welcome, User<span class="caret"></span></a>
                <ul class="dropdown-menu">
		  <li><a href="/user">Profile</a></li>
                  <li><a href="/logout">Logout</a></li>
                </ul>
              </li>
            </ul>
            <form class="navbar-form navbar-right" action="/search" method="POST">
	      {{ csrf_field() }}
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Search" name="search">
              </div>
              <button type="submit" class="btn btn-default">Submit</button>
            </form>
          </div><!-- /.navbar-collapse -->
	 </div>
      </nav>
      <main>
	 @yield('content')
      </main>
   </body>
</html>
