<div class="btn-group mb-1">
    <div class="dropdown icon-right">
        <button class="btn btn-sm btn-primary me-1" type="button" data-bs-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false"><i class="ti ti-dots"></i>
        </button>
        <div class="dropdown-menu">
            @foreach ($actions as $action)
                @if (array_key_exists('type', $action))
                    @if ($action['type'] === 'delete')
                        @canany ($action['permission'], 'root', 'administrator')
                            <form class="d-none" method="POST" action="{{ $action['route'] }}"
                                id="action-form-{{ $action['id'] }}">
                                @method('DELETE')
                                @csrf
                            </form>
                            <button form="action-form-{{ $action['id'] }}"
                                onclick="confirm('hapus data ini?') ? true : event.preventDefault()"
                                class="dropdown-item justify-content-between text-capitalize btn btn-danger text-white"
                                type="submit"><span><i class="ti ti-trash"></i></span>{{ $action['text'] }}</button>
                        @endcanany
                    @else
                        @if ($action['type'] == 'link')
                            @canany ($action['permission'], 'root', 'administrator')
                                <a class="dropdown-item text-capitalize justify-content-between {{ $action['class'] ?? ''}}"
                                    href="{{ $action['route'] }}">
                                    @isset($action['icon'])
                                        <span><i class="{{ $action['icon'] }}"></i></span>
                                    @else
                                        @if (str_contains($action['route'], 'edit'))
                                            <span><i class="ti ti-pencil"></i></span>
                                        @elseif (str_contains($action['route'], 'show'))
                                            <span><i class="ti ti-eye"></i></span>
                                        @endif
                                    @endisset
                                    {{ $action['text'] }}
                                </a>
                            @endcanany
                        @endif
                    @endif
                @endif
            @endforeach
        </div>
    </div>
</div>
