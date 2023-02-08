<div class="q-1of3">
    <div class="title mb-4">{{ $slot }}</div>
    <div class="container">
        <label>
            <input type="radio" name="scale-{{$key}}" value="1">
            <div class="checkmark"></div>
            <div class="checkmark-title">Eens</div>
        </label>
        <label>
            <input type="radio" name="scale-{{$key}}" value="0">
            <div class="checkmark"></div>
            <div class="checkmark-title">Neutraal</div>
        </label>
        <label>
            <input type="radio" name="scale-{{$key}}" value="0">
            <div class="checkmark"></div>
            <div class="checkmark-title">Oneens</div>
        </label>
    </div>
</div>
