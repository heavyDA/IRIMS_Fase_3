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
import { convertFileSize, defaultConfigChoices, defaultConfigFormatNumeral, defaultConfigQuill, defaultLocaleFlatpickr, formatDataToStructuredObject, jsonToFormData } from "js/components/helper";
import Swal from "sweetalert2";

dayjs.locale('id');

let currentStep = 0;
const totalStep = 6;
const monitoring = {
    residuals: {},
    actualizations: [],
    alteration: {},
    incident: {},
}

const monitoringTab = document.querySelector('#monitoringTab');
const monitoringTabList = monitoringTab.querySelectorAll('li');
const monitoringTabNavs = monitoringTab.querySelectorAll('a');

monitoringTabNavs.forEach((trigger, index) => {
    trigger.addEventListener('click', e => {
        if (index !== currentStep) {
            e.preventDefault(); // Prevent Bootstrap's default behavior
            e.stopPropagation(); // Stop event bubbling
        }
    });
})
const navigateToTab = (index) => {
    const nextTab = monitoringTabNavs[index];

    if (nextTab) {
        // Activate the target tab
        const tabInstance = new Tab(nextTab);
        tabInstance.show();
        currentStep = index;
    }
};

const monitoringTabNextButton = document.querySelector('#monitoringTabNextButton');
const monitoringTabPreviousButton = document.querySelector('#monitoringTabPreviousButton');
const monitoringTabSubmitButton = document.querySelector('#monitoringTabSubmitButton');

monitoringTabSubmitButton.addEventListener('click', async e => save())

monitoringTabNextButton.addEventListener('click', e => {
    currentStep += 1;

    if (currentStep == 4) {
        alterationFormSubmit()
    } else if (currentStep == 5) {
        incidentFormSubmit()
    }

    const previousTab = monitoringTabList[currentStep - 1].querySelector('h2');
    const currentTab = monitoringTabList[currentStep].querySelector('h2')

    previousTab.classList.remove('bg-success', 'text-white');
    previousTab.classList.add('bg-light', 'text-dark');
    currentTab.classList.remove('bg-light', 'text-dark');
    currentTab.classList.add('bg-success', 'text-white');

    if (currentStep > 0 && monitoringTabPreviousButton.classList.contains('d-none')) {
        monitoringTabPreviousButton.classList.remove('d-none');
    }

    if (currentStep == totalStep - 1 && monitoringTabSubmitButton.classList.contains('d-none')) {
        monitoringTabSubmitButton.classList.remove('d-none');
        monitoringTabNextButton.classList.add('d-none');
    }
    navigateToTab(currentStep);
})

monitoringTabPreviousButton.addEventListener('click', e => {
    currentStep -= 1;
    const previousTab = monitoringTabList[currentStep + 1].querySelector('h2');
    const currentTab = monitoringTabList[currentStep].querySelector('h2')

    previousTab.classList.remove('bg-success', 'text-white');
    previousTab.classList.add('bg-light', 'text-dark');
    currentTab.classList.remove('bg-light', 'text-dark');
    currentTab.classList.add('bg-success', 'text-white');

    if (currentStep == 0 && !monitoringTabPreviousButton.classList.contains('d-none')) {
        monitoringTabPreviousButton.classList.add('d-none');
    }

    if (currentStep < totalStep - 1) {
        if (!monitoringTabSubmitButton.classList.contains('d-none')) {
            monitoringTabSubmitButton.classList.add('d-none')
        }

        monitoringTabNextButton.classList.remove('d-none')
    }
    navigateToTab(currentStep)
})

/** End of stepper */

const fetchers = {
    bumn_scales: [],
    heat_maps: [],
    pics: [],
    risk_metric: {}
}

const fetchData = async () => {
    await Promise.allSettled([
        axios.get('/master/bumn-scale'),
        axios.get('/master/heatmap'),
        axios.get('/master/pic'),
        axios.get('/profile/risk_metric'),
        axios.get(window.location.href),
    ]).then(res => {
        for (let [index, key] of Object.keys(fetchers).entries()) {
            if (res[index].status == 'fulfilled') {
                const response = res[index].value
                if (response.status == 200) {
                    fetchers[key] = response.data.data
                }
            }
        }

        if (res[4].status == 'fulfilled') {
            const response = res[4].value
            if (response.status == 200) {
                const data = response.data.data

                monitoring.residuals = data.residuals
                monitoring.actualizations = data.actualizations
            }
        }
    })
}

