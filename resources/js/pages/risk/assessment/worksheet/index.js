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
import { defaultConfigChoices, defaultConfigFormatNumeral, defaultConfigQuill, defaultLocaleFlatpickr, formatDataToStructuredObject } from "js/components/helper";
import Swal from "sweetalert2";

dayjs.locale('id');

let currentStep = 0;
const totalStep = 4;

const worksheetTab = document.querySelector('#worksheetTab');
const worksheetTabList = worksheetTab.querySelectorAll('li');
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

const identificationValidate = () => {
    const identificationData = new FormData(identificationForm);
    for (let item of identificationForm.querySelectorAll('input:disabled, textarea, select, select:disabled')) {
        if (item.tagName == 'TEXTAREA') {
            identificationData.append(item.name, item.innerHTML);
        } else {
            console.log(item.name)
            if (item.name.includes('impact_value') || item.name.includes('risk_exposure')) {
                identificationData.append(item.name, unformatNumeral(item.value, defaultConfigFormatNumeral));
            } else {
                identificationData.append(item.name, item.value);
            }
        }
    }
    worksheet.identification = formatDataToStructuredObject(identificationData);

    for (let key of Object.keys(worksheet.identification)) {
        if (key == 'search_terms') {
            delete worksheet.identification.search_terms
            continue
        }

        if (key == 'residual') {
            if (worksheet.identification[key].length) {
                for (const residual of worksheet.identification[key]) {
                    if (residual) {
                        for (const itemKey of Object.keys(residual)) {
                            if (!residual[itemKey] || residual[itemKey] == 'Pilih') {
                                console.log(itemKey, residual[itemKey])
                                return false
                            }
                        }
                    }
                }
            }
        }

        if (
            !worksheet.identification[key] ||
            worksheet.identification[key] == 'Pilih'
        ) {
            console.log(key, worksheet.identification[key])
            return false
        }
    }


    return true;
}

const contextValidate = () => {
    const contextData = new FormData(contextForm);
    for (let item of contextForm.querySelectorAll('input:disabled, textarea')) {
        if (item.tagName == 'TEXTAREA') {
            contextData.append(item.name, item.innerHTML);
        } else {
            contextData.append(item.name, item.value);
        }
    }

    worksheet.context = Object.fromEntries(contextData);

    for (let key of Object.keys(worksheet.context)) {
        if (
            !worksheet.context[key] ||
            worksheet.context[key] == 'Pilih'
        ) {
            console.log(key, worksheet.context[key])
            return false
        }
    }

    return true;
}

