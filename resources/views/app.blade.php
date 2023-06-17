<html>
<head>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    {{-- <link rel="icon" href="/assets/img/tradoclogo.png"> --}}
    <title>{{env('APP_NAME')}}</title>
</head>
<body>
    <div id="app">
        <App />
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>