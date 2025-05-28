import { Modal, Tab } from 'bootstrap';
import { formatNumeral, unformatNumeral } from 'cleave-zen';
import Choices from 'choices.js';
import Quill from 'quill';
import 'quill/dist/quill.snow.css';
import '~css//quill.css';
import flatpickr from 'flatpickr';
import axios from 'axios';
import dayjs from 'dayjs';
import 'dayjs/locale/id';
import {
	convertFileSize,
	defaultConfigChoices,
	defaultConfigFormatNumeral,
	defaultConfigQuill,
	defaultLocaleFlatpickr,
	generateRandomKey,
	jsonToFormData,
	renderBadge,
	calculateCostAbsorptionPercentage
} from '~js/components/helper';
import Swal from 'sweetalert2';

dayjs.locale('id');

let currentStep = 0;
const totalStep = 3;
const monitoring = {
	residual: {},
	residual_target: [],
	actualizations: [],
};

let inherent = {};

const monitoringTab = document.querySelector('#monitoringTab');
const monitoringTabList = monitoringTab.querySelectorAll('li');
const monitoringTabNavs = monitoringTab.querySelectorAll('a');

monitoringTabNavs.forEach((trigger, index) => {
	trigger.addEventListener('click', (e) => {
		if (index !== currentStep) {
			e.preventDefault(); // Prevent Bootstrap's default behavior
			e.stopPropagation(); // Stop event bubbling
		}
	});
});
const navigateToTab = (index) => {
	const nextTab = monitoringTabNavs[index];

	if (nextTab) {
		// Activate the target tab
		const tabInstance = new Tab(nextTab);
		tabInstance.show();
		currentStep = index;
	}
};

const monitoringTabNextButton = document.querySelector(
	'#monitoringTabNextButton'
);
const monitoringTabPreviousButton = document.querySelector(
	'#monitoringTabPreviousButton'
);
const monitoringTabSubmitButton = document.querySelector(
	'#monitoringTabSubmitButton'
);

monitoringTabSubmitButton.addEventListener('click', async (e) => save());

monitoringTabNextButton.addEventListener('click', (e) => {
	currentStep += 1;

	if (currentStep == 1) {
		if (!actualizationValidate()) {
			currentStep -= 1;
			Swal.fire({
				icon: 'warning',
				text: 'Pastikan seluruh isian Realisasi Pelaksanaan Perlakuan Risiko dan Biaya telah diisi',
			});
			return;
		}
	} else if (currentStep == 2) {
		if (!residualValidate()) {
			currentStep -= 1;
			Swal.fire({
				icon: 'warning',
				text: 'Pastikan seluruh isian Realisasi Risiko Residual telah diisi',
			});
			return;
		}

		residualBlockOnMap();
	}

	const previousTab = monitoringTabList[currentStep - 1].querySelector('h2');
	const currentTab = monitoringTabList[currentStep].querySelector('h2');

	previousTab.classList.remove('bg-success', 'text-white');
	previousTab.classList.add('bg-light', 'text-dark');
	currentTab.classList.remove('bg-light', 'text-dark');
	currentTab.classList.add('bg-success', 'text-white');

	if (
		currentStep > 0 &&
		monitoringTabPreviousButton.classList.contains('d-none')
	) {
		monitoringTabPreviousButton.classList.remove('d-none');
	}

	if (
		currentStep == totalStep - 1 &&
		monitoringTabSubmitButton.classList.contains('d-none')
	) {
		monitoringTabSubmitButton.classList.remove('d-none');
		monitoringTabNextButton.classList.add('d-none');
	}
	navigateToTab(currentStep);
});

monitoringTabPreviousButton.addEventListener('click', (e) => {
	currentStep -= 1;
	const previousTab = monitoringTabList[currentStep + 1].querySelector('h2');
	const currentTab = monitoringTabList[currentStep].querySelector('h2');

	previousTab.classList.remove('bg-success', 'text-white');
	previousTab.classList.add('bg-light', 'text-dark');
	currentTab.classList.remove('bg-light', 'text-dark');
	currentTab.classList.add('bg-success', 'text-white');

	if (
		currentStep == 0 &&
		!monitoringTabPreviousButton.classList.contains('d-none')
	) {
		monitoringTabPreviousButton.classList.add('d-none');
	}

	if (currentStep < totalStep - 1) {
		if (!monitoringTabSubmitButton.classList.contains('d-none')) {
			monitoringTabSubmitButton.classList.add('d-none');
		}

		monitoringTabNextButton.classList.remove('d-none');
	}
	navigateToTab(currentStep);
});

const residualValidate = () => {
	for (let key of Object.keys(monitoring.residual)) {
		if (key == 'impact_value') continue;
		if (!monitoring.residual[key] || monitoring.residual[key] == 'Pilih') {
			return false;
		}
	}
	return true;
};

const actualizationValidate = () => {
	for (let actualization of monitoring.actualizations) {
		for (let key of Object.keys(actualization)) {
			if (
				[
					'actualization_pic_related',
					'actualization_plan_explanation',
					'actualization_cost_absorption',
					'actualization_mitigation_cost',
					'actualization_cost_absorption',
					'key',
				].includes(key)
			) {
				continue;
			}

			if (
				!actualization[key] ||
				actualization[key] == 'Pilih' ||
				actualization[key]?.length < 1
			) {
				console.log(key, actualization[key])
				return false;
			}
		}
	}

	return true;
};