await fetchData()
let currentQuarter = 1;
const residualForm = document.querySelector('#residualForm');
const residualFormButton = residualForm.querySelector('#residualFormButton');
residualFormButton.addEventListener('click', e => {
    residualFormSubmit(currentResidual)
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Realisasi Risiko Residual berhasil disimpan',
    })
});
const residualRiskImpactCategory = residualForm.querySelector('[name="risk_impact_category"]');
const residualTextareas = {};
const residualQuills = {};
for (const textarea of residualForm.querySelectorAll('textarea')) {
    residualTextareas[textarea.name] = textarea
    residualQuills[textarea.name] = new Quill(residualForm.querySelector('#' + textarea.name + '-editor'), defaultConfigQuill);
    residualQuills[textarea.name].root.innerHTML = textarea.value;
    residualQuills[textarea.name].enable(false);
}

const monitoringPeriodDate = residualForm.querySelector('[name="period_date"]')
const monitoringPeriodPicker = flatpickr(monitoringPeriodDate, {
    enableTime: false,
    dateFormat: 'Y-m-d',
    altInput: true,
    altFormat: 'j F Y',
    locale: defaultLocaleFlatpickr,
    onChange: (selectedDates, dateStr, instance) => {
        const value = dayjs(dateStr)
        currentQuarter = Math.ceil((value.month() + 1) / 3)

        monitoring.residuals.forEach((residual, index) => {
            residualFormSubmit(index)
        })
        monitoringEnableQuarter(currentQuarter)
        calculateRisk(currentQuarter)
    }
});

const residualRiskCauseNumber = residualForm.querySelector('[name="risk_cause_number"]');
const residualRiskCauseNumberChoices = new Choices(residualRiskCauseNumber, defaultConfigChoices);
const residualRiskMitigationEffectiveness = residualForm.querySelector('[name="risk_mitigation_effectiveness"]');
const riskNumbers = [];

for (const [key, residual] of monitoring.residuals.entries()) {
    riskNumbers.push({
        value: key,
        label: residual.risk_cause_number,
        customProperties: residual,
        selected: key == 0
    })
}

residualRiskCauseNumberChoices.clearChoices().setChoices(riskNumbers);

let currentResidual = 0;
residualRiskCauseNumber.addEventListener('change', (e) => {
    const selected = residualRiskCauseNumberChoices.getValue(false)
    if (!selected) return
    const item = selected.customProperties

    currentResidual = selected.value
    residualRiskImpactCategory.value = item.risk_impact_category

    residualTextareas['risk_chronology_body'].value = item.risk_chronology_body
    residualQuills['risk_chronology_body'].root.innerHTML = item.risk_chronology_body
    residualQuills['risk_chronology_body'].emitter.emit('text-change')

    let current = monitoring.residuals[currentResidual]
    let residual = {}
    current?.residual?.forEach((item, key) => {
        if (key == currentQuarter) {
            residual = item
        }
    })

    residualImpactValue[`residual[${currentQuarter}][impact_value]`].value = residual?.impact_value ? formatNumeral(residual.impact_value, defaultConfigFormatNumeral) : ''
    residualImpactScaleSelects[`residual[${currentQuarter}][impact_scale]`].setChoiceByValue(residual?.impact_scale ?? 'Pilih')
    residualImpactProbability[`residual[${currentQuarter}][impact_probability]`].value = residual?.impact_probability ?? ''
    residualRiskMitigationEffectiveness.value = current?.risk_mitigation_effectiveness ?? ''

    calculateRisk(currentQuarter)
})

const residualImpactValue = {}
const residualImpactScale = {}
const residualImpactScaleSelects = {}
const residualImpactProbability = {}
const residualImpactProbabilityScale = {}
const residualImpactProbabilityScaleSelects = {}
const residualRiskExposure = {}
const residualRiskScale = {}
const residualRiskLevel = {}

