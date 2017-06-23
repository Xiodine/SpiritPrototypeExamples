<!DOCTYPE HTML>
<html>
   <head>
      <meta charset="utf-8">
      <title>Spirit Prototype</title>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="apple-mobile-web-app-capable" content="yes">
      <meta name="apple-mobile-web-app-status-bar-style" content="black">
      <meta name = "viewport" content = "width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
      <link rel="manifest" href="/manifest.json">
      <link rel="stylesheet" href="/css/mobile.css"/>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/lumen/bootstrap.min.css"/>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
      <script src="/js/mobile.js"></script>
      <script type="text/javascript" src="https://rawgit.com/ftlabs/fastclick/master/lib/fastclick.js"></script>
   </head>
   <body>
      <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	 <div class="container-fluid">
	     <div class="navbar-header">
	       <a class="navbar-brand" href="/mobile">
		  <img alt="Logo" src="/img/logo_nav.png">
	       </a>
	     </div>
	    <ul class="nav navbar-nav navbar-right">
	       <li><a href="/mobile/search"><i class="glyphicon glyphicon-search"></i></a></li>
	    </ul>
          </div><!-- /.navbar-collapse -->
	 </div>
      </nav>
      <main>
	 @yield('content')
      </main>
   </body>
</html>