/** End of stepper */

const fetchers = {
	bumn_scales: [],
	heat_maps: [],
	pics: [],
	risk_metric: {},
};

const fetchData = async () => {
	await Promise.allSettled([
		axios.get('/master/data/bumn-scales'),
		axios.get('/master/data/heatmaps'),
		axios.get('/master/data/pics'),
		axios.get('/profile/risk_metric'),
		axios.get(window.location.href),
	]).then((res) => {
		for (let [index, key] of Object.keys(fetchers).entries()) {
			if (res[index].status == 'fulfilled') {
				const response = res[index].value;
				if (response.status == 200) {
					fetchers[key] = response.data.data;
				}
			}
		}

		if (res[4].status == 'fulfilled') {
			const response = res[4].value;
			if (response.status == 200) {
				const data = response.data.data;
				inherent = data.inherent;
				monitoring.residual = data.residual;
				monitoring.residual_target = data.residual_target;
				monitoring.actualizations = data.actualizations;
			}
		}
	});
};

await fetchData();
let currentQuarter = 1;

const inherentBlock = document.querySelector(
	`#inherent-${inherent.risk_scale}`
);
if (inherentBlock) {
	inherentBlock.parentNode.insertAdjacentHTML(
		`beforeend`,
		`<circle id="inherent-risk-scale" fill="#5A9AEB" r="6" cx="${inherentBlock.x.baseVal[0].value + 6
		}" cy="${inherentBlock.y.baseVal[0].value}"></circle>`
	);
}

const residualBlockOnMap = () => {
	const chart = document.querySelector('#risk-chart');
	for (let [index, circle] of chart.querySelectorAll('circle').entries()) {
		if (circle.id == 'inherent-risk-scale') continue;

		circle.remove();
	}

	if (monitoring.residual) {
		const block = document.querySelector(
			`#inherent-${monitoring.residual?.risk_scale}`
		);
		if (block) {
			let [x, y] = [8, -4];

			if (
				monitoring.residual?.risk_scale ==
				inherent?.risk_scale
			) {
				x += parseInt(block.x.baseVal[0].value) + 12;
				y += parseInt(block.y.baseVal[0].value);
			} else {
				x += parseInt(block.x.baseVal[0].value);
				y += parseInt(block.y.baseVal[0].value);
			}

			block.parentNode.insertAdjacentHTML(
				`beforeend`,
				`<circle fill="#9A9B9D" r="6" cx="${x}" cy="${y}"/>`
			);
		}
	}
};

const residualForm = document.querySelector('#residualForm');
const residualRiskImpactCategory = residualForm.querySelector(
	'[name="risk_impact_category"]'
);
const residualTextareas = {};
const residualQuills = {};
for (const textarea of residualForm.querySelectorAll('textarea')) {
	if (textarea.name == 'actualization_kri_threshold_score') continue;
	residualTextareas[textarea.name] = textarea;
	residualQuills[textarea.name] = new Quill(
		residualForm.querySelector('#' + textarea.name + '-editor'),
		defaultConfigQuill
	);
	residualQuills[textarea.name].root.innerHTML = textarea.value;
	residualQuills[textarea.name].enable(false);
}

const monitoringPeriodDate = residualForm.querySelector('[name="period_date"]');
const monitoringPeriodPicker = flatpickr(monitoringPeriodDate, {
	enableTime: false,
	dateFormat: 'Y-m-d',
	altInput: true,
	altFormat: 'j F Y',
	locale: defaultLocaleFlatpickr,
	onChange: (selectedDates, dateStr, instance) => {
		const value = dayjs(dateStr);
		currentQuarter = Math.ceil((value.month() + 1) / 3);
		monitoring.residual.period_date = value.format('YYYY-MM-DD');
		monitoring.residual.quarter = currentQuarter;
		monitoringEnableQuarter(currentQuarter);
		calculateRisk(currentQuarter);
	},
});

const residualRiskMitigationEffectiveness = residualForm.querySelector(
	'[name="risk_mitigation_effectiveness"]'
);
const residualRiskMitigationEffectivenessChoices = new Choices(residualRiskMitigationEffectiveness, {
	...defaultConfigChoices,
	searchEnabled: false,
});
residualRiskMitigationEffectivenessChoices.disable();

const residualImpactValue = {};
const residualImpactScale = {};
const residualImpactScaleSelects = {};
const residualImpactProbability = {};
const residualImpactProbabilityScale = {};
const residualImpactProbabilityScaleSelects = {};
const residualRiskExposure = {};
const residualRiskScale = {};
const residualRiskLevel = {};