worksheetTabNextButton.addEventListener('click', e => {
    currentStep += 1;

    if (
        currentStep == 1 &&
        (!contextValidate() || worksheet.strategies.length <= 0)
    ) {
        Swal.fire({
            icon: 'warning',
            text: 'Pastikan pilihan sasaran dan strategi bisnis telah terisi',
        });
        currentStep -= 1
        return
    } else if (
        currentStep == 2 &&
        (!identificationValidate() || worksheet.incidents.length <= 0)
    ) {
        Swal.fire({
            icon: 'warning',
            text: 'Pastikan identifikasi risiko dan peristiwa risiko telah terisi',
        });
        currentStep -= 1
        return
    } else if (
        currentStep == 3 && worksheet.mitigations.length <= 0
    ) {
        Swal.fire({
            icon: 'warning',
            text: 'Pastikan rencana mitigasi telah terisi',
        });
        currentStep -= 1
        return
    }

    const previousTab = worksheetTabList[currentStep - 1].querySelector('h2');
    const currentTab = worksheetTabList[currentStep].querySelector('h2')

    previousTab.classList.remove('bg-success', 'text-white');
    previousTab.classList.add('bg-light', 'text-dark');
    currentTab.classList.remove('bg-light', 'text-dark');
    currentTab.classList.add('bg-success', 'text-white');

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
    currentStep -= 1;
    const previousTab = worksheetTabList[currentStep + 1].querySelector('h2');
    const currentTab = worksheetTabList[currentStep].querySelector('h2')

    previousTab.classList.remove('bg-success', 'text-white');
    previousTab.classList.add('bg-light', 'text-dark');
    currentTab.classList.remove('bg-light', 'text-dark');
    currentTab.classList.add('bg-success', 'text-white');

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
    context: {
        unit_name: '',
        period_date: '',
        period_year: 0,
        target_body: '',
    },
    strategies: [],
    identification: {
        'company_name': null,
        'company_code': null,
        'target_body': null,
        'kbumn_target': null,
        'kbumn_risk_category': null,
        'kbumn_risk_category_t3': null,
        'kbumn_risk_category_t2': null,
        'existing_control_type': null,
        'existing_control_body': null,
        'control_effectiveness_assessment': null,
        'risk_impact_category': null,
        'risk_impact_body': null,
        'risk_impact_start_date': null,
        'risk_impact_end_date': null,
        'inherent_body': null,
        'inherent_impact_value': null,
        'inherent_impact_scale': null,
        'inherent_impact_probability': null,
        'inherent_impact_probability_scale': null,
        'inherent_risk_exposure': null,
        'inherent_risk_scale': null,
        'inherent_risk_level': null,
        'residual[0][impact_value]': null,
        'residual[0][impact_scale]': null,
        'residual[0][impact_probability]': null,
        'residual[0][impact_probability_scale]': null,
        'residual[0][risk_exposure]': null,
        'residual[0][risk_scale]': null,
        'residual[0][risk_level]': null,
        'residual[1][impact_value]': null,
        'residual[1][impact_scale]': null,
        'residual[1][impact_probability]': null,
        'residual[1][impact_probability_scale]': null,
        'residual[1][risk_exposure]': null,
        'residual[1][risk_scale]': null,
        'residual[1][risk_level]': null,
        'residual[2][impact_value]': null,
        'residual[2][impact_scale]': null,
        'residual[2][impact_probability]': null,
        'residual[2][impact_probability_scale]': null,
        'residual[2][risk_exposure]': null,
        'residual[2][risk_scale]': null,
        'residual[2][risk_level]': null,
        'residual[3][impact_value]': null,
        'residual[3][impact_scale]': null,
        'residual[3][impact_probability]': null,
        'residual[3][impact_probability_scale]': null,
        'residual[3][risk_exposure]': null,
        'residual[3][risk_scale]': null,
        'residual[3][risk_level]': null,
    },
    incidents: [],
    mitigations: [],
};

const bumnScales = [];
const heatmaps = [];
const kriUnits = [];
const existingControlTypes = [];
const risk_numbers = ['a', 'b', 'c', 'd', 'e'];
const unit_head = { pic_name: "" };

await axios.get('/master/bumn-scale').then(res => res.status == 200 ? bumnScales.push(...res.data.data) : null).catch(err => console.log(err));
await axios.get('/master/heatmap').then(res => res.status == 200 ? heatmaps.push(...res.data.data) : null).catch(err => console.log(err));
await axios.get('/master/kri-unit').then(res => res.status == 200 ? kriUnits.push(...res.data.data) : null).catch(err => console.log(err));
await axios.get('/master/existing-control-type').then(res => res.status == 200 ? existingControlTypes.push(...res.data.data) : null).catch(err => console.log(err));
await axios.get('/profile/unit_head').then(res => {
    if (res.status == 200) {
        unit_head.pic_name = res.data.data.pic_name
    }
}).catch(err => console.log(err))

const tables = {
    strategies: document.querySelector('#worksheetStrategyTable'),
    incidents: document.querySelector('#worksheetIncidentTable'),
    mitigations: document.querySelector('#worksheetTreatmentTable')
}

const contextForm = document.querySelector('#contextForm');
const currentRiskNumber = contextForm.querySelector('[name="risk_number"]');

const targetUnitName = contextForm.querySelector('[name="unit_name"]');
const targetPeriodYear = contextForm.querySelector('[name="period_year"]');
const targetPeriodDate = contextForm.querySelector('[name="period_date"]');
const targetBody = contextForm.querySelector('[name="target_body"]');
const targetBodyQuill = new Quill(contextForm.querySelector('#target_body-editor'), defaultConfigQuill);
targetBodyQuill.on('text-change', (delta, oldDelta, source) => {
    targetBody.innerHTML = targetBodyQuill.root.innerHTML;

    identificationTargetBodyQuill.root.innerHTML = targetBodyQuill.root.innerHTML;
    identificationTargetBody.innerHTML = targetBodyQuill.root.innerHTML;

    worksheet.context.target_body = targetBodyQuill.root.innerHTML;
});

worksheet.context.unit_name = targetUnitName.value;
worksheet.context.period_year = targetPeriodYear.value;
worksheet.context.period_date = targetPeriodDate.value;

const strategyModalButton = document.querySelector('#strategyModalButton');
const strategyModalElement = document.querySelector('#strategyModal');
const strategyModal = new Modal(strategyModalElement);
const strategyForm = document.querySelector('#strategyForm');

strategyModalButton.addEventListener('click', () => {
    if (worksheet.context.target_body == '') {
        Swal.fire({
            icon: 'warning',
            title: '',
            text: 'Pastikan pilihan sasaran telah terisi.',
        })
        return
    }

    strategyModal.show();
})


const strategyTextareas = {};
for (let t of strategyForm.querySelectorAll('textarea')) {
    strategyTextareas[t.name] = t;
}
const strategyQuills = {};
for (let editor of strategyForm.querySelectorAll('.textarea')) {
    strategyQuills[editor.id.replaceAll('-editor', '')] = new Quill(editor, defaultConfigQuill);
    strategyQuills[editor.id.replaceAll('-editor', '')].on('text-change', (delta, oldDelta, source) => {
        strategyTextareas[editor.id.replaceAll('-editor', '')].innerHTML = strategyQuills[editor.id.replaceAll('-editor', '')].root.innerHTML;
    })
}

const strategyRiskValueLimit = strategyForm.querySelector('[name="strategy_risk_value_limit"]')
strategyRiskValueLimit.addEventListener('input', (e) => {
    e.target.value = formatNumeral(e.target.value, defaultConfigFormatNumeral);
})

const strategyDecision = strategyForm.querySelector('[name="strategy_decision"]');
let strategyDecisionChoices = new Choices(strategyDecision, defaultConfigChoices);

// type = strategies | identifications | mitigations
const addRowAction = (type, index, callback) => {
    const removeButton = document.createElement('button');
    const editButton = document.createElement('button');

    removeButton.type = 'button';
    removeButton.classList.add('btn', 'btn-sm', 'btn-danger', 'm-1');
    removeButton.innerHTML = `<i class="ti ti-x"></i>`;

    removeButton.addEventListener('click', () => {
        console.log(
            type,
            tables[type].querySelector('tbody'),
            tables[type].querySelector('tbody').children[index]
        )
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
        <td>${formatNumeral(data.strategy_risk_value_limit, defaultConfigFormatNumeral)}</td>
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
    row.querySelector('td:nth-child(5)').innerHTML = formatNumeral(data.strategy_risk_value_limit.toString(), defaultConfigFormatNumeral);
    row.querySelector('td:nth-child(6)').innerHTML = data.strategy_decision;
}

const onStrategySave = (data) => {

    for (let key of Object.keys(data)) {
        if (key == 'key' || key == 'id') {
            continue
        }

        if (!data[key] || data[key] == 'Pilih') {
            Swal.fire('Peringatan', 'Pastikan semua isian harus terisi', 'warning');
            return;
        }
    }

    data.strategy_risk_value_limit = unformatNumeral(data.strategy_risk_value_limit, defaultConfigFormatNumeral).replaceAll('.', ',');
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
    strategyForm.querySelector('[name="id"]').value = data.id;
    strategyQuills['strategy_body'].root.innerHTML = data.strategy_body;
    strategyQuills['strategy_expected_feedback'].root.innerHTML = data.strategy_expected_feedback;
    strategyQuills['strategy_risk_value'].root.innerHTML = data.strategy_risk_value;
    strategyRiskValueLimit.value = formatNumeral(data.strategy_risk_value_limit, defaultConfigFormatNumeral);
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
    strategyDecisionChoices = new Choices(strategyDecision, defaultConfigChoices);


    Object.keys(strategyTextareas).forEach((key) => {
        strategyTextareas[key].innerHTML = '';
        strategyQuills[key].deleteText(0, strategyQuills[key].getLength());
    });
});


const identificationForm = document.querySelector('#identificationForm');
const identificationTabs = document.querySelector('#identificationTabs');
const identificationInherentTab = document.querySelector('#identificationInherentTab');
const identificationResidualTab = document.querySelector('#identificationResidualTab');

const identificationDateRange = identificationForm.querySelector('#risk_impact_date-picker');
const identificationStartDate = identificationForm.querySelector('[name="risk_impact_start_date"]');
const identificationEndDate = identificationForm.querySelector('[name="risk_impact_end_date"]');

const identificationKBUMNTarget = identificationForm.querySelector('[name="kbumn_target"]');
const identificationRiskCategory = identificationForm.querySelector('[name="kbumn_risk_category"]');
const identificationRiskCategoryT2 = identificationForm.querySelector('[name="kbumn_risk_category_t2"]');
const identificationRiskCategoryT3 = identificationForm.querySelector('[name="kbumn_risk_category_t3"]');
const identificationExistingControlType = identificationForm.querySelector('[name="existing_control_type"]');
const identificationControlEffectivenessAssessment = identificationForm.querySelector('[name="control_effectiveness_assessment"]');
const identificationRiskImpact = identificationForm.querySelector('[name="risk_impact_category"]');

const identificationKBUMNTargetChoices = new Choices(identificationKBUMNTarget, defaultConfigChoices);
const identificationRiskCategoryChoices = new Choices(identificationRiskCategory, defaultConfigChoices);
const identificationRiskCategoryT2Choices = new Choices(identificationRiskCategoryT2, defaultConfigChoices);
const identificationRiskCategoryT3Choices = new Choices(identificationRiskCategoryT3, defaultConfigChoices);
const identificationExistingControlTypeChoices = new Choices(identificationExistingControlType, defaultConfigChoices);
const identificationControlEffectivenessAssessmentChoices = new Choices(identificationControlEffectivenessAssessment, defaultConfigChoices);
const identificationRiskImpactChoices = new Choices(identificationRiskImpact, defaultConfigChoices);


const identificationSelects = {};
for (let t of identificationTabs.querySelectorAll('.form-select')) {
    identificationSelects[t.name] = t;
}

const identificationChoices = {};
const identificationChoicesInit = async () => {
    for (let t of identificationTabs.querySelectorAll('.form-select')) {
        identificationSelects[t.name] = t;
    }

    Object.keys(identificationSelects).forEach((key) => {
        const choices = [{
            value: 'Pilih',
            label: 'Pilih',
        }];
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
            }
        }
        identificationChoices[key] = new Choices(identificationSelects[key], { ...defaultConfigChoices, choices: choices });
    });

    identificationSelects?.risk_cause_number?.addEventListener(
        'change',
        e => identificationRiskCauseCode.value = identificationRiskNumber.value + '.' + identificationChoices.risk_cause_number.getValue(true)
    )
    identificationSelects?.inherent_impact_scale?.addEventListener('change', e => {
        calculateRisk(...identificationInherentItems);
    });

    identificationRiskImpact.addEventListener('change', e => {
        const risk_impact_category = identificationRiskImpactChoices.getValue(true)
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


            for (let label of incidentForm.querySelectorAll('.label-category-risk')) {
                if (label.dataset[risk_impact_category]) {
                    label.innerHTML = label.dataset[risk_impact_category]
                } else {
                    label.innerHTML = risk_impact_category;
                }
            }
        } else {
            for (let label of incidentForm.querySelectorAll('.label-category-risk')) {
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



identificationRiskImpact.addEventListener('change', e => {
    const risk_impact_category = identificationRiskImpactChoices.getValue(true)
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


        for (let label of identificationForm.querySelectorAll('.label-category-risk')) {
            if (label.dataset[risk_impact_category]) {
                label.innerHTML = label.dataset[risk_impact_category]
            } else {
                label.innerHTML = risk_impact_category;
            }
        }
    } else {
        for (let label of identificationForm.querySelectorAll('.label-category-risk')) {
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
})

identificationRiskCategoryT3.addEventListener('change', e => identificationRiskCategoryChoices.setChoiceByValue(e.detail.value));

const identificationTargetBody = identificationForm.querySelector('[name="target_body"]');
const identificationTargetBodyQuill = new Quill(identificationForm.querySelector('#target_body-editor'), defaultConfigQuill);
identificationTargetBodyQuill.enable(false);
identificationTargetBodyQuill.on('text-change', (delta, oldDelta, source) => {
    identificationTargetBody.innerHTML = identificationTargetBodyQuill.root.innerHTML;
});

const identificationTextareas = {};
for (let t of identificationForm.querySelectorAll('textarea')) {
    if (t.name == 'target_body') {
        continue
    }

    identificationTextareas[t.name] = t;
}

const identificationQuills = {};
for (let editor of identificationForm.querySelectorAll('.textarea')) {
    const targetId = editor.id.replaceAll('-editor', '');
    if (targetId == 'target_body') {
        continue
    }
    identificationQuills[targetId] = new Quill(editor, defaultConfigQuill);

    identificationQuills[targetId].on('text-change', (delta, oldDelta, source) => {
        identificationTextareas[targetId].innerHTML = identificationQuills[targetId].root.innerHTML;
    })
}

const identificationDatePicker = flatpickr(identificationDateRange, {
    mode: 'range',
    dateFormat: 'Y-m-d',
    altInput: true,
    altFormat: 'j F Y',
    locale: defaultLocaleFlatpickr,
    onChange: (dates) => {
        identificationStartDate.value = dates[0]?.getFullYear() + '-' + (dates[0]?.getMonth() + 1) + '-' + dates[0]?.getDate();
        identificationEndDate.value = dates[1]?.getFullYear() + '-' + (dates[1]?.getMonth() + 1) + '-' + dates[1]?.getDate();
    },
    defaultDate: [identificationStartDate.value, identificationEndDate.value],
})

/**
 * Inherent Calculation
 */
const identificationInherentImpactValue = identificationForm.querySelector('[name="inherent_impact_value"]');
const identificationInherentImpactProbability = identificationForm.querySelector('[name="inherent_impact_probability"]');
const identificationInherentRiskExposure = identificationForm.querySelector('[name="inherent_risk_exposure"]');
const identificationInherentRiskScale = identificationForm.querySelector('[name="inherent_risk_scale"]');
const identificationInherentRiskLevel = identificationForm.querySelector('[name="inherent_risk_level"]');

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
                (unformatNumeral(identificationInherentImpactValue.value, defaultConfigFormatNumeral) * scale.customProperties.scale).toString().replaceAll('.', ','),
                defaultConfigFormatNumeral
            );

        } else {
            targetImpactValue.value = formatNumeral("0", defaultConfigFormatNumeral)
            targetExposure.value = formatNumeral("0", defaultConfigFormatNumeral);
            targetRiskScale.value = null;
            targetRiskLevel.value = null;
        }
    }

    if (scale?.customProperties?.scale && probability) {
        const impactValue = parseFloat(unformatNumeral(targetImpactValue.value, defaultConfigFormatNumeral));
        const probabilityValue = parseFloat(targetImpactProbability.value);

        if (impactValue && probabilityValue && identificationRiskImpact.value == 'kuantitatif') {
            targetExposure.value = formatNumeral(
                (impactValue * (probabilityValue / 100)).toString().replaceAll('.', ','),
                defaultConfigFormatNumeral
            );
        } else if (impactValue && probabilityValue && identificationRiskImpact.value == 'kualitatif') {
            targetExposure.value = formatNumeral(
                (1 / 100 * impactValue * parseInt(scale.customProperties.scale) * (probabilityValue / 100)).toString().replaceAll('.', ','),
                defaultConfigFormatNumeral
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

const residualItems = []
const identificationResidualImpactValues = []
const identificationResidualImpactProbabilities = []
const identificationResidualRiskExposures = []
const identificationResidualRiskScales = []
const identificationResidualRiskLevels = []

for (let i = 1; i <= 4; i++) {
    identificationResidualImpactValues.push(identificationForm.querySelector(`[name="residual[${i}][impact_value]"]`))
    identificationResidualImpactProbabilities.push(identificationForm.querySelector(`[name="residual[${i}][impact_probability]"]`))
    identificationResidualRiskExposures.push(identificationForm.querySelector(`[name="residual[${i}][risk_exposure]"]`))
    identificationResidualRiskScales.push(identificationForm.querySelector(`[name="residual[${i}][risk_scale]"]`))
    identificationResidualRiskLevels.push(identificationForm.querySelector(`[name="residual[${i}][risk_level]"]`))
}
/**
* Initialize AddEventListener to Q1 Items
*/
const residualItemsInit = () => {
    identificationResidualItemsInit()

    for (let i = 1; i < 5; i++) {
        const residualItem = [
            identificationChoices[`residual[${i}][impact_scale]`],
            identificationResidualImpactValues[i - 1],
            identificationResidualImpactProbabilities[i - 1],
            identificationChoices[`residual[${i}][impact_probability_scale]`],
            identificationResidualRiskExposures[i - 1],
            identificationResidualRiskScales[i - 1],
            identificationResidualRiskLevels[i - 1],
            true
        ]


        identificationSelects[`residual[${i}][impact_scale]`].addEventListener('change', e => {
            calculateRisk(...residualItem);
        })

        identificationForm.querySelector(`[name="residual[${i}][impact_probability]"`)
            .addEventListener('keyup', debounce(() => calculateRisk(...residualItem), 500))

        residualItems.push(residualItem)
    }
}
residualItemsInit();

identificationInherentImpactValue.addEventListener('input', (e) => {
    const value = formatNumeral(e.target.value, defaultConfigFormatNumeral);

    e.target.value = value;
    for (let i = 0; i < 4; i++) {
        identificationResidualImpactValues[i].value = value;
        identificationResidualImpactValues[i].dispatchEvent(new Event('keyup'));
        identificationResidualImpactProbabilities[i].dispatchEvent(new Event('keyup'));
    }
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

const incidentForm = document.querySelector('#incidentForm');
const incidentModalElement = document.querySelector('#incidentModal');
const incidentModal = new Modal(incidentModalElement);

const incidentRiskNumber = incidentForm.querySelector('[name="risk_number"]');
const incidentRiskCauseNumber = incidentForm.querySelector('[name="risk_cause_number"]');
const incidentRiskCauseCode = incidentForm.querySelector('[name="risk_cause_code"]');

const incidentTextareas = {};
const incidentQuills = {};
for (let t of incidentForm.querySelectorAll('textarea')) {
    incidentTextareas[t.name] = t;

    incidentQuills[t.name] = new Quill(incidentForm.querySelector('#' + t.name + '-editor'), defaultConfigQuill);
    incidentQuills[t.name].on('text-change', (delta, oldDelta, source) => {
        incidentTextareas[t.name].innerHTML = incidentQuills[t.name].root.innerHTML;
    })
}

incidentForm.addEventListener('submit', (e) => {
    e.preventDefault();

    const formData = new FormData(e.target);

    e.target.querySelectorAll('input:disabled, select:disabled').forEach((input) => {
        formData.append(input.name, input.value);
    });

    const data = Object.fromEntries(formData)
    if (data.hasOwnProperty('search_terms')) {
        delete data.search_terms;
    }
    onIncidentSave(data)
});

incidentForm.addEventListener('reset', async () => {
    incidentModal.hide();
});

incidentModalElement.addEventListener('hide.bs.modal', async () => {
    incidentForm.reset();
    incidentForm.querySelector('[name="key"]').value = '';
    incidentRiskNumber.value = currentRiskNumber.value;
    incidentRiskCauseNumber.value = risk_numbers[worksheet.incidents.length];
    incidentRiskCauseCode.value = currentRiskNumber.value + '.' + risk_numbers[worksheet.incidents.length];

    Object.keys(incidentTextareas).forEach((key) => {
        incidentQuills[key].deleteText(0, incidentQuills[key].getLength());
    });
});


const onIncidentSave = (data) => {
    for (let key of Object.keys(data)) {
        if (key == 'key' || key == 'id') {
            continue
        }

        if (!data[key] || data[key] == 'Pilih') {
            Swal.fire('Peringatan', 'Pastikan semua isian harus terisi', 'warning');
            return;
        }

        if (key.includes('impact_value') || key.includes('risk_exposure')) {
            data[key] = unformatNumeral(data[key], defaultConfigFormatNumeral).replaceAll('.', ',');
        }
    }

    if (data.key) {
        worksheet.incidents[worksheet.incidents.findIndex(item => item.key == data.key)] = data;
        updateIncidentRow(data)
    } else {
        data.key = (worksheet.incidents.length + 1).toString();
        worksheet.incidents.push(data);
        addIncidentRow(data);
    }

    const choices = [{
        id: 'Pilih',
        value: 'Pilih',
        label: 'Pilih',
    }]
    for (let incident of worksheet.incidents) {
        choices.push({
            id: incident.risk_cause_number,
            value: incident.risk_cause_number,
            label: incident.risk_cause_number,
        })
    }

    treatmentRiskCauseNumber.innerHTML = '<option>Pilih</option>'
    treatmentRiskCauseNumberChoices.clearStore().clearChoices().setChoices(choices).setChoiceByValue('Pilih');
    incidentModal.hide();
}

const onIncidentEdit = (data) => {
    Object.keys(data).forEach(key => {
        const element = incidentForm.querySelector(`[name="${key}"]`)
        const event = new Event('change')

        if (key.includes('impact_value') || key.includes('risk_exposure')) {
            element.value = formatNumeral(data[key], defaultConfigFormatNumeral)
        } else if (identificationChoices.hasOwnProperty(key)) {
            element.value = data[key]
            identificationChoices[key].setChoiceByValue(data[key])
        } else if (element.tagName == 'TEXTAREA') {
            incidentQuills[key].root.innerHTML = data[key]
            incidentQuills[key].emitter.emit('text-change')
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

    incidentModal.show();
}

const addIncidentRow = (data) => {

    const body = tables.incidents.querySelector('tbody');
    const row = document.createElement('tr');
    const [removeButton, editButton] = addRowAction('incidents', worksheet.incidents.length - 1, (data) => onIncidentEdit(data));
    const buttonCell = document.createElement('td');
    buttonCell.appendChild(editButton);
    buttonCell.appendChild(removeButton);

    row.id = `incident-${data.key}`;
    row.innerHTML = `
        <td>${data.risk_chronology_body}</td>
        <td>${data.risk_chronology_description}</td>
        <td>${data.risk_cause_number}</td>
        <td>${data.risk_cause_code}</td>
        <td>${data.risk_cause_body}</td>
        <td>${data.kri_body}</td>
        <td>${incidentForm.querySelector(`select[name="kri_unit"] option[value="${data.kri_unit}"]`)?.textContent ?? ''}</td>
        <td>${data.kri_threshold_safe}</td>
        <td>${data.kri_threshold_caution}</td>
        <td>${data.kri_threshold_danger}</td>
    `;
    row.prepend(buttonCell);

    body.appendChild(row);
}

const updateIncidentRow = (data) => {
    const row = tables.incidents.querySelector('#incident-' + data.key);
    row.querySelector('td:nth-child(2)').innerHTML = data.risk_chronology_body
    row.querySelector('td:nth-child(3)').innerHTML = data.risk_chronology_description
    row.querySelector('td:nth-child(4)').textContent = data.risk_cause_number
    row.querySelector('td:nth-child(5)').textContent = data.risk_cause_code
    row.querySelector('td:nth-child(6)').innerHTML = data.risk_cause_body
    row.querySelector('td:nth-child(7)').textContent = data.kri_body
    row.querySelector('td:nth-child(8)').textContent = incidentForm.querySelector(`select[name="kri_unit"] option[value="${data.kri_unit}"]`)?.textContent ?? ''
    row.querySelector('td:nth-child(9)').textContent = data.kri_threshold_safe
    row.querySelector('td:nth-child(10)').textContent = data.kri_threshold_caution
    row.querySelector('td:nth-child(11)').textContent = data.kri_threshold_danger
}

const treatmentForm = document.querySelector('#treatmentForm');
const treatmentRiskCauseNumber = document.querySelector('[name="risk_cause_number"]');
const treatmentRiskCauseNumberChoices = new Choices(treatmentRiskCauseNumber, defaultConfigChoices);
treatmentRiskCauseNumber.addEventListener('change', (e) => {
    const value = treatmentRiskCauseNumberChoices.getValue(true)
    if (value != 'Pilih') {
        const data = worksheet.incidents.find(incident => incident.risk_cause_number == treatmentRiskCauseNumberChoices.getValue(true));
        treatmentRiskCauseBodyQuill.root.innerHTML = data.risk_cause_body;
    }
});

const treatmentRiskCauseBody = treatmentForm.querySelector('[name="risk_cause_body"]');
const treatmentRiskCauseBodyQuill = new Quill(treatmentForm.querySelector('#risk_cause_body-editor'), defaultConfigQuill);
treatmentRiskCauseBodyQuill.enable(false);

const treatmentTable = treatmentForm.querySelector('#worksheetTreatmentTable');
const treatmentModalElement = document.querySelector('#treatmentModal');
const treatmentModal = new Modal(treatmentModalElement);
const treatmentMitigationForm = treatmentModalElement.querySelector('#treatmentMitigationForm');
const mitigationCost = treatmentMitigationForm.querySelector('[name="mitigation_cost"]');
mitigationCost.addEventListener('keyup', (e) => {
    e.target.value = formatNumeral(e.target.value, defaultConfigFormatNumeral);
})
const mitigationPic = treatmentMitigationForm.querySelector('[name="mitigation_pic"]');
mitigationPic.value = unit_head.pic_name

const mitigationProgramType = treatmentMitigationForm.querySelector('[name="mitigation_rkap_program_type"]');
let mitigationProgramTypeChoices = new Choices(mitigationProgramType, defaultConfigChoices);

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
    mitigationQuills[targetId] = new Quill(editor, defaultConfigQuill);
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
        locale: defaultLocaleFlatpickr,
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
    console.log(worksheet.mitigations.length - 1)
    const [removeButton, editButton] = addRowAction('mitigations', worksheet.mitigations.length - 1, (data) => onTreatmentEdit(data));
    const buttonCell = document.createElement('td');
    buttonCell.appendChild(editButton);
    buttonCell.appendChild(removeButton);

    row.id = `treatment-${data.key}`;
    row.innerHTML = `
        <td>${data.risk_cause_number}</td>
        <td>${data.mitigation_plan}</td>
        <td>${data.mitigation_output}</td>
        <td>${dayjs(data.mitigation_start_date).format('MMMM, DD YYYY')}</td>
        <td>${dayjs(data.mitigation_end_date).format('MMMM, DD YYYY')}</td>
        <td>${formatNumeral(data.mitigation_cost, defaultConfigFormatNumeral)}</td>
        <td>${mitigationProgramTypeChoices._currentState.choices.find(choice => choice.value == data.mitigation_rkap_program_type)?.label ?? ''}</td>
        <td>${data.mitigation_pic}</td>
    `;
    row.prepend(buttonCell);

    body.appendChild(row);
}

const updateTreatmentRow = (data) => {
    const row = treatmentTable.querySelector('#treatment-' + data.key);

    row.querySelector('td:nth-child(2)').innerHTML = data.risk_cause_number
    row.querySelector('td:nth-child(3)').innerHTML = data.mitigation_plan
    row.querySelector('td:nth-child(4)').innerHTML = data.mitigation_output
    row.querySelector('td:nth-child(5)').textContent = mitigationProgramTypeChoices._currentState.choices.find(choice => choice.value == data.mitigation_rkap_program_type)?.label ?? ''
    row.querySelector('td:nth-child(6)').textContent = dayjs(data.mitigation_start_date).format('MMMM, DD YYYY')
    row.querySelector('td:nth-child(7)').textContent = dayjs(data.mitigation_end_date).format('MMMM, DD YYYY')
    row.querySelector('td:nth-child(8)').textContent = formatNumeral(data.mitigation_cost, defaultConfigFormatNumeral)
    row.querySelector('td:nth-child(9)').textContent = data.mitigation_pic
}

const onTreatmentEdit = (data) => {
    Object.keys(data).forEach(key => {
        const element = treatmentMitigationForm.querySelector(`[name="${key}"]`)
        const event = new Event('change')
        if (!element) return;

        if (key.includes('mitigation_cost')) {
            element.value = formatNumeral(data[key], defaultConfigFormatNumeral)
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
    mitigationPic.value = unit_head.pic_name

    treatmentModal.show();
}

const onTreatmentSave = (data) => {
    for (let key of Object.keys(data)) {
        if (key == 'key' || key == 'id') {
            continue
        }

        if (!data[key] || data[key] == 'Pilih') {
            Swal.fire('Peringatan', 'Pastikan semua isian harus terisi', 'warning');
            return;
        }
    }

    data.mitigation_cost = unformatNumeral(data.mitigation_cost, defaultConfigFormatNumeral).replaceAll('.', ',');
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

    data.mitigation_pic = mitigationPic.value
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
    mitigationProgramTypeChoices = new Choices(mitigationProgramType, defaultConfigChoices);

    mitigationPic.value = unit_head.pic_name
    Object.keys(mitigationTextareas).forEach((key) => {
        mitigationTextareas[key].innerHTML = '';
        mitigationQuills[key].deleteText(0, mitigationQuills[key].getLength());
    });
});



worksheetTabSubmitButton.addEventListener('click', (e) => {
    const data = { ...worksheet };


    axios.post('', data)
        .then(res => {
            if (res.status == 200) {
                window.location.replace(window.location.href + "/" + res.data.data.id);
            }
        }).catch(err => console.log(err));
})