for (let element of residualForm.querySelectorAll('input, select')) {
    if (element.name == 'risk_cause_number') {
        continue;
    }

    if (element.name.includes('[impact_value]')) {
        residualImpactValue[element.name] = element
        residualImpactValue[element.name].addEventListener('input', e => {
            e.target.value = formatNumeral(e.target.value, defaultConfigFormatNumeral)
            calculateRisk(currentQuarter)
        })
    } else if (element.name.includes('[impact_scale]')) {
        residualImpactScale[element.name] = element
        residualImpactScaleSelects[element.name] = new Choices(element, defaultConfigChoices)

        const choices = [];
        fetchers.bumn_scales.forEach(bumnScale => {
            if (bumnScale.impact_category == residualRiskImpactCategory.value.toLowerCase()) {
                choices.push({
                    value: bumnScale.id.toString(),
                    label: bumnScale.scale,
                    selected: bumnScale.id == element.value,
                    customProperties: bumnScale
                })
            }
        });
        residualImpactScaleSelects[element.name].setChoices(choices).disable();
        element.addEventListener('change', (e) => {
            calculateRisk(currentQuarter)
        })
    } else if (element.name.includes('[impact_probability]')) {
        residualImpactProbability[element.name] = element
        residualImpactProbability[element.name].addEventListener('input', e => {
            const choices = [];
            fetchers.heat_maps.forEach(heatmap => {
                choices.push({
                    value: heatmap.id,
                    label: heatmap.impact_probability,
                    selected: heatmap.id == element.value,
                    customProperties: heatmap
                })
            });

            residualImpactProbabilityScaleSelects[element.name.replaceAll('[impact_probability]', '[impact_probability_scale]')].setChoices(choices).disable();

            calculateRisk(currentQuarter)
        })
    } else if (element.name.includes('[impact_probability_scale]')) {
        residualImpactProbabilityScale[element.name] = element
        residualImpactProbabilityScaleSelects[element.name] = new Choices(element, defaultConfigChoices)
        residualImpactProbabilityScaleSelects[element.name].disable()
    } else if (element.name.includes('[risk_exposure]')) {
        residualRiskExposure[element.name] = element
    } else if (element.name.includes('[risk_scale]')) {
        residualRiskScale[element.name] = element
    } else if (element.name.includes('[risk_level]')) {
        residualRiskLevel[element.name] = element
    }
}

const calculateRisk = (quarter) => {
    let scale, probability;

    if (quarter == 0) {
        return
    }
    scale = residualImpactScaleSelects[`residual[${quarter}][impact_scale]`].getValue(false);
    probability = residualImpactScaleSelects[`residual[${quarter}][impact_scale]`]._currentState.choices.find(
        choice =>
            (scale?.customProperties?.scale) &&
            parseInt(residualImpactProbability[`residual[${quarter}][impact_probability]`].value) >= choice.customProperties.min &&
            parseInt(residualImpactProbability[`residual[${quarter}][impact_probability]`].value) <= choice.customProperties.max
    )

    let impactValue = ''
    if (residualRiskImpactCategory.value.toLowerCase() == 'kualitatif') {
        impactValue = fetchers.risk_metric?.limit ?? '0'
    } else {
        impactValue = parseFloat(unformatNumeral(residualImpactValue[`residual[${quarter}][impact_value]`].value, defaultConfigFormatNumeral));
    }

    if (scale?.customProperties?.scale && probability) {
        const probabilityValue = parseFloat(residualImpactProbability[`residual[${quarter}][impact_probability]`].value);

        if (impactValue && probabilityValue && residualRiskImpactCategory.value.toLowerCase() == 'kuantitatif') {
            residualRiskExposure[`residual[${quarter}][risk_exposure]`].value = formatNumeral(
                (impactValue * (probabilityValue / 100)).toString().replaceAll('.', ','),
                defaultConfigFormatNumeral
            );
        } else if (impactValue && probabilityValue && residualRiskImpactCategory.value.toLowerCase() == 'kualitatif') {
            residualRiskExposure[`residual[${quarter}][risk_exposure]`].value = formatNumeral(
                (1 / 100 * impactValue * parseInt(scale.customProperties.scale) * (probabilityValue / 100)).toString().replaceAll('.', ','),
                defaultConfigFormatNumeral
            );
        }

        const result = residualImpactProbabilityScaleSelects[`residual[${quarter}][impact_probability_scale]`]._currentState.choices.find(
            choice =>
                choice.customProperties.impact_scale == scale.customProperties.scale &&
                choice.customProperties.impact_probability == probability.customProperties.scale
        );

        if (result) {
            residualImpactProbabilityScaleSelects[`residual[${quarter}][impact_probability_scale]`].setChoiceByValue(result.value);
            residualRiskScale[`residual[${quarter}][risk_scale]`].value = result.customProperties.risk_scale;
            residualRiskLevel[`residual[${quarter}][risk_level]`].value = result.customProperties.risk_level;
        }
    } else {
        residualImpactProbabilityScaleSelects[`residual[${quarter}][impact_probability_scale]`].setChoiceByValue("Pilih");
        residualRiskScale[`residual[${quarter}][risk_scale]`].value = null;
        residualRiskLevel[`residual[${quarter}][risk_level]`].value = null;
        residualRiskExposure[`residual[${quarter}][risk_exposure]`].value = null;
    }

}