for (let element of residualForm.querySelectorAll('input, select')) {
	if (element.name == 'risk_cause_number') {
		continue;
	}

	if (element.name.includes('[impact_value]')) {
		residualImpactValue[element.name] = element;
		residualImpactValue[element.name].addEventListener('input', (e) => {
			e.target.value = formatNumeral(
				e.target.value,
				defaultConfigFormatNumeral
			);
			calculateRisk(currentQuarter);
		});
	} else if (element.name.includes('[impact_scale]')) {
		residualImpactScale[element.name] = element;
		residualImpactScaleSelects[element.name] = new Choices(
			element,
			defaultConfigChoices
		);

		const choices = [];
		fetchers.bumn_scales.forEach((bumnScale) => {
			if (
				bumnScale.impact_category ==
				residualRiskImpactCategory.value.toLowerCase()
			) {
				choices.push({
					value: bumnScale.id.toString(),
					label: bumnScale.scale,
					selected: bumnScale.id == element.value,
					customProperties: bumnScale,
				});
			}
		});
		residualImpactScaleSelects[element.name].setChoices(choices).disable();
		element.addEventListener('change', (e) => {
			calculateRisk(currentQuarter);
		});
	} else if (element.name.includes('[impact_probability]')) {
		residualImpactProbability[element.name] = element;
		residualImpactProbability[element.name].addEventListener(
			'input',
			(e) => {
				const choices = [];
				fetchers.heat_maps.forEach((heatmap) => {
					choices.push({
						value: heatmap.id,
						label: heatmap.impact_probability,
						selected: heatmap.id == element.value,
						customProperties: heatmap,
					});
				});

				residualImpactProbabilityScaleSelects[
					element.name.replaceAll(
						'[impact_probability]',
						'[impact_probability_scale]'
					)
				]
					.setChoices(choices)
					.disable();

				calculateRisk(currentQuarter);
			}
		);
	} else if (element.name.includes('[impact_probability_scale]')) {
		residualImpactProbabilityScale[element.name] = element;
		residualImpactProbabilityScaleSelects[element.name] = new Choices(
			element,
			defaultConfigChoices
		);
		residualImpactProbabilityScaleSelects[element.name].disable();
	} else if (element.name.includes('[risk_exposure]')) {
		residualRiskExposure[element.name] = element;
	} else if (element.name.includes('[risk_scale]')) {
		residualRiskScale[element.name] = element;
	} else if (element.name.includes('[risk_level]')) {
		residualRiskLevel[element.name] = element;
	}
}

const calculateRisk = (quarter) => {
	let scale, probability;

	if (quarter == 0) {
		return;
	}
	scale =
		residualImpactScaleSelects[
			`residual[${quarter}][impact_scale]`
		].getValue(false);
	probability = residualImpactScaleSelects[
		`residual[${quarter}][impact_scale]`
	]._currentState.choices.find(
		(choice) =>
			scale?.customProperties?.scale &&
			parseInt(
				residualImpactProbability[
					`residual[${quarter}][impact_probability]`
				].value
			) >= choice.customProperties.min &&
			parseInt(
				residualImpactProbability[
					`residual[${quarter}][impact_probability]`
				].value
			) <= choice.customProperties.max
	);

	let impactValue = '';
	if (residualRiskImpactCategory.value.toLowerCase() == 'kualitatif') {
		impactValue = fetchers.risk_metric?.limit ?? '0';
	} else {
		impactValue = parseFloat(
			unformatNumeral(
				residualImpactValue[`residual[${quarter}][impact_value]`].value,
				defaultConfigFormatNumeral
			)
		);
	}

	if (scale?.customProperties?.scale && probability) {
		const probabilityValue = parseFloat(
			residualImpactProbability[
				`residual[${quarter}][impact_probability]`
			].value
		);

		if (
			impactValue &&
			probabilityValue &&
			residualRiskImpactCategory.value.toLowerCase() == 'kuantitatif'
		) {
			residualRiskExposure[`residual[${quarter}][risk_exposure]`].value =
				formatNumeral(
					(impactValue * (probabilityValue / 100))
						.toString()
						.replaceAll('.', ','),
					defaultConfigFormatNumeral
				);
		} else if (
			impactValue &&
			probabilityValue &&
			residualRiskImpactCategory.value.toLowerCase() == 'kualitatif'
		) {
			residualRiskExposure[`residual[${quarter}][risk_exposure]`].value =
				formatNumeral(
					(
						(1 / 100) *
						impactValue *
						parseInt(scale.customProperties.scale) *
						(probabilityValue / 100)
					)
						.toString()
						.replaceAll('.', ','),
					defaultConfigFormatNumeral
				);
		}

		const result = residualImpactProbabilityScaleSelects[
			`residual[${quarter}][impact_probability_scale]`
		]._currentState.choices.find(
			(choice) =>
				choice.customProperties.impact_scale ==
				scale.customProperties.scale &&
				choice.customProperties.impact_probability ==
				probability.customProperties.scale
		);

		if (result) {
			residualImpactProbabilityScaleSelects[
				`residual[${quarter}][impact_probability_scale]`
			].setChoiceByValue(result.value);
			residualRiskScale[`residual[${quarter}][risk_scale]`].value =
				result.customProperties.risk_scale;
			residualRiskLevel[`residual[${quarter}][risk_level]`].value =
				result.customProperties.risk_level;
		}
	} else {
		residualImpactProbabilityScaleSelects[
			`residual[${quarter}][impact_probability_scale]`
		].setChoiceByValue('Pilih');
		residualRiskScale[`residual[${quarter}][risk_scale]`].value = null;
		residualRiskLevel[`residual[${quarter}][risk_level]`].value = null;
		residualRiskExposure[`residual[${quarter}][risk_exposure]`].value =
			null;
	}

	monitoring.residual = {
		...monitoring.residual,
		impact_value:
			residualRiskImpactCategory.value.toLowerCase() == 'kualitatif'
				? ''
				: impactValue,
		impact_scale:
			residualImpactScale[`residual[${quarter}][impact_scale]`].value,
		impact_probability:
			residualImpactProbability[
				`residual[${quarter}][impact_probability]`
			].value,
		impact_probability_scale:
			residualImpactProbabilityScale[
				`residual[${quarter}][impact_probability_scale]`
			].value,
		risk_exposure:
			residualRiskExposure[`residual[${quarter}][risk_exposure]`].value,
		risk_scale: residualRiskScale[`residual[${quarter}][risk_scale]`].value,
		risk_level: residualRiskLevel[`residual[${quarter}][risk_level]`].value,
	};

	const residualTarget = monitoring.residual_target.find(item => item.quarter == quarter)
	const impactProbability = parseInt(monitoring?.residual?.impact_probability || 0)
	if (residualTarget && impactProbability) {
		if (impactProbability <= residualTarget.impact_probability) {
			monitoring.residual.risk_mitigation_effectiveness = '1'
			residualRiskMitigationEffectivenessChoices.setChoiceByValue('1')
		} else {
			monitoring.residual.risk_mitigation_effectiveness = '0'
			residualRiskMitigationEffectivenessChoices.setChoiceByValue('0')
		}
	} else {
		monitoring.residual.risk_mitigation_effectiveness = ''
		residualRiskMitigationEffectivenessChoices.setChoiceByValue('')
	}
};

