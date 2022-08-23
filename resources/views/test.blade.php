<!DOCTYPE html>
<html>
<head>
    <title>Enneagram test</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" >
    <link href="{{asset('css/app.css')}}" rel="stylesheet" >
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{asset('js/bootstrap.bundle.min.js')}}" ></script>
    <script src="{{asset('js/app.js')}}" ></script>
</head>
<body>

<div class="container questions-container pt-5 pb-5">
    <form method="POST">
    @foreach ($q_1of3 as $key => $question)
        <x-1of3 key="{{ $key }}">{{ $question['title'] }}</x-1of3>
    @endforeach

    <h2 class="mb-3 mt-5">Kernwoorden (deel 2/3)</h2>
    <p>
        Je bent nu bij het tweede deel aangekomen. Lees alle kaartjes door en kies één kaartje waarvan de meeste
        woorden overeenkomen met jouw persoonlijkheid.
    </p>
    <div class="row">
        @foreach ($q_keywords as $key => $question)
            <x-1of9 key="{{ $key }}" keywords="{{true}}">
            @foreach ($question['keywords'] as $keyword)
                <div>{{$keyword}}</div>
            @endforeach
            </x-1of9>
        @endforeach
    </div>
    <h2 class="mb-3 mt-5">Omschrijving (deel 3/3)</h2>
    <p>
        Je bent nu bij het laatste deel aangekomen. Lees alle kaartjes door en kies één kaartje waarvan de meeste zinnen
        met jouw persoonlijkheid overeenkomen.
    </p>
    <div class="row">
        @foreach ($q_summaries as $key => $question)
            <x-1of9 key="{{ $key }}">{{ $question['summary'] }}</x-1of9>
        @endforeach
    </div>
    </form>
</div>

</body>
</html>