const residualFormSubmit = (index) => {
    const data = {
        'period_date': dayjs(monitoringPeriodPicker.selectedDates[0]).format('YYYY-MM-DD'),
        'quarter': currentQuarter,
    }

    for (const key of Object.keys(residualTextareas)) {
        data[key] = residualTextareas[key].value
    }

    for (let element of residualForm.querySelectorAll('input, select')) {
        if (element.name.includes(`[${currentQuarter}]`)) {
            if (element.name.includes('impact_probability_scale') || element.name.includes('impact_scale')) {
                data[element.name] = element.value == 'Pilih' ? '' : element.value
            } else if (element.name.includes('impact_value') || element.name.includes('risk_exposure')) {
                data[element.name] = unformatNumeral(element.value, defaultConfigFormatNumeral)
            } else {
                data[element.name] = element.value
            }
        } else if (element.name == 'risk_mitigation_effectiveness') {
            data[element.name] = element.value
        }
    }

    monitoring.residuals[index] = {
        ...monitoring.residuals[index],
        ...formatDataToStructuredObject(data)
    }
}

residualRiskCauseNumber.dispatchEvent(new Event('change'))
const actualizationData = [];
const actualizationFormTable = document.querySelector('#actualizationFormTable')
const actualizationFormTableBody = actualizationFormTable.querySelector('tbody')

const actualizationTableRows = actualizationFormTableBody.querySelectorAll('tr')
const actualizationModalElement = document.querySelector('#actualizationModal')
const actualizationModal = new Modal(actualizationModalElement, {
    keyboard: false,
    backdrop: 'static'
})
const actualizationForm = actualizationModalElement.querySelector('#actualizationForm')
const actualizationTextareas = {}
const actualizationQuills = {}
for (const textarea of actualizationForm.querySelectorAll('textarea')) {
    actualizationTextareas[textarea.name] = textarea
    actualizationQuills[textarea.name] = new Quill(actualizationForm.querySelector('#' + textarea.name + '-editor'), defaultConfigQuill);
    if (textarea.name == 'actualization_mitigation_plan') {
        actualizationQuills[textarea.name].enable(false);
    } else {
        actualizationQuills[textarea.name].on('text-change', (delta, oldDelta, source) => {
            actualizationTextareas[textarea.name].innerHTML = actualizationQuills[textarea.name].root.innerHTML;
        })
    }
}
const actualizationDocumentWrapper = actualizationForm.querySelector('#actualization_document_wrapper')

const actualizationInputs = {}
const actualizationPICRelated = actualizationForm.querySelector('[name="actualization_pic_related"]')
const actualizationPICRelatedChoice = new Choices(actualizationPICRelated, defaultConfigChoices);
actualizationPICRelatedChoice.setChoices(
    fetchers.pics.reduce((pics, pic) => {
        pics.push({
            value: pic.id.toString(),
            label: `[${pic.personnel_area_code}] ${pic.position_name}`,
            customProperties: pic
        })
        return pics;
    }, [])
)

let temporaryDocuments = [];

for (const input of actualizationForm.querySelectorAll('input, select')) {
    if (input.name == 'actualization_cost') {
        input.addEventListener('input', e => {
            e.target.value = formatNumeral(e.target.value, defaultConfigFormatNumeral)
        })
    } else if (input.name == 'actualization_pic_related') {
        continue
    } else if (input.name == 'actualization_document') {
        input.addEventListener('change', (e) => {
            const files = e.target.files
            if (files.length != 0) {
                for (const file of files) {
                    const index = temporaryDocuments.length
                    const item = document.createElement('div')
                    const button = document.createElement('button')
                    button.type = 'button'
                    button.classList.add('btn', 'btn-sm', 'btn-danger-light')
                    button.innerHTML = `<span><i class="ti ti-x"></i></span>`
                    button.addEventListener('click', () => {
                        temporaryDocuments = temporaryDocuments.filter((document, key) => key == index)
                        actualizationDocumentWrapper.querySelector(`#actualization-document-items-${index}`).remove()
                    })

                    item.id = `actualization-document-items-${index}`
                    item.classList.add('col-12', 'd-flex', 'align-items-center', 'justify-content-between', 'badge', 'bg-outline-dark', 'p-2')
                    item.innerHTML = `<span>${file.name} (${convertFileSize(file.size)})</span>`
                    item.append(button)

                    actualizationDocumentWrapper.append(item)
                    temporaryDocuments.push(file)
                }

                actualizationDocumentWrapper.classList.remove('d-none')
            } else {
                if (!actualizationDocumentWrapper.classList.contains('d-none')) {
                    actualizationDocumentWrapper.classList.add('d-none')
                }
            }
        })

        continue
    }
    actualizationInputs[input.name] = input
}