let residual = {};
monitoring.residual?.residual?.forEach((item, key) => {
	if (key == currentQuarter) {
		residual = item;
	}
});

residualImpactValue[`residual[${currentQuarter}][impact_value]`].value =
	residual?.impact_value
		? formatNumeral(residual.impact_value, defaultConfigFormatNumeral)
		: '';
residualImpactScaleSelects[
	`residual[${currentQuarter}][impact_scale]`
].setChoiceByValue(residual?.impact_scale ?? 'Pilih');
residualImpactProbability[
	`residual[${currentQuarter}][impact_probability]`
].value = residual?.impact_probability ?? '';
residualRiskMitigationEffectiveness.value =
	monitoring.residual?.risk_mitigation_effectiveness ?? '';

calculateRisk(currentQuarter);

const actualizationFormTable = document.querySelector(
	'#actualizationFormTable'
);
const actualizationFormTableBody =
	actualizationFormTable.querySelector('tbody');

const actualizationTableRows =
	actualizationFormTableBody.querySelectorAll('tr');
const actualizationModalElement = document.querySelector('#actualizationModal');
const actualizationModal = new Modal(actualizationModalElement, {
	keyboard: false,
	backdrop: 'static',
});
const actualizationForm =
	actualizationModalElement.querySelector('#actualizationForm');
const actualizationTextareas = {};
const actualizationQuills = {};
for (const textarea of actualizationForm.querySelectorAll('textarea')) {
	if (textarea.name == 'actualization_kri_threshold_score') continue;
	actualizationTextareas[textarea.name] = textarea;
	actualizationQuills[textarea.name] = new Quill(
		actualizationForm.querySelector('#' + textarea.name + '-editor'),
		defaultConfigQuill
	);
	if (['actualization_mitigation_plan', 'risk_cause_body'].includes(textarea.name)) {
		actualizationQuills[textarea.name].enable(false);
	} else {
		actualizationQuills[textarea.name].on(
			'text-change',
			(delta, oldDelta, source) => {
				actualizationTextareas[textarea.name].innerHTML =
					actualizationQuills[textarea.name].root.innerHTML;
			}
		);
		actualizationQuills[textarea.name].enable(textarea.name !== 'actualization_plan_explanation');
	}
}
const actualizationDocumentWrapper = actualizationForm.querySelector(
	'#actualization_document_wrapper'
);

const actualizationInputs = {};
const actualizationPICRelated = actualizationForm.querySelector(
	'[name="actualization_pic_related"]'
);
const actualizationPICRelatedChoice = new Choices(
	actualizationPICRelated,
	defaultConfigChoices
);
actualizationPICRelatedChoice.setChoices(
	fetchers.pics.reduce((pics, pic) => {
		pics.push({
			value: pic.unit_code,
			label: `[${pic.personnel_area_code}] ${pic.position_name}`,
			customProperties: pic,
		});
		return pics;
	}, [])
);

const actualizationKRIThresholdSelect = actualizationForm.querySelector('[name="actualization_kri_threshold"]');
const actualizationKRIThresholdSelectChoice = new Choices(actualizationKRIThresholdSelect, defaultConfigChoices);
const kriThresholds = actualizationKRIThresholdSelectChoice._currentState.choices;

const actualizationPlanStatusSelect = actualizationForm.querySelector(
	'[name="actualization_plan_status"]'
);
const actualizationPlanStatusSelectChoice = new Choices(
	actualizationPlanStatusSelect,
	defaultConfigChoices
);

actualizationPlanStatusSelect.addEventListener('change', e => {
	actualizationQuills['actualization_plan_explanation'].enable(['discontinue', 'revisi'].includes(e.target.value))
	actualizationQuills['actualization_plan_explanation'].root.innerHTML = '';
	actualizationQuills['actualization_plan_explanation'].emitter.emit('text-change');
})

let temporaryDocuments = [];

