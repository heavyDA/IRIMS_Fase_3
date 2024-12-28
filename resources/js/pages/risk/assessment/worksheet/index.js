import { Modal, Tab } from "bootstrap";
import { formatNumeral, unformatNumeral } from "cleave-zen";
import Choices from "choices.js";
import Quill from "quill";
import 'quill/dist/quill.snow.css';
import 'css/quill.css';
import flatpickr from "flatpickr";
import debounce from "js/utils/debounce";
import axios from "axios";
import dayjs from "dayjs";
import 'dayjs/locale/id';
import { formatDataToStructuredObject } from "js/components/helper";

dayjs.locale('id');

let currentStep = 0;
const totalStep = 4;

const worksheetTab = document.querySelector('#worksheetTab');
const worksheetTabNavs = worksheetTab.querySelectorAll('a');

worksheetTabNavs.forEach((trigger, index) => {
    trigger.addEventListener('click', e => {
        if (index !== currentStep) {
            e.preventDefault(); // Prevent Bootstrap's default behavior
            e.stopPropagation(); // Stop event bubbling
        }
    });
})
const navigateToTab = (index) => {
    const nextTab = worksheetTabNavs[index];
    if (nextTab) {
        // Activate the target tab
        const tabInstance = new Tab(nextTab);
        tabInstance.show();
        currentStep = index;
    }
};

const worksheetTabNextButton = document.querySelector('#worksheetTabNextButton');
const worksheetTabPreviousButton = document.querySelector('#worksheetTabPreviousButton');
const worksheetTabSubmitButton = document.querySelector('#worksheetTabSubmitButton');

worksheetTabNextButton.addEventListener('click', e => {
    const click = new Event('click')

    currentStep += 1;
    if (currentStep > 0 && worksheetTabPreviousButton.classList.contains('d-none')) {
        worksheetTabPreviousButton.classList.remove('d-none');
    }

    if (currentStep == totalStep - 1 && worksheetTabSubmitButton.classList.contains('d-none')) {
        worksheetTabSubmitButton.classList.remove('d-none');
        worksheetTabNextButton.classList.add('d-none');
    }
    navigateToTab(currentStep);
})

worksheetTabPreviousButton.addEventListener('click', e => {
    const click = new Event('click')

    currentStep -= 1;
    if (currentStep == 0 && !worksheetTabPreviousButton.classList.contains('d-none')) {
        worksheetTabPreviousButton.classList.add('d-none');
    }

    if (currentStep < totalStep - 1) {
        if (!worksheetTabSubmitButton.classList.contains('d-none')) {
            worksheetTabSubmitButton.classList.add('d-none')
        }

        worksheetTabNextButton.classList.remove('d-none')
    }
    navigateToTab(currentStep)
})

/** End of stepper */

const worksheet = {
    target_body: '',
    strategies: [],
    identifications: [],
    mitigations: [],
};

const bumnScales = [];
const heatmaps = [];
const kriUnits = [];
const existingControlTypes = [];
const risk_numbers = ['a', 'b', 'c', 'd', 'e'];

await axios.get('/master/bumn-scale').then(res => res.status == 200 ? bumnScales.push(...res.data.data) : null).catch(err => console.log(err));
await axios.get('/master/heatmap').then(res => res.status == 200 ? heatmaps.push(...res.data.data) : null).catch(err => console.log(err));
await axios.get('/master/kri-unit').then(res => res.status == 200 ? kriUnits.push(...res.data.data) : null).catch(err => console.log(err));
await axios.get('/master/existing-control-type').then(res => res.status == 200 ? existingControlTypes.push(...res.data.data) : null).catch(err => console.log(err));


const configFormatNumeral = { prefix: 'Rp.', delimiter: '.', numeralPositiveOnly: true, numeralDecimalMark: ',' }
const configQuill = {
    height: 120,
    modules: {
        toolbar: [
            ['bold', 'italic', 'underline', 'strike'],
            [{ 'align': [] }],
            [{ 'indent': '-1' }, { 'indent': '+1' }],
        ]
    },
    theme: 'snow'
};
const configChoices = {
    classNames: { containerOuter: 'choices flex-grow-1' },
    removeItems: false,
    removeItemButton: false,
    shouldSort: false,
    duplicateItemsAllowed: false,
    placeholder: true,
    placeholderValue: null,
    allowHTML: true,
}

const localeFlatpickr = {
    firstDayOfWeek: 1,
    weekdays: {
        shorthand: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
        longhand: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
    },
    months: {
        shorthand: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
        longhand: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
    }
}

const tables = {
    strategies: document.querySelector('#worksheetStrategyTable'),
    identifications: document.querySelector('#worksheetIdentificationTable'),
    mitigations: document.querySelector('#worksheetMitigationTable')
}

const contextForm = document.querySelector('#contextForm');
const targetBody = contextForm.querySelector('[name="target_body"]');
const targetBodyQuill = new Quill(contextForm.querySelector('#target_body-editor'), configQuill);
targetBodyQuill.on('text-change', (delta, oldDelta, source) => {
    targetBody.innerHTML = targetBodyQuill.root.innerHTML;

    identificationTargetBodyQuill.root.innerHTML = targetBodyQuill.root.innerHTML;
    identificationTargetBody.innerHTML = targetBodyQuill.root.innerHTML;
});

