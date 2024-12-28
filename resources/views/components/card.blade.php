@props(['header', 'footer', 'body'])

<div class="card custom-card">
    @isset($header)
        <div class="card-header">
            {{ $header }}
        </div>
    @endisset

    @isset($body)
        <div class="card-content">
            <div class="card-body">{{ $body }}</div>
        </div>
    @endisset

    @isset($footer)
        <div class="card-footer">
            {{ $footer }}
        </div>
    @endisset
</div>
