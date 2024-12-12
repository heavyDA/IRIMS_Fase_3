<div class="alert alert-{{$state->value}} d-flex align-items-center" role="alert">
    @if ($withIcon)
        <i class="fs-4 ti ti-{{$state->icon()}}"></i>
    @endif
    <div>
        {{ $message }}
    </div>
</div>