const strategyModalElement = document.querySelector('#strategyModal');
const strategyModal = new Modal(strategyModalElement);
const strategyForm = document.querySelector('#strategyForm');
const strategyTextareas = {};
for (let t of strategyForm.querySelectorAll('textarea')) {
    strategyTextareas[t.name] = t;
}
const strategyQuills = {};
for (let editor of strategyForm.querySelectorAll('.textarea')) {
    strategyQuills[editor.id.replaceAll('-editor', '')] = new Quill(editor, configQuill);
    strategyQuills[editor.id.replaceAll('-editor', '')].on('text-change', (delta, oldDelta, source) => {
        strategyTextareas[editor.id.replaceAll('-editor', '')].innerHTML = strategyQuills[editor.id.replaceAll('-editor', '')].root.innerHTML;
    })
}

const strategyRiskValueLimit = strategyForm.querySelector('[name="strategy_risk_value_limit"]')
strategyRiskValueLimit.addEventListener('input', (e) => {
    e.target.value = formatNumeral(e.target.value, configFormatNumeral);
})

const strategyDecision = strategyForm.querySelector('[name="strategy_decision"]');
let strategyDecisionChoices = new Choices(strategyDecision, configChoices);

// type = strategies | identifications | mitigations
const addRowAction = (type, index, callback) => {
    const removeButton = document.createElement('button');
    const editButton = document.createElement('button');

    removeButton.type = 'button';
    removeButton.classList.add('btn', 'btn-sm', 'btn-danger', 'm-1');
    removeButton.innerHTML = `<i class="ti ti-x"></i>`;

    removeButton.addEventListener('click', () => {
        tables[type].querySelector('tbody').children[index].remove();
        worksheet[type].splice(index, 1);
    })

    editButton.type = 'button';
    editButton.classList.add('btn', 'btn-sm', 'btn-primary', 'm-1');
    editButton.innerHTML = `<i class="ti ti-edit"></i>`;

    editButton.addEventListener('click', () => {
        const data = worksheet[type][index]
        callback(data);
    })

    return [
        removeButton,
        editButton
    ]
}

const addStrategyRow = (data) => {
    const body = tables.strategies.querySelector('tbody');
    const row = document.createElement('tr');
    const [removeButton, editButton] = addRowAction('strategies', worksheet.strategies.length - 1, (data) => onStrategyEdit(data));
    const buttonCell = document.createElement('td');

    row.id = `strategy-${data.key}`;
    row.innerHTML = `
        <td>${data.strategy_body}</td>
        <td>${data.strategy_expected_feedback}</td>
        <td>${data.strategy_risk_value}</td>
        <td>${formatNumeral(data.strategy_risk_value_limit, configFormatNumeral)}</td>
        <td>${data.strategy_decision}</td>
    `;
    buttonCell.appendChild(editButton);
    buttonCell.appendChild(removeButton);
    row.prepend(buttonCell);
    body.appendChild(row);
}

const updateStrategyRow = (data) => {
    const row = tables.strategies.querySelector(`#strategy-${data.key}`);
    row.querySelector('td:nth-child(2)').innerHTML = data.strategy_body;
    row.querySelector('td:nth-child(3)').innerHTML = data.strategy_expected_feedback;
    row.querySelector('td:nth-child(4)').innerHTML = data.strategy_risk_value;
    row.querySelector('td:nth-child(5)').innerHTML = formatNumeral(data.strategy_risk_value_limit.toString(), configFormatNumeral);
    row.querySelector('td:nth-child(6)').innerHTML = data.strategy_decision;
}

const onStrategySave = (data) => {
    data.strategy_risk_value_limit = unformatNumeral(data.strategy_risk_value_limit, configFormatNumeral).replaceAll('.', ',');
    if (data.key) {
        worksheet.strategies[worksheet.strategies.findIndex(item => item.key == data.key)] = data;
        updateStrategyRow(data)
    } else {
        data.key = worksheet.strategies.length + 1;
        worksheet.strategies.push(data);
        addStrategyRow(data);
    }
    strategyModal.hide();
}

const onStrategyEdit = (data) => {
    strategyForm.querySelector('[name="key"]').value = data.key;
    strategyQuills['strategy_body'].root.innerHTML = data.strategy_body;
    strategyQuills['strategy_expected_feedback'].root.innerHTML = data.strategy_expected_feedback;
    strategyQuills['strategy_risk_value'].root.innerHTML = data.strategy_risk_value;
    strategyRiskValueLimit.value = formatNumeral(data.strategy_risk_value_limit, configFormatNumeral);
    strategyDecisionChoices.setChoiceByValue(data.strategy_decision);

    strategyModal.show();
}

strategyForm.addEventListener('submit', (e) => {
    e.preventDefault();

    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData)
    if (data.hasOwnProperty('search_terms')) {
        delete data.search_terms;
    }
    onStrategySave(data);
});

strategyModalElement.addEventListener('hidden.bs.modal', () => {
    strategyForm.reset();
    strategyForm.querySelector('[name="key"]').value = '';

    strategyRiskValueLimit.value = '';
    strategyDecisionChoices.destroy();
    strategyDecisionChoices = new Choices(strategyDecision, configChoices);


    Object.keys(strategyTextareas).forEach((key) => {
        strategyTextareas[key].innerHTML = '';
        strategyQuills[key].deleteText(0, strategyQuills[key].getLength());
    });
});


