@hasanyrole('root|risk analis|root')
    @include('risk.worksheet.partials._risk_analis')
@else
    @if (!str_contains(request()->route()->getName(), 'edit'))
        @if (
            (session()->get('current_role')?->name == 'risk admin' && $worksheet->last_history->status == 'draft') ||
                (session()->get('current_role')?->name == 'risk owner' &&
                    in_array($worksheet->last_history->status, ['draft', 'on review'])) ||
                session()->get('current_role')?->name == 'risk analis')
            <a href="{{ route('risk.worksheet.edit', $worksheet->getEncryptedId()) }}" style="min-width: 128px;"
                class="btn btn-success">
                <span><i class="ti ti-edit"></i></span>&nbsp;Update
            </a>
        @endif
        @if (in_array(session()->get('current_role')?->name, ['risk admin', 'risk owner']) &&
                $worksheet->last_history->status == 'draft')
            @include('risk.worksheet.partials._risk_admin')
        @elseif (session()->get('current_role')?->name == 'risk owner' && $worksheet->last_history->status == 'on review')
            @include('risk.worksheet.partials._risk_owner')
        @elseif (
            \App\Models\RBAC\Role::risk_otorisator_worksheet_approval() &&
                $worksheet->last_history->status == 'on confirmation')
            @include('risk.worksheet.partials._risk_otorisator')
        @endif
    @endif
@endhasanyrole
