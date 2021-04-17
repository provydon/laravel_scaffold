<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@isset($page['props']['title']){{ $page['props']['title'] }} | @endisset{{ config('app.name', 'Laravel') }}@isset($page['props']['description']) - {{ $page['props']['description'] }}@endisset</title>
        <meta name="description" content="@isset($page['props']['description']) {{ $page['props']['description'] }}@endisset">


        <!-- Get CSRF -->
        <script>
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        </script>
        <!-- End Get CSRF -->

        <!-- Favicon -->
        <link rel="icon" href="@if(isset($favicon)) {{ asset($favicon) }} @else {{ asset('images/company_logo.png') }}@endif" type="image/x-icon"/>
        <link rel="apple-touch-icon" sizes="180x180" href="@if(isset($favicon)) {{ asset($favicon) }}@else {{ asset('images/company_logo.png') }}@endif">
        <link rel="icon" type="image/svg" href="@if(isset($favicon)) {{ asset($favicon) }}@else {{ asset('images/company_logo.png') }}@endif" sizes="32x32">
        <link rel="icon" type="image/svg" href="@if(isset($favicon)) {{ asset($favicon) }}@else {{ asset('images/company_logo.png') }}@endif" sizes="16x16">
        <link rel="mask-icon" href="@if(isset($favicon)) {{ asset($favicon) }}@else {{ asset('images/company_logo.png') }}@endif" color="#ffffff">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        <link href="{{ asset('fonts/fontawesome-free-5.13.0-web/css/all.min.css')}}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    

        <!-- Scripts -->
        @routes
        <script src="{{ mix('js/app.js') }}" defer></script>
        <script src="https://js.paystack.co/v2/inline.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
    <!-- Response Messages -->
    @if (Session::has('success'))
    <script>
        toastr.options.timeOut = 0;
            toastr.options.extendedTimeOut = 0;
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;
    toastr.success("{{ Session::get('success') }}");
    </script>
    @endif
    @if (Session::has('error'))
    <script>
        toastr.options.timeOut = 0;
            toastr.options.extendedTimeOut = 0;
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;
    toastr.error("{{ Session::get('error') }}");
    </script>
    @endif
    @if ($errors->any())
    @foreach ($errors->all() as $error)
        <script>
            toastr.options.timeOut = 0;
            toastr.options.extendedTimeOut = 0;
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;
            toastr.error("{{ $error }}");
        </script>
    @endforeach
    @endif
    @if(session()->has('success_stay'))
    <script>
        toastr.options.timeOut = 0;
        toastr.options.extendedTimeOut = 0;
        toastr.options.closeButton = true;
        toastr.options.progressBar = true;
        toastr.success("{{ session()->get('success_stay') }}")
        // $('.alert-success').html("{{ session()->get('success') }}");
        // $('.alert-success').show();
        // $('.alert-x').show();
    </script>
    @endif
    <!--End Response Messages -->

</html>