const identificationForm = document.querySelector('#identificationForm');
const identificationCauseForm = document.querySelector('#identificationCauseForm');
const identificationModalElement = document.querySelector('#identificationModal');
const identificationModal = new Modal(identificationModalElement);
const identificationDateRange = document.querySelector('#risk_impact_date-picker');

const identificationStartDate = identificationCauseForm.querySelector('[name="risk_impact_start_date"]');
const identificationEndDate = identificationCauseForm.querySelector('[name="risk_impact_end_date"]');

const identificationKBUMNTarget = document.querySelector('[name="kbumn_target"]');
const identificationRiskCategory = document.querySelector('[name="kbumn_risk_category"]');
const identificationRiskCategoryT2 = document.querySelector('[name="kbumn_risk_category_t2"]');
const identificationRiskCategoryT3 = document.querySelector('[name="kbumn_risk_category_t3"]');

const identificationKBUMNTargetChoices = new Choices(identificationKBUMNTarget, configChoices);
const identificationRiskCategoryChoices = new Choices(identificationRiskCategory, configChoices);
const identificationRiskCategoryT2Choices = new Choices(identificationRiskCategoryT2, configChoices);
const identificationRiskCategoryT3Choices = new Choices(identificationRiskCategoryT3, configChoices);
identificationRiskCategoryT3.addEventListener('change', e => identificationRiskCategoryChoices.setChoiceByValue(e.detail.value));

const identificationTargetBody = identificationForm.querySelector('[name="target_body"]');
const identificationTargetBodyQuill = new Quill(identificationForm.querySelector('#target_body-editor'), configQuill);
identificationTargetBodyQuill.enable(false);
identificationTargetBodyQuill.on('text-change', (delta, oldDelta, source) => {
    identificationTargetBody.innerHTML = identificationTargetBodyQuill.root.innerHTML;
});

const identificationRiskId = identificationCauseForm.querySelector('[name="identification_risk_id"]')
const identificationRiskNumber = identificationCauseForm.querySelector('[name="risk_number"]');
const identificationRiskCauseCode = identificationCauseForm.querySelector('[name="risk_cause_code"]');
const identificationSelects = {};
for (let t of identificationCauseForm.querySelectorAll('.form-select')) {
    identificationSelects[t.name] = t;
}

const identificationChoices = {};
const identificationChoicesInit = async () => {
    for (let t of identificationCauseForm.querySelectorAll('.form-select')) {
        identificationSelects[t.name] = t;
    }

    Object.keys(identificationSelects).forEach((key) => {
        const choices = [];
        const hasCustomData = identificationSelects[key].hasAttribute('data-custom');

        if (hasCustomData) {
            if (key.includes('[impact_scale]') || key == 'inherent_impact_scale') {
                for (let item of bumnScales) {
                    choices.push({
                        value: item.id,
                        label: item.scale,
                        customProperties: item
                    })
                }
            } else if (key.includes('[impact_probability_scale]') || key == 'inherent_impact_probability_scale') {
                for (let item of heatmaps) {
                    choices.push({
                        value: item.id,
                        label: item.impact_probability,
                        customProperties: item
                    })
                }
            } else if (key.includes('risk_cause_number')) {
                for (let item of risk_numbers) {
                    choices.push({
                        value: item,
                        label: item,
                    })
                }
            } else if (key.includes('existing_control_type')) {
                for (let item of existingControlTypes) {
                    choices.push({ value: item.id, label: item.name, customProperties: item })
                }
            } else if (key.includes('kri_unit')) {
                for (let item of kriUnits) {
                    choices.push({ value: item.id, label: item.name, customProperties: item })
                }
            }
        }
        identificationChoices[key] = new Choices(identificationSelects[key], { ...configChoices, choices: choices });
    });

    identificationSelects?.risk_cause_number?.addEventListener(
        'change',
        e => identificationRiskCauseCode.value = identificationRiskNumber.value + '.' + identificationChoices.risk_cause_number.getValue(true)
    )
    identificationSelects?.inherent_impact_scale?.addEventListener('change', e => {
        calculateRisk(...identificationInherentItems);
    });

    identificationSelects.risk_impact_category.addEventListener('change', e => {
        const risk_impact_category = identificationChoices.risk_impact_category.getValue(true)
        if (risk_impact_category !== "Pilih") {
            identificationChoices.inherent_impact_scale.enable();

            let choices = [];
            for (let item of bumnScales) {
                if (item.impact_category !== risk_impact_category) continue;
                choices.push({
                    id: item.id,
                    value: item.id,
                    label: item.scale,
                    customProperties: item
                })
            }

            for (let i = 1; i < 5; i++) {
                identificationChoices[`residual[${i}][impact_scale]`].clearChoices().setChoices(choices).enable();
            }
            identificationChoices.inherent_impact_scale.clearChoices().setChoices(choices);


            for (let label of identificationCauseForm.querySelectorAll('.label-category-risk')) {
                if (label.dataset[risk_impact_category]) {
                    label.innerHTML = label.dataset[risk_impact_category]
                } else {
                    label.innerHTML = risk_impact_category;
                }
            }
        } else {
            for (let label of identificationCauseForm.querySelectorAll('.label-category-risk')) {
                if (label.hasAttribute('data-kuantitatif')) {
                    label.innerHTML = 'Dampak';
                } else {
                    label.innerHTML = '';
                }
            }


            identificationChoices.inherent_impact_scale.setChoiceByValue("Pilih").disable();

            for (let i = 1; i < 5; i++) {
                identificationChoices[`residual[${i}][impact_scale]`].setChoiceByValue("Pilih").disable();
            }

            identificationChoices.inherent_impact_probability_scale.setChoiceByValue("Pilih");
        }

        calculateRisk(...identificationInherentItems);
        residualItems.forEach((item) => calculateRisk(...item))
    });
}

