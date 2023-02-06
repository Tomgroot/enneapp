<!DOCTYPE html>
<html>
<head>
    <title>Gratis enneagram persoonlijkheidstest</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" >
    <link href="{{asset('css/app.css')}}" rel="stylesheet" >
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{asset('js/bootstrap.bundle.min.js')}}" ></script>
    <script src="{{asset('js/app.js')}}" ></script>
</head>
<body>


<div class="text-center test-header">
    <a href="https://identiteitssystemen.nl/">&lsaquo; Terug naar identiteitssystemen.nl</a>
    <div class="container">
        <h1 class="display-5 fw-bold mb-4">Gratis enneagram persoonlijkheidstest</h1>
        <p class="description">Ontdek welk type jij bent door deze test in te vullen. Bij het eerste deel
            (van totaal drie delen) kies je of de stelling bij jouw persoonlijkheid past, of niet.
            Probeer niet te lang stil te staan bij elke vraag. Volg je eerste ingeving.</p>
    </div>
</div>

<div class="container questions-container">
    <form action="{{ route('result') }}" method="POST">
        <div>
            @foreach ($q_scale as $key => $question)
                <x-scale key="{{ $key }}">{{ $question['title'] }}</x-scale>
            @endforeach
            <div class="test-section">
                <h2 class="mb-3 mt-5 fw-bold">Kernwoorden (deel 2/3)</h2>
                <p class="description">
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
            </div>
            <div class="test-section">
                <h2 class="mb-3 mt-5 fw-bold">Omschrijving (deel 3/3)</h2>
                <p class="description">
                    Je bent nu bij het laatste deel aangekomen. Lees alle kaartjes door en kies één kaartje waarvan de meeste zinnen
                    met jouw persoonlijkheid overeenkomen.
                </p>
                <div class="row">
                    @foreach ($q_summaries as $key => $question)
                        <x-1of9 key="{{ $key }}">{{ $question['summary'] }}</x-1of9>
                    @endforeach
                </div>
                <input type="hidden" value="{{$keys}}" name="keys">
            </div>
        </div>
        <button type="submit" class="btn btn-success btn-send">Ontdek wat voor type je bent &rsaquo;</button>
    </form>
</div>

</body>
</html>