const onActualizationSave = (data) => {
    const row = actualizationFormTableBody.querySelector(`#actualization-items-${data.key}`)
    const editButton = document.createElement('button')
    editButton.type = 'button'
    editButton.classList.add('btn', 'btn-sm', 'btn-info-light')
    editButton.innerHTML = `<span><i class="ti ti-edit"></i></span>`

    const picRelated = fetchers.pics.find(pic => pic.id.toString() == data.actualization_pic_related || pic.unit_code == data.actualization_pic_related)
    let picRelatedLabel = ''
    if (picRelated) {
        picRelatedLabel = `[${picRelated.personnel_area_code}] ${picRelated.position_name}`
    }
    row.innerHTML = `
        <td class="text-center">${data.risk_cause_number}</td>
        <td class="text-center">${data.actualization_mitigation_plan}</td>
        <td class="text-center">${data.actualization_plan_body}</td>
        <td class="text-center">${data.actualization_plan_output}</td>
        <td class="text-center">${data.actualization_cost ? formatNumeral(data.actualization_cost.replaceAll('.', ','), defaultConfigFormatNumeral) : ''}</td>
        <td class="text-center">${data.actualization_cost_absorption ? data.actualization_cost_absorption + '%' : ''}</td>
        <td class="text-center">${data.actualization_pic}</td>
        <td class="text-center">${picRelatedLabel}</td>
        <td class="text-center">${data.actualization_kri}</td>
        <td class="text-center">${data.actualization_kri_threshold}</td>
        <td class="text-center">${data.actualization_kri_threshold_score ? data.actualization_kri_threshold_score + '%' : ''}</td>
        <td class="text-center">${data.actualization_plan_status}</td>
        <td class="text-center">${data.actualization_plan_explanation}</td>
        <td class="text-center">${data.hasOwnProperty('actualization_plan_progress[1]') ? data['actualization_plan_progress[1]'] + '%' : ''}</td>
        <td class="text-center">${data.hasOwnProperty('actualization_plan_progress[2]') ? data['actualization_plan_progress[2]'] + '%' : ''}</td>
        <td class="text-center">${data.hasOwnProperty('actualization_plan_progress[3]') ? data['actualization_plan_progress[3]'] + '%' : ''}</td>
        <td class="text-center">${data.hasOwnProperty('actualization_plan_progress[4]') ? data['actualization_plan_progress[4]'] + '%' : ''}</td>
    `;

    row.prepend(editButton)
    editButton.addEventListener('click', (e) => {
        actualizationEdit(data.key, data)
    })
    actualizationModal.hide()
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Realisasi Pelaksanaan Perlakuan Risiko dan Biaya berhasil disimpan',
    })
}

monitoring.actualizations.forEach((actualization, index) => {
    const row = document.createElement('tr')
    row.id = `actualization-items-${index}`

    const editButton = document.createElement('button')
    editButton.type = 'button'
    editButton.classList.add('btn', 'btn-sm', 'btn-info-light')
    editButton.innerHTML = `<span><i class="ti ti-edit"></i></span>`

    row.innerHTML = `
        <td class="text-center">${actualization.risk_cause_number}</td>
        <td class="text-center">${actualization.actualization_mitigation_plan}</td>
        <td class="text-center">${actualization.actualization_plan_body}</td>
        <td class="text-center">${actualization.actualization_plan_output}</td>
        <td class="text-center">${actualization.actualization_cost ? formatNumeral(actualization.actualization_cost.replaceAll('.', ','), defaultConfigFormatNumeral) : ''}</td>
        <td class="text-center">${actualization.actualization_cost_absorption ? actualization.actualization_cost_absorption + '%' : ''}</td>
        <td class="text-center">${actualization.actualization_pic}</td>
        <td class="text-center">${actualization.actualization_pic_related}</td>
        <td class="text-center">${actualization.actualization_kri}</td>
        <td class="text-center">${actualization.actualization_kri_threshold}</td>
        <td class="text-center">${actualization.actualization_kri_threshold_score ? actualization.actualization_kri_threshold_score + '%' : ''}</td>
        <td class="text-center">${actualization.actualization_plan_status}</td>
        <td class="text-center">${actualization.hasOwnProperty('actualization_plan_progress[1]') ? actualization['actualization_plan_progress[1]'] + '%' : ''}</td>
        <td class="text-center">${actualization.hasOwnProperty('actualization_plan_progress[2]') ? actualization['actualization_plan_progress[2]'] + '%' : ''}</td>
        <td class="text-center">${actualization.hasOwnProperty('actualization_plan_progress[3]') ? actualization['actualization_plan_progress[3]'] + '%' : ''}</td>
        <td class="text-center">${actualization.hasOwnProperty('actualization_plan_progress[4]') ? actualization['actualization_plan_progress[4]'] + '%' : ''}</td>
    `;

    row.prepend(editButton)
    editButton.addEventListener('click', (e) => {
        actualizationEdit(index, actualization)
    })

    actualizationFormTableBody.appendChild(row)
})