for (const input of actualizationForm.querySelectorAll('input, select')) {
	if (input.name == 'actualization_cost') {
		input.addEventListener('input', (e) => {
			actualizationInputs['actualization_cost_absorption'].value = calculateCostAbsorptionPercentage(
				unformatNumeral(e.target.value, defaultConfigFormatNumeral) ?? '0',
				unformatNumeral(actualizationInputs['actualization_mitigation_cost'].value, defaultConfigFormatNumeral) ?? '0',
			)
			e.target.value = formatNumeral(e.target.value, defaultConfigFormatNumeral);
		});
	} else if (input.name == 'actualization_pic_related') {
		continue;
	} else if (input.name == 'actualization_document') {
		input.addEventListener('change', (e) => {
			const files = e.target.files;
			if (files.length != 0) {
				for (const file of files) {
					file.id = generateRandomKey();
					file.url = URL.createObjectURL(file);

					const item = document.createElement('div');
					item.href = file.url;
					item.target = '_blank';
					item.id = `actualization-document-items-${file.id}`;
					item.classList.add(
						'col-12',
						'd-flex',
						'align-items-center',
						'justify-content-between',
						'badge',
						'bg-outline-dark',
						'p-2'
					);
					item.innerHTML = `<div style="max-width: '70%';" class="text-truncate">(${convertFileSize(
						file.size
					)}) ${file.name}</div>`;

					const button = document.createElement('button');
					button.type = 'button';
					button.classList.add('btn', 'btn-sm', 'btn-danger-light');
					button.innerHTML = `<span><i class="ti ti-x"></i></span>`;
					button.addEventListener('click', () => {
						temporaryDocuments = temporaryDocuments.filter(
							(document) => document.id != file.id
						);
						URL.revokeObjectURL(item.href);
						actualizationDocumentWrapper
							.querySelector(
								`#actualization-document-items-${file.id}`
							)
							.remove();
					});

					item.append(button);
					actualizationDocumentWrapper.append(item);
					temporaryDocuments.push(file);
				}

				actualizationDocumentWrapper.classList.remove('d-none');
			} else {
				if (
					!actualizationDocumentWrapper.classList.contains('d-none')
				) {
					actualizationDocumentWrapper.classList.add('d-none');
				}
			}

			e.target.value = null;
		});

		continue;
	}
	actualizationInputs[input.name] = input;
}
actualizationInputs['actualization_kri_threshold_score'] = actualizationForm.querySelector('[name="actualization_kri_threshold_score"]')

const onActualizationSave = (data) => {
	const swalAlert = () => Swal.fire({
		icon: 'warning',
		text: `Pastikan isian Realisasi Pelaksanaan Perlakuan Risiko dan Biaya telah diisi`,
	});
	if (['discontinue', 'revisi'].includes(data.actualization_plan_status) && actualizationQuills['actualization_plan_explanation']?.getLength() <= 1) {
		swalAlert();
		return;
	}

	for (let key of Object.keys(data)) {
		if (
			[
				'actualization_pic_related',
				'actualization_plan_explanation',
				'actualization_cost_absorption',
				'actualization_kri_threshold_color',
				'actualization_cost_absorption', 'actualization_mitigation_cost',
				'key',
			].includes(key)
		) {
			continue;
		}

		if (
			!data[key] ||
			data[key] == 'Pilih' ||
			actualizationQuills[key]?.getLength() <= 1 ||
			data[key]?.length < 1
		) {
			swalAlert();
			return;
		}
	}

	const row = actualizationFormTableBody.querySelector(
		`#actualization-items-${data.key}`
	);
	const editButton = document.createElement('button');
	editButton.type = 'button';
	editButton.classList.add('btn', 'btn-sm', 'btn-info-light');
	editButton.innerHTML = `<span><i class="ti ti-edit"></i></span>`;

	const picRelated = fetchers.pics.find(
		(pic) =>
			pic.unit_code == data.actualization_pic_related ||
			pic.unit_code == data.actualization_pic_related
	);
	let picRelatedLabel = '';
	if (picRelated) {
		picRelatedLabel = `[${picRelated.personnel_area_code}] ${picRelated.position_name}`;
	}

	data.actualization_kri_threshold_color = kriThresholds.find(
		kri => kri.value == data.actualization_kri_threshold
	)?.customProperties.color

	row.innerHTML = `
        <td class="text-center">${data.risk_cause_number}</td>
        <td class="text-left">${data.risk_cause_body}</td>
        <td class="text-left">${data.actualization_mitigation_plan}</td>
        <td class="text-left">
		${data.actualization_mitigation_cost ? formatNumeral(
		data.actualization_mitigation_cost.replace('.', ','),
		defaultConfigFormatNumeral
	) : ''}
		</td>
        <td class="text-left">${data.actualization_plan_body}</td>
        <td class="text-left">${data.actualization_plan_output}</td>
        <td class="text-center">${data.actualization_cost
			? formatNumeral(
				data.actualization_cost.replace('.', ','),
				defaultConfigFormatNumeral
			)
			: ''
		}</td>
        <td class="text-center">${data.actualization_cost_absorption + '%'}</td>
        <td class="text-center">${data.actualization_pic}</td>
        <td class="text-center">${picRelatedLabel}</td>
        <td class="text-center">${data.actualization_kri}</td>
        <td class="text-center">${data.actualization_kri_threshold ? renderBadge(data.actualization_kri_threshold, data.actualization_kri_threshold_color) : ''}</td>
        <td class="text-center">${data.actualization_kri_threshold_score
			? data.actualization_kri_threshold_score
			: ''
		}</td>
        <td class="text-center">${data.actualization_plan_status}</td>
        <td class="text-center">${data.actualization_plan_explanation}</td>
        <td class="text-center">${data.actualization_plan_progress ? data.actualization_plan_progress + '%' : ''}</td>
    `;

	let documentCell = '<td><div class="d-flex flex-column gap-2">'
	data.actualization_documents.forEach(document => {
		documentCell += `
			<a style="max-width: 164px;" class="badge bg-success-transparent text-truncate"
				target="_blank"
				href="${document.url}">${document.name}</a>
		`
	})
	documentCell += '</div></td>'
	row.innerHTML += documentCell

	row.prepend(editButton);
	editButton.addEventListener('click', (e) => {
		actualizationEdit(data.key, data);
	});
	actualizationModal.hide();
	Swal.fire({
		icon: 'success',
		title: 'Berhasil',
		text: 'Realisasi Pelaksanaan Perlakuan Risiko dan Biaya berhasil disimpan',
	});
};