await identificationChoicesInit();

/**
 * Inherent Calculation
 */
const identificationInherentImpactValue = identificationCauseForm.querySelector('[name="inherent_impact_value"]');
const identificationInherentImpactProbability = identificationCauseForm.querySelector('[name="inherent_impact_probability"]');
const identificationInherentRiskExposure = identificationCauseForm.querySelector('[name="inherent_risk_exposure"]');
const identificationInherentRiskScale = identificationCauseForm.querySelector('[name="inherent_risk_scale"]');
const identificationInherentRiskLevel = identificationCauseForm.querySelector('[name="inherent_risk_level"]');

const identificationResidualImpactValueQ1 = identificationCauseForm.querySelector('[name="residual[1][impact_value]"]');
const identificationInherentItems = []

const identificationResidualItemsInit = () => {
    identificationInherentItems.splice(0, identificationInherentItems.length);
    identificationInherentItems.push(
        identificationChoices.inherent_impact_scale,
        identificationInherentImpactValue,
        identificationInherentImpactProbability,
        identificationChoices.inherent_impact_probability_scale,
        identificationInherentRiskExposure,
        identificationInherentRiskScale,
        identificationInherentRiskLevel
    )
}
identificationResidualItemsInit();

const calculateRisk = (
    targetScale,
    targetImpactValue,
    targetImpactProbability,
    targetImpactProbabilityScale,
    targetExposure,
    targetRiskScale,
    targetRiskLevel,
    isResidual = false
) => {
    let scale, probability;

    scale = targetScale.getValue(false);
    probability = targetScale._currentState.choices.find(
        choice =>
            (scale?.customProperties?.scale) &&
            parseInt(targetImpactProbability.value) >= choice.customProperties.min &&
            parseInt(targetImpactProbability.value) <= choice.customProperties.max
    )

    if (isResidual) {
        if (scale?.customProperties?.scale) {
            targetImpactValue.value = formatNumeral(
                (unformatNumeral(identificationInherentImpactValue.value, configFormatNumeral) * scale.customProperties.scale).toString().replaceAll('.', ','),
                configFormatNumeral
            );

        } else {
            targetImpactValue.value = formatNumeral("0", configFormatNumeral)
            targetExposure.value = formatNumeral("0", configFormatNumeral);
            targetRiskScale.value = null;
            targetRiskLevel.value = null;
        }
    }

    if (scale?.customProperties?.scale && probability) {
        const impactValue = parseFloat(unformatNumeral(targetImpactValue.value, configFormatNumeral));
        const probabilityValue = parseFloat(targetImpactProbability.value);

        if (impactValue && probabilityValue && identificationSelects.risk_impact_category.value == 'kuantitatif') {
            targetExposure.value = formatNumeral(
                (impactValue * (probabilityValue / 100)).toString().replaceAll('.', ','),
                configFormatNumeral
            );
        } else if (impactValue && probabilityValue && identificationSelects.risk_impact_category.value == 'kualitatif') {
            targetExposure.value = formatNumeral(
                (1 / 100 * impactValue * parseInt(scale.customProperties.scale) * (probabilityValue / 100)).toString().replaceAll('.', ','),
                configFormatNumeral
            );
        }

        const result = targetImpactProbabilityScale._currentState.choices.find(
            choice =>
                choice.customProperties.impact_scale == scale.customProperties.scale &&
                choice.customProperties.impact_probability == probability.customProperties.scale
        );

        if (result) {
            targetImpactProbabilityScale.setChoiceByValue(result.value);
            targetRiskScale.value = result.customProperties.risk_scale;
            targetRiskLevel.value = result.customProperties.risk_level;
        }
    } else {
        targetImpactProbabilityScale.setChoiceByValue("Pilih");
        targetRiskScale.value = null;
        targetRiskLevel.value = null;
        targetExposure.value = null;
    }
}

const residualItems = [];
/**
* Initialize AddEventListener to Q1 Items
*/
const residualItemsInit = () => {
    identificationResidualItemsInit()

    for (let i = 1; i < 5; i++) {
        const residualItem = [
            identificationChoices[`residual[${i}][impact_scale]`],
            identificationCauseForm.querySelector(`[name="residual[${i}][impact_value]"`),
            identificationCauseForm.querySelector(`[name="residual[${i}][impact_probability]"`),
            identificationChoices[`residual[${i}][impact_probability_scale]`],
            identificationCauseForm.querySelector(`[name="residual[${i}][risk_exposure]"`),
            identificationCauseForm.querySelector(`[name="residual[${i}][risk_scale]"`),
            identificationCauseForm.querySelector(`[name="residual[${i}][risk_level]"`),
            true
        ]

        identificationSelects[`residual[${i}][impact_probability_scale]`].addEventListener('change', e => {
            calculateRisk(...identificationInherentItems);
        })

        identificationCauseForm.querySelector(`[name="residual[${i}][impact_probability]"`)
            .addEventListener('keyup', debounce(() => calculateRisk(...residualItem), 500))

        residualItems.push(residualItem)
    }
}
residualItemsInit();

