@hasanyrole('superadmin|risk analis|root')
    @include('risk.monitoring.history._risk_analis')
@else
    @if (!str_contains(request()->route()->getName(), 'edit'))
        @if (
            (session()->get('current_role')?->name == 'risk admin' && $monitoring->status == 'draft') ||
                (session()->get('current_role')?->name == 'risk owner' &&
                    in_array($monitoring->status, ['draft', 'on review'])) ||
                session()->get('current_role')?->name == 'risk analis')
            <a href="{{ route('risk.worksheet.edit', $monitoring->getEncryptedId()) }}" style="min-width: 128px;"
                class="btn btn-success">
                <span><i class="ti ti-edit"></i></span>&nbsp;Update
            </a>
        @endif
        @if ($monitoring->status == 'draft')
            @hasanyrole('risk admin|risk owner')
                @include('risk.monitoring.history._risk_admin')
            @endhasanyrole
        @elseif (session()->get('current_role')?->name == 'risk owner' && $monitoring->status == 'on review')
            @include('risk.monitoring.history._risk_owner')
        @elseif (
            \App\Models\RBAC\Role::risk_otorisator_worksheet_approval() &&
                $monitoring->status == 'on confirmation')
            @include('risk.monitoring.history._risk_otorisator')
        @endif
    @endif
@endhasanyrole
