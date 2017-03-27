<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<!-- Meta, title, CSS, favicons, etc. -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="csrf_token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>{{ config('app.name', 'Laravel') }} @yield('title') </title>

<link rel="shortcut icon" href="{{ asset('favicon.png') }}" >

<!-- Bootstrap -->
<link href="{{ asset('common/dashboard/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
<!-- Font Awesome -->
<link href="{{ asset('common/dashboard/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
<!-- NProgress -->
<link href="{{ asset('common/dashboard/vendors/nprogress/nprogress.css') }}" rel="stylesheet">
<!-- iCheck -->
<link href="{{ asset('common/dashboard/vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">
<!-- bootstrap-progressbar -->
<link href="{{ asset('common/dashboard/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet">

<link href="{{ asset('common/dashboard/vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet">

@yield('css')

@yield('customCss')

<!-- Custom Theme Style -->
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
<link href="{{ asset('css/icon.css') }}" rel="stylesheet">
@yield('headJs')