identificationInherentImpactValue.addEventListener('input', (e) => {
    const keyupEvent = new Event('keyup', { bubbles: true });

    e.target.value = formatNumeral(e.target.value, configFormatNumeral);
    // for (let i = 1; i < 5; i++) {
    //     const impactValue = identificationCauseForm.querySelector(`[name="residual[${i}][impact_value]"`)
    //     impactValue.value = formatNumeral(e.target.value, configFormatNumeral);
    //     impactValue.dispatchEvent(keyupEvent);
    // }

    e.target.dispatchEvent(keyupEvent);
})

identificationInherentImpactValue.addEventListener(
    'keyup',
    debounce((e) => {
        calculateRisk(...identificationInherentItems);
    }, 500)
)
identificationInherentImpactProbability.addEventListener(
    'keyup',
    debounce(() => {
        calculateRisk(...identificationInherentItems);
    }, 500)
)


const identificationTextareas = {};
for (let t of identificationCauseForm.querySelectorAll('textarea')) {
    identificationTextareas[t.name] = t;
}

const identificationQuills = {};
for (let editor of identificationCauseForm.querySelectorAll('.textarea')) {
    const targetId = editor.id.replaceAll('-editor', '');
    identificationQuills[targetId] = new Quill(editor, configQuill);
    identificationQuills[targetId].on('text-change', (delta, oldDelta, source) => {
        identificationTextareas[targetId].innerHTML = identificationQuills[targetId].root.innerHTML;
    })
}

const identificationDatePicker = flatpickr(identificationDateRange, {
    mode: 'range',
    dateFormat: 'Y-m-d',
    altInput: true,
    altFormat: 'j F Y',
    locale: localeFlatpickr,
    onChange: (dates) => {
        identificationStartDate.value = dates[0]?.getFullYear() + '-' + (dates[0]?.getMonth() + 1) + '-' + dates[0]?.getDate();
        identificationEndDate.value = dates[1]?.getFullYear() + '-' + (dates[1]?.getMonth() + 1) + '-' + dates[1]?.getDate();
    },
    defaultDate: [identificationStartDate.value, identificationEndDate.value],
})

identificationCauseForm.addEventListener('submit', (e) => {
    e.preventDefault();

    const formData = new FormData(e.target);

    e.target.querySelectorAll('input:disabled, select:disabled').forEach((input) => {
        formData.append(input.name, input.value);
    });

    const data = Object.fromEntries(formData)
    if (data.hasOwnProperty('search_terms')) {
        delete data.search_terms;
    }
    onIdentificationSave(data)
    setTimeout(() => identificationModal.hide(), 500);
});

identificationCauseForm.addEventListener('reset', async () => {
    identificationModal.hide();
});

identificationModalElement.addEventListener('hide.bs.modal', async () => {
    identificationCauseForm.reset();
    identificationCauseForm.querySelector('[name="key"]').value = '';

    Object.keys(identificationChoices).forEach(key => {
        identificationChoices[key].destroy();
    })

    await identificationChoicesInit();
    await identificationResidualItemsInit();
    await residualItemsInit();

    Object.keys(identificationTextareas).forEach((key) => {
        // identificationTextareas[key].innerHTML = '';
        identificationQuills[key].deleteText(0, identificationQuills[key].getLength());
    });
});


const onIdentificationSave = (data) => {
    Object.keys(data).forEach(key => {
        if (key.includes('impact_value') || key.includes('risk_exposure')) {
            data[key] = unformatNumeral(data[key], configFormatNumeral).replaceAll('.', ',');
        }
    })

    if (data.key) {
        worksheet.identifications[worksheet.identifications.findIndex(item => item.key == data.key)] = data;
        updateIdentificationRow(data)
    } else {
        data.key = (worksheet.identifications.length + 1).toString();
        worksheet.identifications.push(data);
        addIdentificationRow(data);
    }

    const choices = []
    for (let identification of worksheet.identifications) {
        choices.push({
            id: identification.risk_cause_number,
            value: identification.risk_cause_number,
            label: identification.risk_cause_number,
        })
    }

    treatmentRiskCauseNumber.innerHTML = '<option>Pilih</option>'
    treatmentRiskCauseNumberChoices.clearStore().clearChoices().setChoices(choices).setChoiceByValue('Pilih');
    identificationModal.hide();
}

const onIdentificationEdit = (data) => {
    Object.keys(data).forEach(key => {
        const element = identificationCauseForm.querySelector(`[name="${key}"]`)
        const event = new Event('change')

        if (key.includes('impact_value') || key.includes('risk_exposure')) {
            element.value = formatNumeral(data[key], configFormatNumeral)
        } else if (identificationChoices.hasOwnProperty(key)) {
            element.value = data[key]
            identificationChoices[key].setChoiceByValue(data[key])
        } else if (element.tagName == 'TEXTAREA') {
            identificationQuills[key].root.innerHTML = data[key]
            identificationQuills[key].emitter.emit('text-change')
            return
        } else {
            element.value = data[key]
        }
        element.dispatchEvent(event)
    });

    // Set the flatpickr dates
    if (data.identification_start_date && data.identification_end_date) {
        identificationDatePicker.setDate([data.identification_start_date, data.identification_end_date]);
    }

    identificationModal.show();
}