const actualizationEdit = (index, data) => {
    for (let key of Object.keys(data)) {
        if (key == 'actualization_pic_related') {
            const pic = fetchers.pics.find(pic => pic.id.toString() == data[key] || pic.unit_code == data[key])
            if (pic) {
                actualizationPICRelatedChoice.setChoiceByValue(pic.id.toString());
            }
            continue;
        }

        const input = actualizationInputs[key]
        if (input) {
            if (key == 'actualization_cost') {
                input.value = formatNumeral(data[key].replaceAll('.', ','), defaultConfigFormatNumeral)
            } else {
                input.value = data[key]
            }
        } else {
            const textarea = actualizationTextareas[key]
            if (textarea) {
                textarea.innerHTML = data[key]
                actualizationQuills[key].root.innerHTML = data[key]
                actualizationQuills[key].emitter.emit('text-change')
            }
        }
    }

    actualizationModal.show()
}

actualizationForm.addEventListener('submit', (e) => {
    e.preventDefault()
    const data = Object.fromEntries(new FormData(e.target))
    data.actualization_cost = unformatNumeral(data.actualization_cost, defaultConfigFormatNumeral)

    const current = monitoring.actualizations[data.key]
    current.actualization_documents = temporaryDocuments


    for (const key of Object.keys(current)) {
        if (key == 'key' || key == 'id') continue
        current[key] = data[key] ?? current[key]
    }

    monitoring.actualizations[data.key] = current
    onActualizationSave(current)
});

actualizationModalElement.addEventListener('hidden.bs.modal', (e) => {
    actualizationForm.reset()
    actualizationDocumentWrapper.innerHTML = '';

    actualizationPICRelatedChoice.clearChoices()
    actualizationPICRelatedChoice.setChoices(
        fetchers.pics.reduce((pics, pic) => {
            pics.push({
                value: pic.id.toString(),
                label: `[${pic.personnel_area_code}] ${pic.position_name}`,
                customProperties: pic
            })
            return pics;
        }, [{ value: 'Pilih', label: 'Pilih' }])
    )
    actualizationPICRelatedChoice.setChoiceByValue('Pilih')
    temporaryDocuments = [];
})

actualizationForm.addEventListener('reset', (e) => {
    e.preventDefault()
    actualizationModal.hide()
})

const monitoringEnableQuarter = (quarter) => {
    if (!quarter) return
    if (residualRiskImpactCategory.value.toLowerCase() == 'kualitatif') {
        enableQuarterQualitative(quarter)
    } else if (residualRiskImpactCategory.value.toLowerCase() == 'kuantitatif') {
        enableQuarterQuantitative(quarter)
    }
}

