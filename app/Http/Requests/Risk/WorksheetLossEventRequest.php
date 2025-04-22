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
            'incident_body' => 'required',
            'incident_identification' => 'required',
            'incident_category_id' => 'requried|exists:m_incident_categories,id',
            'incident_source' => 'nullable',
            'incident_cause' => 'nullable',
            'incident_handling' => 'nullable',
            'incident_description' => 'nullable',
            'risk_category' => 'nullable|exists:m_kbumn_risk_categories,id',
            'risk_category_t2_id' => 'nullable|exists:m_kbumn_risk_categories,id',
            'risk_category_t3_id' => 'nullable|exists:m_kbumn_risk_categories,id',
            'loss_description' => 'nullable',
            'loss_value' => 'nullable|numeric',
            'incident_repetitive' => 'nullable|boolean',
            'incident_frequency_id' => 'required_if:incident_repetitive,1',
            'mitigation_plan' => 'nullable',
            'actualization_plan' => 'nullable',
            'follow_up_plan' => 'nullable',
            'related_party' => 'nullable',
            'insurance_status' => 'required|boolean',
            'insurance_permit' => 'nullable|numeric',
            'insurance_claim' => 'nullable|numeric',
        ];
    }

    public function attributes()
    {
        return [
            'worksheet_id' => 'Profil Risiko',
            'incident_body' => 'Nama Kejadian',
            'incident_identification' => 'Identifikasi Kejadian',
            'incident_category_id' => 'Kategori Kejadian',
            'incident_source' => 'Sumber Penyebab Kejadian',
            'incident_cause' => 'Penyebab Kejadian',
            'incident_handling' => 'Penanganan Saat Kejadian',
            'incident_description' => 'Deskripsi Kejadian',
            'risk_category' => 'Kategori Risiko T2 & T3',
            'risk_category_t2_id' => 'Kategori Risiko T2',
            'risk_category_t3_id' => 'Kategori Risiko T3',
            'loss_description' => 'Penjelasan Kerugian',
            'loss_value' => 'Nilai Kerugian',
            'incident_repetitive' => 'Kejadian Berulang',
            'incident_frequency_id' => 'Frekuensi Kejadian',
            'mitigation_plan' => 'Mitigasi yang Direncanakan',
            'actualization_plan' => 'Realisasi Mitigasi',
            'follow_up_plan' => 'Perbaikan Mendatang',
            'related_party' => 'Pihak Terkait',
            'insurance_status' => 'Status Asuransi',
            'insurance_permit' => 'Nilai Premi',
            'insurance_claim' => 'Nilai Klaim',
        ];
    }
}