const addIdentificationRow = (data) => {
    'inherent_impact_value'
    'inherent_risk_exposure'
    'impact_value'
    'risk_exposure'

    const body = tables.identifications.querySelector('tbody');
    const row = document.createElement('tr');
    const [removeButton, editButton] = addRowAction('identifications', worksheet.identifications.length - 1, (data) => onIdentificationEdit(data));
    const buttonCell = document.createElement('td');
    buttonCell.appendChild(editButton);
    buttonCell.appendChild(removeButton);

    row.id = `identification-${data.key}`;
    row.innerHTML = `
        <td>${data.risk_chronology_body}</td>
        <td>${data.risk_chronology_description}</td>
        <td>${data.risk_cause_number}</td>
        <td>${data.risk_cause_code}</td>
        <td>${data.risk_cause_body}</td>
        <td>${data.kri_body}</td>
        <td>${identificationCauseForm.querySelector(`select[name="kri_unit"] option[value="${data.kri_unit}"]`)?.textContent ?? ''}</td>
        <td>${data.kri_threshold_safe}</td>
        <td>${data.kri_threshold_caution}</td>
        <td>${data.kri_threshold_danger}</td>
        <td>${identificationCauseForm.querySelector(`select[name="existing_control_type"] option[value="${data.existing_control_type}"]`)?.textContent ?? ''}</td>
        <td>${data.existing_control_body}</td>
        <td>${identificationCauseForm.querySelector(`select[name="control_effectiveness_assessment"] option[value="${data.control_effectiveness_assessment}"]`)?.textContent ?? ''}</td>
        <td class="text-capitalize">${data.risk_impact_category}</td>
        <td>${data.risk_impact_body}</td>
        <td>${dayjs(data.risk_impact_start_date).format('MMMM, DD YYYY')} s.d. ${dayjs(data.risk_impact_end_date).format('MMMM, DD YYYY')}</td>
        <td>${data.inherent_body}</td>
        <td>${data.inherent_impact_value}</td>
        <td>${bumnScales.find(scale => scale.id == data.inherent_impact_scale && scale.impact_category == data.risk_impact_category)?.scale ?? ''}</td>
        <td></td>
        <td>${data.inherent_impact_probability}</td>
        <td>${heatmaps.find(probability => probability.id == data.inherent_impact_probability_scale)?.impact_probability ?? ''}</td>
        <td></td>
        <td>${data.inherent_risk_exposure}</td>
        <td>${data.inherent_risk_scale}</td>
        <td></td>
        <td>${data.inherent_risk_level}</td>
        <td></td>
    `;
    row.prepend(buttonCell);

    body.appendChild(row);
}

const updateIdentificationRow = (data) => {
    const row = tables.identifications.querySelector('#identification-' + data.key);
    row.querySelector('td:nth-child(2)').innerHTML = data.risk_chronology_body
    row.querySelector('td:nth-child(3)').innerHTML = data.risk_chronology_description
    row.querySelector('td:nth-child(4)').textContent = data.risk_cause_number
    row.querySelector('td:nth-child(5)').textContent = data.risk_cause_code
    row.querySelector('td:nth-child(6)').innerHTML = data.risk_cause_body
    row.querySelector('td:nth-child(7)').textContent = data.kri_body
    row.querySelector('td:nth-child(8)').textContent = identificationCauseForm.querySelector(`select[name="kri_unit"] option[value="${data.kri_unit}"]`)?.textContent ?? ''
    row.querySelector('td:nth-child(9)').textContent = data.kri_threshold_safe
    row.querySelector('td:nth-child(10)').textContent = data.kri_threshold_caution
    row.querySelector('td:nth-child(11)').textContent = data.kri_threshold_danger
    row.querySelector('td:nth-child(12)').textContent = identificationCauseForm.querySelector(`select[name="existing_control_type"] option[value="${data.existing_control_type}"]`)?.textContent ?? ''
    row.querySelector('td:nth-child(13)').innerHTML = data.existing_control_body
    row.querySelector('td:nth-child(14)').textContent = identificationCauseForm.querySelector(`select[name="control_effectiveness_assessment"] option[value="${data.control_effectiveness_assessment}"]`)?.textContent ?? ''
    row.querySelector('td:nth-child(15)').textContent = data.risk_impact_category
    row.querySelector('td:nth-child(16)').innerHTML = data.risk_impact_body
    row.querySelector('td:nth-child(17)').textContent = dayjs(data.risk_impact_start_date).format('MMMM, DD YYYY') + 's.d.' + dayjs(data.risk_impact_end_date).format('MMMM, DD YYYY')
    row.querySelector('td:nth-child(18)').innerHTML = data.inherent_body
    row.querySelector('td:nth-child(19)').textContent = data.inherent_impact_value
    row.querySelector('td:nth-child(20)').textContent = bumnScales.find(scale => scale.id == data.inherent_impact_scale && scale.impact_category == data.risk_impact_category)?.scale ?? '';
    row.querySelector('td:nth-child(21)').textContent = '';
    row.querySelector('td:nth-child(22)').textContent = data.inherent_impact_probability;
    row.querySelector('td:nth-child(23)').textContent = heatmaps.find(probability => probability.id == data.inherent_impact_probability_scale)?.impact_probability ?? '';
    row.querySelector('td:nth-child(24)').textContent = '';
    row.querySelector('td:nth-child(25)').textContent = formatNumeral(data.inherent_risk_exposure, configFormatNumeral);
    row.querySelector('td:nth-child(26)').textContent = data.inherent_risk_scale;
    row.querySelector('td:nth-child(27)').textContent = '';
    row.querySelector('td:nth-child(28)').textContent = data.inherent_risk_level;
    row.querySelector('td:nth-child(29)').textContent = '';
}