const enableQuarterQualitative = (quarter) => {
    for (let q = 1; q <= 4; q++) {
        if (q == quarter) {
            residualImpactScale[`residual[${q}][impact_scale]`].disabled = false;
            residualImpactScaleSelects[`residual[${q}][impact_scale]`].enable();
            residualImpactScale[`residual[${q}][impact_scale]`].classList.remove('not-allowed')
            residualImpactProbability[`residual[${q}][impact_probability]`].disabled = false;
            residualImpactProbability[`residual[${q}][impact_probability]`].classList.remove('not-allowed')
            actualizationInputs[`actualization_plan_progress[${q}]`].value = '';
            actualizationInputs[`actualization_plan_progress[${q}]`].disabled = false;
            actualizationInputs[`actualization_plan_progress[${q}]`].classList.remove('not-allowed')

            monitoring.actualizations.map(actualization => {
                if (!actualization.hasOwnProperty(`actualization_plan_progress[${q}]`)) {
                    actualization[`actualization_plan_progress[${q}]`] = q
                }

                actualization.quarter = q
                return actualization;
            })
        } else {

            residualImpactScale[`residual[${q}][impact_scale]`].disabled = true;
            residualImpactScale[`residual[${q}][impact_scale]`].value = '';
            residualImpactScaleSelects[`residual[${q}][impact_scale]`].setChoiceByValue('Pilih').disable()
            if (!residualImpactScale[`residual[${q}][impact_scale]`].classList.contains('not-allowed')) {
                residualImpactScale[`residual[${q}][impact_scale]`].classList.add('not-allowed')
            }
            residualImpactProbability[`residual[${q}][impact_probability]`].disabled = true;
            residualImpactProbability[`residual[${q}][impact_probability]`].value = '';
            if (!residualImpactProbability[`residual[${q}][impact_probability]`].classList.contains('not-allowed')) {
                residualImpactProbability[`residual[${q}][impact_probability]`].classList.add('not-allowed')
            }

            residualImpactProbabilityScaleSelects[`residual[${q}][impact_probability_scale]`].setChoiceByValue('Pilih')
            residualRiskExposure[`residual[${q}][risk_exposure]`].value = '';
            residualRiskScale[`residual[${q}][risk_scale]`].value = '';
            residualRiskLevel[`residual[${q}][risk_level]`].value = '';

            actualizationInputs[`actualization_plan_progress[${q}]`].value = '';
            actualizationInputs[`actualization_plan_progress[${q}]`].disabled = true;
            if (!actualizationInputs[`actualization_plan_progress[${q}]`].classList.contains('not-allowed')) {
                actualizationInputs[`actualization_plan_progress[${q}]`].classList.remove('not-allowed')
            }

            monitoring.actualizations.map(actualization => {
                if (actualization.hasOwnProperty(`actualization_plan_progress[${q}]`)) {
                    delete actualization[`actualization_plan_progress[${q}]`]
                }

                return actualization;
            })
        }

        actualizationTableRows.forEach(row => {
            for (let col of row.querySelectorAll('td')) {
                if (col.dataset?.name == 'quarter') {
                    col.innerHTML = q
                } else if (col.dataset?.name?.includes('actualization_progress')) {
                    if (col.dataset.name != `actualization_plan_progress[${q}]`) {
                        col.innerHTML = ''
                    }
                }
            }
        })
    }
}
const enableQuarterQuantitative = (quarter) => {
    for (let q = 1; q <= 4; q++) {
        if (q == quarter) {
            residualImpactValue[`residual[${q}][impact_value]`].disabled = false;
            residualImpactValue[`residual[${q}][impact_value]`].classList.remove('not-allowed')
            residualImpactScale[`residual[${q}][impact_scale]`].disabled = false;
            residualImpactScaleSelects[`residual[${q}][impact_scale]`].enable();
            residualImpactScale[`residual[${q}][impact_scale]`].classList.remove('not-allowed')
            residualImpactProbability[`residual[${q}][impact_probability]`].disabled = false;
            residualImpactProbability[`residual[${q}][impact_probability]`].classList.remove('not-allowed')
            actualizationInputs[`actualization_plan_progress[${q}]`].value = null;
            actualizationInputs[`actualization_plan_progress[${q}]`].disabled = false;
            actualizationInputs[`actualization_plan_progress[${q}]`].classList.remove('not-allowed')

            monitoring.actualizations.map(actualization => {
                if (!actualization.hasOwnProperty(`actualization_plan_progress[${q}]`)) {
                    actualization[`actualization_plan_progress[${q}]`] = q
                }

                actualization.quarter = q
                return actualization;
            })
        } else {
            residualImpactValue[`residual[${q}][impact_value]`].disabled = true;
            residualImpactValue[`residual[${q}][impact_value]`].value = null;
            if (!residualImpactValue[`residual[${q}][impact_value]`].classList.contains('not-allowed')) {
                residualImpactValue[`residual[${q}][impact_value]`].classList.add('not-allowed')
            }
            residualImpactScale[`residual[${q}][impact_scale]`].disabled = true;
            residualImpactScale[`residual[${q}][impact_scale]`].value = null;
            residualImpactScaleSelects[`residual[${q}][impact_scale]`].setChoiceByValue('Pilih').disable()
            if (!residualImpactScale[`residual[${q}][impact_scale]`].classList.contains('not-allowed')) {
                residualImpactScale[`residual[${q}][impact_scale]`].classList.add('not-allowed')
            }
            residualImpactProbability[`residual[${q}][impact_probability]`].disabled = true;
            residualImpactProbability[`residual[${q}][impact_probability]`].value = null;
            if (!residualImpactProbability[`residual[${q}][impact_probability]`].classList.contains('not-allowed')) {
                residualImpactProbability[`residual[${q}][impact_probability]`].classList.add('not-allowed')
            }

            residualImpactProbabilityScaleSelects[`residual[${q}][impact_probability_scale]`].setChoiceByValue('Pilih')
            residualRiskExposure[`residual[${q}][risk_exposure]`].value = null;
            residualRiskScale[`residual[${q}][risk_scale]`].value = null;
            residualRiskLevel[`residual[${q}][risk_level]`].value = null;

            actualizationInputs[`actualization_plan_progress[${q}]`].value = null;
            actualizationInputs[`actualization_plan_progress[${q}]`].disabled = true;
            if (!actualizationInputs[`actualization_plan_progress[${q}]`].classList.contains('not-allowed')) {
                actualizationInputs[`actualization_plan_progress[${q}]`].classList.remove('not-allowed')
            }

            monitoring.actualizations.map(actualization => {
                if (actualization.hasOwnProperty(`actualization_plan_progress[${q}]`)) {
                    delete actualization[`actualization_plan_progress[${q}]`]
                }

                return actualization;
            })
        }

        actualizationTableRows.forEach(row => {
            for (let col of row.querySelectorAll('td')) {
                if (col.dataset?.name == 'quarter') {
                    col.innerHTML = q
                } else if (col.dataset?.name?.includes('actualization_progress')) {
                    if (col.dataset.name != `actualization_plan_progress[${q}]`) {
                        col.innerHTML = ''
                    }
                }
            }
        })
    }
}