monitoring.actualizations.forEach((actualization, index) => {
	const row = document.createElement('tr');
	row.id = `actualization-items-${index}`;

	const editButton = document.createElement('button');
	editButton.type = 'button';
	editButton.classList.add('btn', 'btn-sm', 'btn-info-light');
	editButton.innerHTML = `<span><i class="ti ti-edit"></i></span>`;

	row.innerHTML = `
        <td class="text-center">${actualization.risk_cause_number}</td>
        <td class="text-left">${actualization.risk_cause_body}</td>
        <td class="text-left">${actualization.actualization_mitigation_plan
		}</td>
        <td class="text-left">${actualization.actualization_mitigation_cost ? formatNumeral(
			actualization.actualization_mitigation_cost.replaceAll('.', ','),
			defaultConfigFormatNumeral
		) : ''}
		</td>
        <td class="text-left">${actualization.actualization_plan_body}</td>
        <td class="text-left">${actualization.actualization_plan_output}</td>
        <td class="text-center">${actualization.actualization_cost
			? formatNumeral(
				actualization.actualization_cost.replaceAll('.', ','),
				defaultConfigFormatNumeral
			)
			: ''
		}</td>
        <td class="text-center">${actualization.actualization_cost_absorption + '%'}</td>
        <td class="text-center">${actualization.actualization_pic}</td>
        <td class="text-center">${actualization.actualization_pic_related}</td>
        <td class="text-center">${actualization.actualization_kri}</td>
        <td class="text-center">${actualization.actualization_kri_threshold ? renderBadge(actualization.actualization_kri_threshold, actualization.actualization_kri_threshold_color) : ''}</td>
        <td class="text-center">${actualization.actualization_kri_threshold_score
			? actualization.actualization_kri_threshold_score
			: ''
		}</td>
        <td class="text-center">${actualization.actualization_plan_status}</td>
        <td class="text-center">${actualization.actualization_plan_explanation}</td>
        <td class="text-center">${actualization.actualization_plan_progress ? actualization.actualization_plan_progress + '%' : ''}</td>
    `;

	let documentCell = '<td><div class="d-flex flex-column gap-2">'
	actualization.actualization_documents.forEach(document => {
		documentCell += `
			<a style="max-width: 164px;" class="badge bg-success-transparent text-truncate"
				target="_blank"
				href="/file/${document.url}">${document.name}</a>
		`
	})
	documentCell += '</div></td>'
	row.innerHTML += documentCell

	row.prepend(editButton);
	editButton.addEventListener('click', (e) => {
		actualizationEdit(index, actualization);
	});

	actualizationFormTableBody.appendChild(row);
});

const actualizationEdit = (index, data) => {
	for (let key of Object.keys(data)) {
		if (key == 'actualization_cost_absorption') continue;
		if (key == 'actualization_pic_related') {
			const pic = fetchers.pics.find(
				(pic) =>
					pic.unit_code == data[key] || pic.unit_code == data[key]
			);
			if (pic) {
				actualizationPICRelatedChoice.setChoiceByValue(pic.unit_code);
			}
			continue;
		} else if (key == 'actualization_plan_status') {
			actualizationPlanStatusSelectChoice.setChoiceByValue(data[key]);
			actualizationQuills['actualization_plan_explanation'].enable(['discontinue', 'revisi'].includes(data[key]))
			continue;
		}

		const input = actualizationInputs[key];
		if (input) {
			if (['actualization_cost', 'actualization_mitigation_cost'].includes(key)) {
				input.value = formatNumeral(
					data[key].replaceAll('.', ','),
					defaultConfigFormatNumeral
				);

				if (key == 'actualization_cost') {
					input.dispatchEvent(new Event('input'));
				}
			} else {
				input.value = data[key];
			}
		} else {
			const textarea = actualizationTextareas[key];
			if (textarea) {
				textarea.innerHTML = data[key];
				actualizationQuills[key].root.innerHTML = data[key];
				actualizationQuills[key].emitter.emit('text-change');
			}
		}
	}

	if (data?.actualization_documents?.length > 0) {
		for (const file of data.actualization_documents) {
			const item = document.createElement('a');
			item.id = `actualization-document-items-${file.id}`;
			item.classList.add(
				'col-12',
				'd-flex',
				'align-items-center',
				'justify-content-between',
				'badge',
				'bg-outline-dark',
				'p-2'
			);
			item.innerHTML = `<div style="max-width: '70%';" class="text-truncate">(${convertFileSize(
				file.size
			)}) ${file.name}</div>`;
			item.href = file instanceof File ? file.url : `/file/${file.url}`;
			item.target = '_blank';

			const button = document.createElement('button');
			button.type = 'button';
			button.classList.add('btn', 'btn-sm', 'btn-danger-light');
			button.innerHTML = `<span><i class="ti ti-x"></i></span>`;
			button.addEventListener('click', (e) => {
				e.preventDefault();
				temporaryDocuments = temporaryDocuments.filter(
					(document) => document.id != file.id
				);
				URL.revokeObjectURL(item.href);
				actualizationDocumentWrapper
					.querySelector(`#actualization-document-items-${file.id}`)
					.remove();
			});

			item.append(button);
			actualizationDocumentWrapper.append(item);
			temporaryDocuments.push(file);
		}

		actualizationDocumentWrapper.classList.remove('d-none');
		temporaryDocuments = data.actualization_documents;
	}

	actualizationModal.show();

	actualizationKRIThresholdSelectChoice
		.clearChoices()
		.setChoices(kriThresholds.filter(
			(threshold) => threshold.customProperties.id == data.risk_cause_number
		))
		.setChoiceByValue(data.actualization_kri_threshold);
};

