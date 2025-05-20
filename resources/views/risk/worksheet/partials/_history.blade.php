@if (!str_contains(request()->route()->getName(), 'edit'))
    @if (
        ((role()->isRiskAdmin() || role()->isRiskOwner()) &&
            $worksheet->last_history->status == \App\Enums\DocumentStatus::DRAFT->value) ||
            (role()->isRiskOwner() &&
                in_array($worksheet->last_history->status, [
                    \App\Enums\DocumentStatus::DRAFT->value,
                    \App\Enums\DocumentStatus::ON_REVIEW->value,
                ])) ||
            role()->isAdministrator() ||
            role()->isRiskAnalis())
        <a href="{{ route('risk.worksheet.edit', $worksheet->getEncryptedId()) }}" style="min-width: 128px;"
            class="btn btn-success">
            <span><i class="ti ti-edit"></i></span>&nbsp;Update
        </a>
    @endif

    @if (role()->isAdministrator() || role()->isRiskAnalis())
        @include('risk.worksheet.partials._risk_analis')
    @endif

    @if (
        (role()->isRiskAdmin() || role()->isRiskOwner()) &&
            $worksheet->last_history->status == \App\Enums\DocumentStatus::DRAFT->value)
        @include('risk.worksheet.partials._risk_admin')
    @elseif (role()->isRiskOwner() && $worksheet->last_history->status == \App\Enums\DocumentStatus::ON_REVIEW->value)
        @include('risk.worksheet.partials._risk_owner')
    @elseif (role()->isRiskOtorisatorWorksheetApproval() &&
            $worksheet->last_history->status == \App\Enums\DocumentStatus::ON_CONFIRMATION->value)
        @include('risk.worksheet.partials._risk_otorisator')
    @endif
@endif
