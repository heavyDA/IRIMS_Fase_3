<a data-worksheet_number="{{ $worksheet->worksheet_number }}"
    href="{{ route('risk.assessment.worksheet.show', $worksheet->encrypted_id) }}"
    class="btn btn-lg btn-{{ $class }} text-capitalize" style="min-width: 165px;">
    {{ $status }}
</a>
