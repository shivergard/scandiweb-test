<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Time Log App</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="/css/app.css">
    </head>
    <body>
        <h1>My time log</h1>
        <div id="app"></div>

        <script src="/js/bundle.js"></script>
    </body>
</html>