const treatmentForm = document.querySelector('#treatmentForm');
const treatmentRiskCauseNumber = document.querySelector('[name="risk_cause_number"]');
const treatmentRiskCauseNumberChoices = new Choices(treatmentRiskCauseNumber, configChoices);
treatmentRiskCauseNumber.addEventListener('change', (e) => {
    const value = treatmentRiskCauseNumberChoices.getValue(true)
    if (value != 'Pilih') {
        const data = worksheet.identifications.find(identification => identification.risk_cause_number == treatmentRiskCauseNumberChoices.getValue(true));
        treatmentRiskCauseBodyQuill.root.innerHTML = data.risk_cause_body;
    }
});

const treatmentRiskCauseBody = treatmentForm.querySelector('[name="risk_cause_body"]');
const treatmentRiskCauseBodyQuill = new Quill(treatmentForm.querySelector('#risk_cause_body-editor'), configQuill);
treatmentRiskCauseBodyQuill.enable(false);

const treatmentTable = treatmentForm.querySelector('#worksheetTreatmentTable');
const treatmentModalElement = document.querySelector('#treatmentModal');
const treatmentModal = new Modal(treatmentModalElement);
const treatmentMitigationForm = treatmentModalElement.querySelector('#treatmentMitigationForm');
const mitigationCost = treatmentMitigationForm.querySelector('[name="mitigation_cost"]');
mitigationCost.addEventListener('keyup', (e) => {
    e.target.value = formatNumeral(e.target.value, configFormatNumeral);
})

const mitigationProgramType = treatmentMitigationForm.querySelector('[name="mitigation_rkap_program_type"]');
let mitigationProgramTypeChoices = new Choices(mitigationProgramType, configChoices);

const mitigationDateRange = treatmentMitigationForm.querySelector('#mitigation_date-picker');
const mitigationStartDate = treatmentMitigationForm.querySelector('[name="mitigation_start_date"]');
const mitigationEndDate = treatmentMitigationForm.querySelector('[name="mitigation_end_date"]');

const mitigationTextareas = {};
for (let t of treatmentMitigationForm.querySelectorAll('textarea')) {
    mitigationTextareas[t.name] = t;
}

const mitigationQuills = {};
for (let editor of treatmentMitigationForm.querySelectorAll('.textarea')) {
    const targetId = editor.id.replaceAll('-editor', '');
    mitigationQuills[targetId] = new Quill(editor, configQuill);
    mitigationQuills[targetId].on('text-change', (delta, oldDelta, source) => {
        mitigationTextareas[targetId].innerHTML = mitigationQuills[targetId].root.innerHTML;
    })
}


const mitigationDatePicker = flatpickr(
    mitigationDateRange,
    {
        mode: 'range',
        dateFormat: 'Y-m-d',
        altInput: true,
        altFormat: 'j F Y',
        locale: localeFlatpickr,
        onChange: (dates) => {
            mitigationStartDate.value = dates[0]?.getFullYear() + '-' + (dates[0]?.getMonth() + 1) + '-' + dates[0]?.getDate();
            mitigationEndDate.value = dates[1]?.getFullYear() + '-' + (dates[1]?.getMonth() + 1) + '-' + dates[1]?.getDate();
        },
        defaultDate: [mitigationStartDate.value, mitigationEndDate.value],
    }
)

const addTreatmentRow = (data) => {
    const body = treatmentTable.querySelector('tbody');
    const row = document.createElement('tr');
    const [removeButton, editButton] = addRowAction('mitigations', worksheet.mitigations.length - 1, (data) => onTreatmentEdit(data));
    const buttonCell = document.createElement('td');
    buttonCell.appendChild(editButton);
    buttonCell.appendChild(removeButton);

    row.id = `treatment-${data.key}`;
    row.innerHTML = `
        <td>${data.mitigation_plan}</td>
        <td>${data.mitigation_output}</td>
        <td>${dayjs(data.mitigation_start_date).format('MMMM, DD YYYY')}</td>
        <td>${dayjs(data.mitigation_end_date).format('MMMM, DD YYYY')}</td>
        <td>${formatNumeral(data.mitigation_cost, configFormatNumeral)}</td>
        <td>${mitigationProgramTypeChoices._currentState.choices.find(choice => choice.value == data.mitigation_rkap_program_type)?.label ?? ''}</td>
    `;
    row.prepend(buttonCell);

    body.appendChild(row);
}

