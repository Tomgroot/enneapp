<!DOCTYPE html>
<html>
<head>
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" >
    <script src="{{asset('js/bootstrap.bundle.min.js')}}" ></script>
</head>
<body>

@foreach ($questions as $key => $question)
    <x-1of3 key="{{ $key }}">{{ $question['title'] }}</x-1of3>
@endforeach

</body>
</html>
