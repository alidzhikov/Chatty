<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chatty</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
    @include('templates.partials.navigation')
    <div class="container">
        @include('templates.partials.alerts')
        @yield('content')
    </div>
</body>
<script type="text/javascript" src="https://unpkg.com/vue"></script>
<script type="text/javascript" src="{{ URL::asset('js/timeline.js') }}"></script>
</html>