const updateTreatmentRow = (data) => {
    const row = treatmentTable.querySelector('#treatment-' + data.key);

    row.querySelector('td:nth-child(2)').innerHTML = data.mitigation_plan
    row.querySelector('td:nth-child(3)').innerHTML = data.mitigation_output
    row.querySelector('td:nth-child(4)').textContent = mitigationProgramTypeChoices._currentState.choices.find(choice => choice.value == data.mitigation_rkap_program_type)?.label ?? ''
    row.querySelector('td:nth-child(5)').textContent = dayjs(data.mitigation_start_date).format('MMMM, DD YYYY')
    row.querySelector('td:nth-child(6)').textContent = dayjs(data.mitigation_end_date).format('MMMM, DD YYYY')
    row.querySelector('td:nth-child(7)').textContent = formatNumeral(data.mitigation_cost, configFormatNumeral)
}

const onTreatmentEdit = (data) => {
    Object.keys(data).forEach(key => {
        const element = treatmentMitigationForm.querySelector(`[name="${key}"]`)
        const event = new Event('change')
        if (!element) return;

        if (key.includes('mitigation_cost')) {
            element.value = formatNumeral(data[key], configFormatNumeral)
        } else if (key == 'mitigation_rkap_program_type') {
            element.value = data[key]
            mitigationProgramTypeChoices.setChoiceByValue(data[key])
        } else if (element.tagName == 'TEXTAREA') {
            element.value = data[key]
            mitigationQuills[key].root.innerHTML = data[key]
        } else {
            element.value = data[key]
        }

        element.dispatchEvent(event)
    });

    // Set the flatpickr dates
    if (data.mitigation_start_date && data.mitigation_end_date) {
        mitigationDatePicker.setDate([data.mitigation_start_date, data.mitigation_end_date]);
    }

    treatmentRiskCauseNumberChoices.setChoiceByValue(data.risk_cause_number);
    treatmentForm.querySelector('[name="risk_treatment_option"]').value = data.risk_treatment_option_id;
    treatmentForm.querySelector('[name="risk_treatment_type"]').value = data.risk_treatment_type_id;

    treatmentModal.show();
}

const onTreatmentSave = (data) => {
    data.mitigation_cost = unformatNumeral(data.mitigation_cost, configFormatNumeral).replaceAll('.', ',');
    if (data.key) {
        worksheet.mitigations[worksheet.mitigations.findIndex(item => item.key == data.key)] = data;
        updateTreatmentRow(data)
    } else {
        data.key = (worksheet.mitigations.length + 1).toString();
        worksheet.mitigations.push(data);
        addTreatmentRow(data);
    }

    setTimeout(() => treatmentModal.hide(), 250);
}

treatmentMitigationForm.addEventListener('submit', (e) => {
    e.preventDefault();

    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData)
    if (data.hasOwnProperty('search_terms')) {
        delete data.search_terms;
    }

    data.risk_number = treatmentForm.querySelector('[name="risk_number"]').value;
    data.risk_cause_number = treatmentRiskCauseNumberChoices.getValue(true);
    data.risk_treatment_option_id = treatmentForm.querySelector('[name="risk_treatment_option"]').value;
    data.risk_treatment_type_id = treatmentForm.querySelector('[name="risk_treatment_type"]').value;
    treatmentRiskCauseNumber.dispatchEvent(new Event('change'))

    onTreatmentSave(data);
});

treatmentMitigationForm.addEventListener('reset', () => {
    treatmentModal.hide();
});

treatmentModalElement.addEventListener('hidden.bs.modal', () => {
    treatmentMitigationForm.reset();
    treatmentRiskCauseNumberChoices.setChoiceByValue('Pilih');
    treatmentForm.querySelector('[name="risk_treatment_option"]').value = null;
    treatmentForm.querySelector('[name="risk_treatment_type"]').value = null;
    treatmentRiskCauseBody.innerHTML = '';
    treatmentRiskCauseBodyQuill.root.innerHTML = '';

    treatmentMitigationForm.querySelector('[name="key"]').value = '';

    mitigationProgramTypeChoices.destroy();
    mitigationProgramTypeChoices = new Choices(mitigationProgramType, configChoices);

    Object.keys(mitigationTextareas).forEach((key) => {
        mitigationTextareas[key].innerHTML = '';
        mitigationQuills[key].deleteText(0, mitigationQuills[key].getLength());
    });
});



worksheetTabSubmitButton.addEventListener('click', (e) => {
    const data = { ...worksheet };
    const contextData = new FormData(contextForm);
    for (let item of contextForm.querySelectorAll('input:disabled, textarea')) {
        if (item.tagName == 'TEXTAREA') {
            contextData.append(item.name, item.innerHTML);
        } else {
            contextData.append(item.name, item.value);
        }
    }

    const identificationData = new FormData(identificationForm);
    for (let item of identificationForm.querySelectorAll('select, select:disabled')) {
        identificationData.append(item.name, item.value);
    }


    data.identification = Object.fromEntries(identificationData);
    data.identifications = data.identifications.map(identification => {
        const formatted = formatDataToStructuredObject(identification)
        return formatted
    });


    axios.post('',
        { ...data, ...Object.fromEntries(contextData) }
    )
        .then(res => {
            if (res.status == 200) {
                console.log(res.data);
            }
        }).catch(err => console.log(err));
})