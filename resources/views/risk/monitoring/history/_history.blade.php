@if (in_array(session()->get('current_role')?->name, ['root', 'administrator', 'risk analis']))
    @include('risk.monitoring.history._risk_analis')
@else
    @if (!str_contains(request()->route()->getName(), 'edit'))
        @if ($monitoring->status == 'draft')
            @if (in_array(session()->get('current_role')?->name, ['risk admin', 'risk owner']))
                @include('risk.monitoring.history._risk_admin')
            @endif
        @elseif (session()->get('current_role')?->name == 'risk owner' && $monitoring->status == 'on review')
            @include('risk.monitoring.history._risk_owner')
        @elseif (\App\Models\RBAC\Role::risk_otorisator_worksheet_approval() && $monitoring->status == 'on confirmation')
            @include('risk.monitoring.history._risk_otorisator')
        @endif
    @endif
@endif