actualizationForm.addEventListener('submit', (e) => {
	e.preventDefault();
	const data = Object.fromEntries(new FormData(e.target));
	data.actualization_cost = unformatNumeral(
		data.actualization_cost,
		defaultConfigFormatNumeral
	);
	data.actualization_mitigation_cost = unformatNumeral(
		data.actualization_mitigation_cost,
		defaultConfigFormatNumeral
	);

	data.actualization_plan_explanation = ['discontinue', 'revisi'].includes(data.actualization_plan_status) ? data.actualization_plan_explanation : '';
	data.actualization_cost_absorption = calculateCostAbsorptionPercentage(data.actualization_cost, data.actualization_mitigation_cost);

	const current = monitoring.actualizations[data.key];
	current.actualization_documents = temporaryDocuments;

	for (const key of Object.keys(current)) {
		if (key == 'key' || key == 'id') continue;
		current[key] = data[key] ?? current[key];
	}

	monitoring.actualizations[data.key] = current;
	onActualizationSave(current);
});

actualizationModalElement.addEventListener('hidden.bs.modal', (e) => {
	actualizationForm.reset();
	actualizationDocumentWrapper.innerHTML = '';

	actualizationPlanStatusSelectChoice.destroy();
	actualizationPlanStatusSelectChoice.init();
	actualizationQuills['actualization_plan_explanation'].enable(false);

	actualizationPICRelatedChoice.clearChoices();
	actualizationPICRelatedChoice.setChoices(
		fetchers.pics.reduce(
			(pics, pic) => {
				pics.push({
					value: pic.unit_code,
					label: `[${pic.personnel_area_code}] ${pic.position_name}`,
					customProperties: pic,
				});
				return pics;
			},
			[{ value: 'Pilih', label: 'Pilih' }]
		)
	);
	actualizationPICRelatedChoice.setChoiceByValue('Pilih');

	actualizationKRIThresholdSelectChoice.destroy();
	actualizationKRIThresholdSelectChoice.init();
	actualizationKRIThresholdSelectChoice.clearChoices().setChoices(kriThresholds)
	actualizationKRIThresholdSelectChoice.setChoiceByValue('');

	temporaryDocuments = [];
});

actualizationForm.addEventListener('reset', (e) => {
	e.preventDefault();
	actualizationModal.hide();
});

const monitoringEnableQuarter = (quarter) => {
	if (!quarter) return;
	if (residualRiskImpactCategory.value.toLowerCase() == 'kualitatif') {
		enableQuarterQualitative(quarter);
	} else if (
		residualRiskImpactCategory.value.toLowerCase() == 'kuantitatif'
	) {
		enableQuarterQuantitative(quarter);
	}
};

