<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
@vite('resources/sass/app.scss')
</head>
<body>
<div id="app">
    <app question-data-raw="{{$raw_question_data}}"></app>
</div>
@vite('resources/js/app.js')
</body>
</html>
