<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - Ryusei Apps</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('') }}img/ryusei_logo.png" rel="icon">
  <link href="{{ asset('') }}img/ryusei_logo.png" rel="ryusei_logo">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('') }}vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ asset('') }}vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="{{ asset('') }}vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="{{ asset('') }}vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="{{ asset('') }}vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="{{ asset('') }}vendor/remixicon/remixicon.css" rel="stylesheet">
  <!-- <link href="{{ asset('') }}vendor/simple-datatables/style.css" rel="stylesheet"> -->

  <!-- Template Main CSS File -->
  <link href="{{ asset('') }}css/style.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.css" />

  <script src="{{ asset('') }}plugin/jquery/jquery.min.js"></script>



  @yield('custom-css')
</head>

<body>

    @include('layouts.header')
    @include('layouts.sidebar')

    @yield('content')

    @include('layouts.footer')