const enableQuarterQualitative = (quarter) => {
	for (let q = 1; q <= 4; q++) {
		if (q == quarter) {
			residualImpactScale[
				`residual[${q}][impact_scale]`
			].disabled = false;
			residualImpactScaleSelects[`residual[${q}][impact_scale]`].enable();
			residualImpactScale[
				`residual[${q}][impact_scale]`
			].classList.remove('not-allowed');
			residualImpactProbability[
				`residual[${q}][impact_probability]`
			].disabled = false;
			residualImpactProbability[
				`residual[${q}][impact_probability]`
			].classList.remove('not-allowed');

			monitoring.actualizations.map((actualization) => ({ ...actualization, quarter: q }));
		} else {
			residualImpactScale[`residual[${q}][impact_scale]`].disabled = true;
			residualImpactScale[`residual[${q}][impact_scale]`].value = '';
			residualImpactScaleSelects[`residual[${q}][impact_scale]`]
				.setChoiceByValue('Pilih')
				.disable();
			if (
				!residualImpactScale[
					`residual[${q}][impact_scale]`
				].classList.contains('not-allowed')
			) {
				residualImpactScale[
					`residual[${q}][impact_scale]`
				].classList.add('not-allowed');
			}
			residualImpactProbability[
				`residual[${q}][impact_probability]`
			].disabled = true;
			residualImpactProbability[
				`residual[${q}][impact_probability]`
			].value = '';
			if (
				!residualImpactProbability[
					`residual[${q}][impact_probability]`
				].classList.contains('not-allowed')
			) {
				residualImpactProbability[
					`residual[${q}][impact_probability]`
				].classList.add('not-allowed');
			}

			residualImpactProbabilityScaleSelects[
				`residual[${q}][impact_probability_scale]`
			].setChoiceByValue('Pilih');
			residualRiskExposure[`residual[${q}][risk_exposure]`].value = '';
			residualRiskScale[`residual[${q}][risk_scale]`].value = '';
			residualRiskLevel[`residual[${q}][risk_level]`].value = '';
		}

		actualizationTableRows.forEach((row) => {
			for (let col of row.querySelectorAll('td')) {
				if (col.dataset?.name == 'quarter') {
					col.innerHTML = q;
				}
			}
		});
	}
};
const enableQuarterQuantitative = (quarter) => {
	for (let q = 1; q <= 4; q++) {
		if (q == quarter) {
			residualImpactValue[
				`residual[${q}][impact_value]`
			].disabled = false;
			residualImpactValue[
				`residual[${q}][impact_value]`
			].classList.remove('not-allowed');
			residualImpactScale[
				`residual[${q}][impact_scale]`
			].disabled = false;
			residualImpactScaleSelects[`residual[${q}][impact_scale]`].enable();
			residualImpactScale[
				`residual[${q}][impact_scale]`
			].classList.remove('not-allowed');
			residualImpactProbability[
				`residual[${q}][impact_probability]`
			].disabled = false;
			residualImpactProbability[
				`residual[${q}][impact_probability]`
			].classList.remove('not-allowed');

			monitoring.actualizations.map((actualization) => ({ ...actualization, quarter: q }));
		} else {
			residualImpactValue[`residual[${q}][impact_value]`].disabled = true;
			residualImpactValue[`residual[${q}][impact_value]`].value = null;
			if (
				!residualImpactValue[
					`residual[${q}][impact_value]`
				].classList.contains('not-allowed')
			) {
				residualImpactValue[
					`residual[${q}][impact_value]`
				].classList.add('not-allowed');
			}
			residualImpactScale[`residual[${q}][impact_scale]`].disabled = true;
			residualImpactScale[`residual[${q}][impact_scale]`].value = null;
			residualImpactScaleSelects[`residual[${q}][impact_scale]`]
				.setChoiceByValue('Pilih')
				.disable();
			if (
				!residualImpactScale[
					`residual[${q}][impact_scale]`
				].classList.contains('not-allowed')
			) {
				residualImpactScale[
					`residual[${q}][impact_scale]`
				].classList.add('not-allowed');
			}
			residualImpactProbability[
				`residual[${q}][impact_probability]`
			].disabled = true;
			residualImpactProbability[
				`residual[${q}][impact_probability]`
			].value = null;
			if (
				!residualImpactProbability[
					`residual[${q}][impact_probability]`
				].classList.contains('not-allowed')
			) {
				residualImpactProbability[
					`residual[${q}][impact_probability]`
				].classList.add('not-allowed');
			}

			residualImpactProbabilityScaleSelects[
				`residual[${q}][impact_probability_scale]`
			].setChoiceByValue('Pilih');
			residualRiskExposure[`residual[${q}][risk_exposure]`].value = null;
			residualRiskScale[`residual[${q}][risk_scale]`].value = null;
			residualRiskLevel[`residual[${q}][risk_level]`].value = null;
		}

		actualizationTableRows.forEach((row) => {
			for (let col of row.querySelectorAll('td')) {
				if (col.dataset?.name == 'quarter') {
					col.innerHTML = q;
				}
			}
		});
	}
};

const save = async () => {
	const data = { ...monitoring };
	data.residual.risk_exposure = unformatNumeral(
		data.residual.risk_exposure,
		defaultConfigFormatNumeral
	);
	data.actualizations = data.actualizations.map((actualization) => {
		const picRelated = fetchers.pics.find(
			(pic) => pic.unit_code == actualization.actualization_pic_related
		);
		if (picRelated) {
			actualization = { ...actualization, ...picRelated };
		}

		return actualization;
	});

	const formData = jsonToFormData(data);

	Swal.fire({
		text: 'Dalam proses menyimpan..',
		showCancelButton: false,
		showConfirmButton: false,
		allowOutsideClick: false,
		allowEscapeKey: false,
		didOpen: () => {
			Swal.showLoading()

			setTimeout(() => {
				axios
					.post(window.location.href, formData)
					.then((response) => {
						if (response.status == 200) {
							Swal.fire({
								icon: 'success',
								title: 'Berhasil',
								text: response.data?.message,
								showCancelButton: false,
								showConfirmButton: false,
								allowOutsideClick: false,
								allowEscapeKey: false,
								didOpen: () => {
									setTimeout(() => {
										if (response.data?.data?.redirect) {
											window.location.replace(response.data.data.redirect);
										} else {
											window.location.reload();
										}
									}, 625);
								}
							})

							return
						}
					})
					.catch((error) => {
						Swal.fire({
							icon: 'error',
							title: 'Gagal',
							text: error.response?.data?.message ?? error?.message,
						});
					});
			}, 375);
		}
	})
};

monitoringPeriodPicker.setDate(monitoringPeriodDate.value, true)