import { formatNumeral, unformatNumeral } from "cleave-zen";
import { defaultConfigChoices, defaultConfigFormatNumeral, defaultConfigQuill } from "~js/components/helper";
import Choices from "choices.js";
import Quill from "quill";
import "quill/dist/quill.snow.css";
import "~css/quill.css";
import flatpickr from "flatpickr";
import { defaultLocaleFlatpickr } from "~js/components/helper";

const lossEventForm = document.querySelector('#loss-event-form');

const incidentDate = lossEventForm.querySelector('input[name="incident_date"]');
const incidentDatePicker = flatpickr(incidentDate, { ...defaultLocaleFlatpickr, dateFormat: 'Z', enableTime: true, altFormat: 'd M Y H:i', altInput: true, time_24hr: true });

const selects = lossEventForm.querySelectorAll('select');
const choices = [];

for (const select of selects) {
    choices[select.name] = new Choices(select, defaultConfigChoices);
}

choices['risk_category_t3_id'].disable();

const textareas = lossEventForm.querySelectorAll('textarea');
const textareaEditors = [];

for (const textarea of textareas) {
    textareaEditors[textarea.name] = new Quill(`#${textarea.name}-editor`, defaultConfigQuill)
    textareaEditors[textarea.name].root.innerHTML = textarea.value;
    textareaEditors[textarea.name].on("text-change", (delta, oldDelta, source) => {
        textarea.value = textareaEditors[textarea.name].root.innerHTML;
    })
}

const riskCategoryT3 = choices['risk_category_t3_id']._currentState.choices
choices['risk_category_t2_id'].passedElement.element.addEventListener(
    'change',
    function (e) {
        const value = choices['risk_category_t2_id'].getValue(true);
        if (value != 'Pilih') {
            choices['risk_category_t3_id'].clearChoices();
            choices['risk_category_t3_id'].setChoices(
                riskCategoryT3.filter(item => item.customProperties.parent == value)
            ).enable();
        } else {
            choices['risk_category_t3_id'].clearChoices();
            choices['risk_category_t3_id']
                .disable()
                .setChoiceByValue('');
        }
    },
);

if (choices['risk_category_t2_id'].getValue(true) != 'Pilih') {
    choices['risk_category_t2_id'].passedElement.element.dispatchEvent(new Event('change'));
}

const lossValueInput = lossEventForm.querySelector('input[name="loss_value"]');
const lossValueFormatInput = lossEventForm.querySelector('input[name="loss_value_format"]');

const insurancePermitInput = lossEventForm.querySelector('input[name="insurance_permit"]');
const insurancePermitFormatInput = lossEventForm.querySelector('input[name="insurance_permit_format"]');

const insuranceClaimInput = lossEventForm.querySelector('input[name="insurance_claim"]');
const insuranceClaimFormatInput = lossEventForm.querySelector('input[name="insurance_claim_format"]');

lossValueFormatInput.addEventListener('input', (e) => {
    e.target.value = formatNumeral(e.target.value, defaultConfigFormatNumeral);
    lossValueInput.value = unformatNumeral(e.target.value, defaultConfigFormatNumeral);
})

insurancePermitFormatInput.addEventListener('input', (e) => {
    e.target.value = formatNumeral(e.target.value, defaultConfigFormatNumeral);
    insurancePermitInput.value = unformatNumeral(e.target.value, defaultConfigFormatNumeral);
})

insuranceClaimFormatInput.addEventListener('input', (e) => {
    e.target.value = formatNumeral(e.target.value, defaultConfigFormatNumeral);
    insuranceClaimInput.value = unformatNumeral(e.target.value, defaultConfigFormatNumeral);
})

document.addEventListener('DOMContentLoaded', () => {
    lossValueFormatInput.value = formatNumeral(lossValueInput.value, defaultConfigFormatNumeral);
    insurancePermitFormatInput.value = formatNumeral(insurancePermitInput.value, defaultConfigFormatNumeral);
    insuranceClaimFormatInput.value = formatNumeral(insuranceClaimInput.value, defaultConfigFormatNumeral);
})