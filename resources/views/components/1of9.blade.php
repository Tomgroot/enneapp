<label class="container col-12 col-sm-4 q-1of9 d-flex mb-4">
    <input type="radio"
           @if (isset($keywords) && $keywords == true)
               name="keywords"
           @else
               name="summaries"
           @endif value="{{$key}}">
    <div class="card flex-grow-1">
        <div class="card-body @if (isset($keywords) && $keywords == true) keywords @else summaries @endif ">
            {{$slot}}
        </div>
    </div>
</label>
