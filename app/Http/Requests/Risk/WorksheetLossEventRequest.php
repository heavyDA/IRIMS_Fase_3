<?php

namespace App\Http\Requests\Risk;

use Illuminate\Foundation\Http\FormRequest;

class WorksheetLossEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'worksheet_id' => ['required', 'numeric', 'exists:ra_worksheets,id'],
            'incident_body' => 'nullable',
            'incident_date' => 'nullable|date',
            'incident_source' => 'nullable',
            'incident_handling' => 'nullable',
            'risk_category_t2_id' => 'nullable|exists:m_kbumn_risk_categories,id',
            'risk_category_t3_id' => 'nullable|exists:m_kbumn_risk_categories,id',
            'loss_value' => 'nullable|numeric',
            'related_party' => 'nullable',
            'restoration_status' => 'nullable',
            'insurance_status' => 'nullable|boolean',
            'insurance_permit' => 'nullable|numeric',
            'insurance_claim' => 'nullable|numeric',
        ];
    }

    public function attributes()
    {
        return [
            'worksheet_id' => 'Profil Risiko',
            'incident_body' => 'Peristiwa Risiko',
            'incident_date' => 'Waktu Kejadian',
            'incident_source' => 'Sumber Penyebab Kejadian',
            'incident_handling' => 'Perlakuan atas Kejadian',
            'risk_category_t2_id' => 'Kategori Risiko T2',
            'risk_category_t3_id' => 'Kategori Risiko T3',
            'loss_value' => 'Nilai Kerugian',
            'related_party' => 'Pihak Terkait',
            'restoration_status' => 'Status Pemulihan Saat Ini',
            'insurance_status' => 'Status Asuransi',
            'insurance_permit' => 'Nilai Premi',
            'insurance_claim' => 'Nilai Klaim',
        ];
    }
}