monitoringEnableQuarter(currentQuarter)

const alterationForm = document.querySelector('#alterationForm');
const alterationTextareas = {}
const alterationQuills = {}

for (const textarea of alterationForm.querySelectorAll('textarea')) {
    alterationTextareas[textarea.name] = textarea
    alterationQuills[textarea.name] = new Quill(alterationForm.querySelector('#' + textarea.name + '-editor'), defaultConfigQuill);
    alterationQuills[textarea.name].on('text-change', (delta, oldDelta, source) => {
        alterationTextareas[textarea.name].innerHTML = alterationQuills[textarea.name].root.innerHTML;
    })
}

const alterationFormSubmit = () => {
    const data = Object.fromEntries(new FormData(alterationForm));
    monitoring.alteration = data
}

const incidentForm = document.querySelector('#incidentForm');
const incidentTextareas = {}
const incidentQuills = {}

for (const textarea of incidentForm.querySelectorAll('textarea')) {
    incidentTextareas[textarea.name] = textarea
    incidentQuills[textarea.name] = new Quill(incidentForm.querySelector('#' + textarea.name + '-editor'), defaultConfigQuill);
    incidentQuills[textarea.name].on('text-change', (delta, oldDelta, source) => {
        incidentTextareas[textarea.name].innerHTML = incidentQuills[textarea.name].root.innerHTML;
    })
}

const incidentSelects = {}
const incidentChoices = {}
for (let select of incidentForm.querySelectorAll('.form-select')) {
    incidentSelects[select.name] = select
    incidentChoices[select.name] = new Choices(select, defaultConfigChoices);

    if (select.name == 'risk_category') {
        incidentChoices[select.name].disable()
        continue;
    }

    if (select.name == 'risk_category_t3') {
        incidentSelects[select.name].addEventListener('change', e => {
            incidentSelects['risk_category'].value = e.target.value
            incidentChoices['risk_category'].setChoiceByValue(e.target.value.toString())
        })
    }
}

const incidentLossValue = incidentForm.querySelector('[name="loss_value"]');
incidentLossValue.addEventListener('input', e => {
    e.target.value = formatNumeral(e.target.value, defaultConfigFormatNumeral);
});

const incidentInsurancePermit = incidentForm.querySelector('[name="insurance_permit"]');
incidentInsurancePermit.addEventListener('input', e => {
    e.target.value = formatNumeral(e.target.value, defaultConfigFormatNumeral);
});

const incidentInsuranceClaim = incidentForm.querySelector('[name="insurance_claim"]');
incidentInsuranceClaim.addEventListener('input', e => {
    e.target.value = formatNumeral(e.target.value, defaultConfigFormatNumeral);
});

const incidentFormSubmit = () => {
    const data = Object.fromEntries(new FormData(incidentForm));
    data.loss_value = unformatNumeral(data.loss_value, defaultConfigFormatNumeral);
    data.insurance_permit = unformatNumeral(data.insurance_permit, defaultConfigFormatNumeral);
    data.insurance_claim = unformatNumeral(data.insurance_claim, defaultConfigFormatNumeral);

    monitoring.incident = data
}

const save = async () => {
    const data = { ...monitoring }
    data.actualizations = data.actualizations.map(actualization => {
        actualization.actualization_plan_progress = actualization[`actualization_plan_progress[${currentQuarter}]`]
        delete actualization[`actualization_plan_progress[${currentQuarter}]`]

        const picRelated = fetchers.pics.find(pic => pic?.id?.toString() == actualization.actualization_pic_related)
        if (picRelated) {
            delete picRelated.id
            actualization = { ...actualization, ...picRelated }
        }

        return actualization;
    })
    console.log(data.actualizations)
    const formData = jsonToFormData(data)
    const response = await axios.post(window.location.href, formData);
    let redirect = false;

    if (response.status == 200) {
        redirect = response.data.data.redirect
    }

    Swal.fire({
        icon: response.status == 200 ? 'success' : 'error',
        title: response.status == 200 ? 'Berhasil' : 'Gagal',
        text: response.data.message,
    }).then(() => {
        setTimeout(() => {
            if (redirect) {
                window.location.replace(redirect)
            }
        }, 375);
    })
}