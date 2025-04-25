<?php

namespace App\Http\Requests\Risk;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorksheetRequest extends FormRequest
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
            'context' => 'required|array',
            'context.target_body' => 'required',
            'context.risk_number' => 'required',

            'identification' => 'required|array',
            'identification.risk_category_t2' => 'required|numeric',
            'identification.risk_category_t3' => 'required|numeric',
            'identification.risk_chronology_body' => 'required',
            'identification.risk_chronology_description' => 'required',
            'identification.existing_control_type' => 'required|numeric',
            'identification.existing_control_body' => 'required',
            'identification.control_effectiveness_assessment' => 'required|numeric',
            'identification.risk_impact_category' => 'required',
            'identification.risk_impact_body' => 'required',
            'identification.risk_impact_start_date' => 'required|date',
            'identification.risk_impact_end_date' => 'required|date',
            'identification.inherent_body' => 'required',
            'identification.inherent_impact_value' => 'required_if:identification.risk_impact_category,=,kuantitatif|nullable|numeric',
            'identification.inherent_impact_scale' => 'required|numeric',
            'identification.inherent_impact_probability' => 'required|numeric',
            'identification.inherent_impact_probability_scale' => 'required|numeric',
            'identification.inherent_risk_exposure' => 'nullable|numeric',

            'identification.residual' => 'required|array',
            'identification.residual.1' => 'required|array',
            'identification.residual.2' => 'required|array',
            'identification.residual.3' => 'required|array',
            'identification.residual.4' => 'required|array',
            'identification.residual.1.impact_value' => 'required_if:identification.risk_impact_category,=,kuantitatif|nullable|numeric',
            'identification.residual.1.impact_scale' => 'required|numeric',
            'identification.residual.1.impact_probability' => 'required|numeric',
            'identification.residual.1.impact_probability_scale' => 'required|numeric',
            'identification.residual.1.risk_exposure' => 'required|numeric',
            'identification.residual.2.impact_value' => 'required_if:identification.risk_impact_category,=,kuantitatif|nullable|numeric',
            'identification.residual.2.impact_scale' => 'required|numeric',
            'identification.residual.2.impact_probability' => 'required|numeric',
            'identification.residual.2.impact_probability_scale' => 'required|numeric',
            'identification.residual.2.risk_exposure' => 'required|numeric',
            'identification.residual.3.impact_value' => 'required_if:identification.risk_impact_category,=,kuantitatif|nullable|numeric',
            'identification.residual.3.impact_scale' => 'required|numeric',
            'identification.residual.3.impact_probability' => 'required|numeric',
            'identification.residual.3.impact_probability_scale' => 'required|numeric',
            'identification.residual.3.risk_exposure' => 'required|numeric',
            'identification.residual.4.impact_value' => 'required_if:identification.risk_impact_category,=,kuantitatif|nullable|numeric',
            'identification.residual.4.impact_scale' => 'required|numeric',
            'identification.residual.4.impact_probability' => 'required|numeric',
            'identification.residual.4.impact_probability_scale' => 'required|numeric',
            'identification.residual.4.risk_exposure' => 'required|numeric',

            'incidents' => 'required|array',
            'incidents.*' => 'required|array',
            'incidents.*.id' => 'nullable|numeric',
            'incidents.*.risk_cause_number' => 'required',
            'incidents.*.risk_cause_code' => 'required',
            'incidents.*.risk_cause_body' => 'required',
            'incidents.*.kri_body' => 'required',
            'incidents.*.kri_unit' => 'required|numeric',
            'incidents.*.kri_threshold_safe' => 'required',
            'incidents.*.kri_threshold_caution' => 'required',
            'incidents.*.kri_threshold_danger' => 'required',

            'strategies' => 'required|array',
            'strategies.*' => 'required|array',
            'strategies.*.id' => 'nullable|numeric',
            'strategies.*.strategy_body' => 'required',
            'strategies.*.strategy_expected_feedback' => 'nullable',
            'strategies.*.strategy_risk_value' => 'nullable',
            'strategies.*.strategy_risk_value_limit' => 'required|numeric',
            'strategies.*.strategy_decision' => 'required|in:accept,avoid',

            'mitigations' => 'required|array',
            'mitigations.*' => 'required|array',
            'mitigations.*.id' => 'nullable|numeric',
            'mitigations.*.risk_cause_number' => 'required|in:a,b,c,d,e',
            'mitigations.*.risk_treatment_option' => 'required|numeric',
            'mitigations.*.risk_treatment_type' => 'required|numeric',
            'mitigations.*.mitigation_plan' => 'required',
            'mitigations.*.mitigation_output' => 'required',
            'mitigations.*.mitigation_start_date' => 'required|date',
            'mitigations.*.mitigation_end_date' => 'required|date',
            'mitigations.*.mitigation_cost' => 'required|numeric',
            'mitigations.*.mitigation_rkap_program_type' => 'required|numeric',
            'mitigations.*.mitigation_pic' => 'required',
            'mitigations.*.organization_code' => 'required',
            'mitigations.*.organization_name' => 'required',
            'mitigations.*.unit_code' => 'required',
            'mitigations.*.unit_name' => 'required',
            'mitigations.*.sub_unit_code' => 'required',
            'mitigations.*.sub_unit_name' => 'required',
            'mitigations.*.personnel_area_code' => 'required',
            'mitigations.*.personnel_area_name' => 'required',
            'mitigations.*.position_name' => 'required',

        ];
    }
}
