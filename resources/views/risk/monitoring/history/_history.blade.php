@if (!str_contains(request()->route()->getName(), 'edit'))
    @if ($monitoring->status === \App\Enums\DocumentStatus::DRAFT->value)
        @if (role()->isRiskAdmin() || role()->isRiskOwner())
            @include('risk.monitoring.history._risk_admin')
        @endif
    @elseif (role()->isRiskOwner() && $monitoring->status === \App\Enums\DocumentStatus::ON_REVIEW->value)
        @include('risk.monitoring.history._risk_owner')
    @elseif (
        \App\Models\RBAC\Role::risk_otorisator_worksheet_approval() &&
            $monitoring->status === \App\Enums\DocumentStatus::ON_CONFIRMATION->value)
        @include('risk.monitoring.history._risk_otorisator')
    @elseif(role()->isAdministrator() || role()->isRiskAnalis())
        @include('risk.monitoring.history._risk_analis')
    @endif
@endif
