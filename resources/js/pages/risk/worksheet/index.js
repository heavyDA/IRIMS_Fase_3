import { Modal, Tab } from "bootstrap";
import { formatNumeral, unformatNumeral } from "cleave-zen";
import Choices from "choices.js";
import Quill from "quill";
import "quill/dist/quill.snow.css";
import "~css/quill.css";
import flatpickr from "flatpickr";
import debounce from "~js/utils/debounce";
import axios from "axios";
import dayjs from "dayjs";
import "dayjs/locale/id";
import {
    defaultConfigChoices,
    defaultConfigFormatNumeral,
    defaultConfigQuill,
    defaultLocaleFlatpickr,
    formatDataToStructuredObject,
    generateRandomKey,
} from "~js/components/helper";
import Swal from "sweetalert2";

dayjs.locale("id");

let currentStep = 0;
const totalStep = 4;

const worksheetTab = document.querySelector("#worksheetTab");
const worksheetTabList = worksheetTab.querySelectorAll("li");
const worksheetTabNavs = worksheetTab.querySelectorAll("a");

worksheetTabNavs.forEach((trigger, index) => {
    trigger.addEventListener("click", (e) => {
        if (index !== currentStep) {
            e.preventDefault(); // Prevent Bootstrap's default behavior
            e.stopPropagation(); // Stop event bubbling
        }
    });
});
const navigateToTab = (index) => {
    const nextTab = worksheetTabNavs[index];

    if (nextTab) {
        // Activate the target tab
        const tabInstance = new Tab(nextTab);
        tabInstance.show();
        currentStep = index;
    }
};

const worksheetTabNextButton = document.querySelector(
    "#worksheetTabNextButton"
);
const worksheetTabPreviousButton = document.querySelector(
    "#worksheetTabPreviousButton"
);
const worksheetTabSubmitButton = document.querySelector(
    "#worksheetTabSubmitButton"
);

const identificationValidate = () => {
    const identificationData = new FormData(identificationForm);
    for (let item of identificationForm.querySelectorAll(
        "input:disabled, textarea, select, select:disabled"
    )) {
        if (item.tagName == "TEXTAREA") {
            identificationData.append(item.name, item.innerHTML);
        } else {
            if (
                item.name.includes("impact_value") ||
                item.name.includes("risk_exposure")
            ) {
                identificationData.append(
                    item.name,
                    unformatNumeral(item.value, defaultConfigFormatNumeral)
                );
            } else {
                identificationData.append(item.name, item.value);
            }
        }
    }
    worksheet.identification = formatDataToStructuredObject(identificationData);
    worksheet.identification.inherent_impact_value =
        identificationInherentImpactValue.value
            ? unformatNumeral(
                identificationInherentImpactValue.value,
                defaultConfigFormatNumeral
            )
            : "";

    const isQualitative =
        worksheet.identification.risk_impact_category == "kualitatif";
    for (let key of Object.keys(worksheet.identification)) {
        if (key == "inherent_impact_value" && isQualitative) {
            continue;
        }

        if (key == "search_terms") {
            delete worksheet.identification.search_terms;
            continue;
        }

        if (key == "residual") {
            if (worksheet.identification[key].length) {
                for (const residual of worksheet.identification[key]) {
                    if (residual) {
                        for (const itemKey of Object.keys(residual)) {
                            if (
                                (itemKey == "impact_value" && isQualitative) ||
                                itemKey == "id"
                            ) {
                                continue;
                            }

                            if (
                                !residual[itemKey] ||
                                residual[itemKey] == "Pilih"
                            ) {
                                return false;
                            }
                        }
                    }
                }
            }
        }

        if (
            !worksheet.identification[key] ||
            worksheet.identification[key] == "Pilih" ||
            identificationQuills[key]?.getLength() <= 1
        ) {
            return false;
        }
    }

    return true;
};

const contextValidate = () => {
    const contextData = new FormData(contextForm);
    for (let item of contextForm.querySelectorAll("input:disabled, textarea")) {
        if (item.tagName == "TEXTAREA") {
            contextData.append(item.name, item.innerHTML);
        } else {
            contextData.append(item.name, item.value);
        }
    }

    worksheet.context = Object.fromEntries(contextData);

    for (let key of Object.keys(worksheet.context)) {
        if (
            !worksheet.context[key] ||
            worksheet.context[key] == "Pilih" ||
            targetBodyQuill?.getLength() <= 1
        ) {
            return false;
        }
    }

    return true;
};

worksheetTabNextButton.addEventListener("click", (e) => {
    currentStep += 1;

    if (
        currentStep == 1 &&
        (!contextValidate() || worksheet.strategies.length <= 0)
    ) {
        Swal.fire({
            icon: "warning",
            text: "Pastikan pilihan sasaran dan strategi bisnis telah terisi",
        });
        currentStep -= 1;
        return;
    } else if (
        currentStep == 2 &&
        (!identificationValidate() || worksheet.incidents.length <= 0)
    ) {
        Swal.fire({
            icon: "warning",
            text: "Pastikan identifikasi risiko dan peristiwa risiko telah terisi",
        });
        currentStep -= 1;
        return;
    } else if (currentStep == 3 && worksheet.mitigations.length <= 0) {
        Swal.fire({
            icon: "warning",
            text: "Pastikan rencana mitigasi telah terisi",
        });
        currentStep -= 1;
        return;
    }

    const previousTab = worksheetTabList[currentStep - 1].querySelector("h2");
    const currentTab = worksheetTabList[currentStep].querySelector("h2");

    previousTab.classList.remove("bg-success", "text-white");
    previousTab.classList.add("bg-light", "text-dark");
    currentTab.classList.remove("bg-light", "text-dark");
    currentTab.classList.add("bg-success", "text-white");

    if (
        currentStep > 0 &&
        worksheetTabPreviousButton.classList.contains("d-none")
    ) {
        worksheetTabPreviousButton.classList.remove("d-none");
    }

    if (
        currentStep == totalStep - 1 &&
        worksheetTabSubmitButton.classList.contains("d-none")
    ) {
        worksheetTabSubmitButton.classList.remove("d-none");
        worksheetTabNextButton.classList.add("d-none");
    }
    navigateToTab(currentStep);
});

worksheetTabPreviousButton.addEventListener("click", (e) => {
    currentStep -= 1;
    const previousTab = worksheetTabList[currentStep + 1].querySelector("h2");
    const currentTab = worksheetTabList[currentStep].querySelector("h2");

    previousTab.classList.remove("bg-success", "text-white");
    previousTab.classList.add("bg-light", "text-dark");
    currentTab.classList.remove("bg-light", "text-dark");
    currentTab.classList.add("bg-success", "text-white");

    if (
        currentStep == 0 &&
        !worksheetTabPreviousButton.classList.contains("d-none")
    ) {
        worksheetTabPreviousButton.classList.add("d-none");
    }

    if (currentStep < totalStep - 1) {
        if (!worksheetTabSubmitButton.classList.contains("d-none")) {
            worksheetTabSubmitButton.classList.add("d-none");
        }

        worksheetTabNextButton.classList.remove("d-none");
    }
    navigateToTab(currentStep);
});

/** End of stepper */

const worksheet = {
    context: {
        unit_name: "",
        risk_number: "",
        period_date: "",
        period_year: 0,
        target_body: "",
    },
    strategies: [],
    identification: {
        company_name: null,
        company_code: null,
        target_body: null,
        risk_category_t3: null,
        risk_category_t2: null,
        existing_control_type: null,
        existing_control_body: null,
        control_effectiveness_assessment: null,
        risk_impact_category: null,
        risk_impact_body: null,
        risk_impact_start_date: null,
        risk_impact_end_date: null,
        inherent_body: null,
        inherent_impact_value: null,
        inherent_impact_scale: null,
        inherent_impact_probability: null,
        inherent_impact_probability_scale: null,
        inherent_risk_exposure: null,
        inherent_risk_scale: null,
        inherent_risk_level: null,
        "residual[0][impact_value]": null,
        "residual[0][impact_scale]": null,
        "residual[0][impact_probability]": null,
        "residual[0][impact_probability_scale]": null,
        "residual[0][risk_exposure]": null,
        "residual[0][risk_scale]": null,
        "residual[0][risk_level]": null,
        "residual[1][impact_value]": null,
        "residual[1][impact_scale]": null,
        "residual[1][impact_probability]": null,
        "residual[1][impact_probability_scale]": null,
        "residual[1][risk_exposure]": null,
        "residual[1][risk_scale]": null,
        "residual[1][risk_level]": null,
        "residual[2][impact_value]": null,
        "residual[2][impact_scale]": null,
        "residual[2][impact_probability]": null,
        "residual[2][impact_probability_scale]": null,
        "residual[2][risk_exposure]": null,
        "residual[2][risk_scale]": null,
        "residual[2][risk_level]": null,
        "residual[3][impact_value]": null,
        "residual[3][impact_scale]": null,
        "residual[3][impact_probability]": null,
        "residual[3][impact_probability_scale]": null,
        "residual[3][risk_exposure]": null,
        "residual[3][risk_scale]": null,
        "residual[3][risk_level]": null,
    },
    incidents: [],
    mitigations: [],
};

const risk_numbers = ["a", "b", "c", "d", "e"];

const fetchers = {
    bumn_scales: [],
    heat_maps: [],
    unit_head: {
        name: "",
        position_name: "",
        personnel_area_code: "",
        personnel_area_name: "",
        organization_code: "",
        organization_name: "",
        unit_code: "",
        unit_name: "",
        sub_unit_code: "",
        sub_unit_name: "",
    },
    risk_metric: {},
    risk_categories: [],
};

const fetchData = async () => {
    await Promise.allSettled([
        axios.get("/master/data/bumn-scales"),
        axios.get("/master/data/heatmaps"),
        axios.get("/profile/unit_head"),
        axios.get("/profile/risk_metric"),
        axios.get("/master/data/risk-categories"),
    ]).then((res) => {
        for (let [index, key] of Object.keys(fetchers).entries()) {
            if (res[index].status == "fulfilled") {
                const response = res[index].value;
                if (response.status == 200) {
                    fetchers[key] = response.data.data;
                }
            }
        }
    });
};

await fetchData();

const tables = {
    strategies: document.querySelector("#worksheetStrategyTable"),
    incidents: document.querySelector("#worksheetIncidentTable"),
    mitigations: document.querySelector("#worksheetTreatmentTable"),
};

const contextForm = document.querySelector("#contextForm");
const currentRiskNumber = contextForm.querySelector('[name="risk_number"]');
currentRiskNumber.addEventListener("input", (e) => {
    incidentRiskCauseCode.value =
        e.target.value + "." + incidentRiskCauseNumber.value;
    treatmentRiskNumber.value = e.target.value;
});

const targetUnitName = contextForm.querySelector('[name="unit_name"]');
const targetPeriodYear = contextForm.querySelector('[name="period_year"]');
const targetPeriodDate = contextForm.querySelector('[name="period_date"]');
const targetBody = contextForm.querySelector('[name="target_body"]');
const targetBodyQuill = new Quill(
    contextForm.querySelector("#target_body-editor"),
    defaultConfigQuill
);
targetBodyQuill.on("text-change", (delta, oldDelta, source) => {
    targetBody.innerHTML = targetBodyQuill.root.innerHTML;

    identificationTargetBodyQuill.root.innerHTML =
        targetBodyQuill.root.innerHTML;
    identificationTargetBody.innerHTML = targetBodyQuill.root.innerHTML;

    worksheet.context.target_body = targetBodyQuill.root.innerHTML;
});

worksheet.context.unit_name = targetUnitName.value;
worksheet.context.period_year = targetPeriodYear.value;
worksheet.context.period_date = targetPeriodDate.value;

const strategyModalButton = document.querySelector("#strategyModalButton");
const strategyModalElement = document.querySelector("#strategyModal");
const strategyModal = new Modal(strategyModalElement);
const strategyForm = document.querySelector("#strategyForm");

strategyModalButton.addEventListener("click", () => {
    if (worksheet.context.target_body == "") {
        Swal.fire({
            icon: "warning",
            title: "",
            text: "Pastikan pilihan sasaran telah terisi.",
        });
        return;
    }

    strategyModal.show();
});

const strategyTextareas = {};
for (let t of strategyForm.querySelectorAll("textarea")) {
    strategyTextareas[t.name] = t;
}
const strategyQuills = {};
for (let editor of strategyForm.querySelectorAll(".textarea")) {
    strategyQuills[editor.id.replaceAll("-editor", "")] = new Quill(
        editor,
        defaultConfigQuill
    );
    strategyQuills[editor.id.replaceAll("-editor", "")].on(
        "text-change",
        (delta, oldDelta, source) => {
            strategyTextareas[editor.id.replaceAll("-editor", "")].innerHTML =
                strategyQuills[
                    editor.id.replaceAll("-editor", "")
                ].root.innerHTML;
        }
    );
}

const strategyRiskValueLimit = strategyForm.querySelector(
    '[name="strategy_risk_value_limit"]'
);
strategyRiskValueLimit.value = fetchers?.risk_metric?.limit
    ? formatNumeral(fetchers?.risk_metric?.limit.replace('.', ','), defaultConfigFormatNumeral)
    : "";
const strategyDecision = strategyForm.querySelector(
    '[name="strategy_decision"]'
);
const strategyDecisionChoices = new Choices(
    strategyDecision,
    defaultConfigChoices
);

// type = strategies | identifications | mitigations
const addRowAction = (type, key, updateCallback, deleteCallback) => {
    const removeButton = document.createElement("button");
    const editButton = document.createElement("button");

    removeButton.type = "button";
    removeButton.classList.add("btn", "btn-sm", "btn-danger", "m-1");
    removeButton.innerHTML = `<i class="ti ti-x"></i>`;

    removeButton.addEventListener("click", () => {
        const index = worksheet[type].findIndex((item) => item.key == key);
        const data = worksheet[type][index];

        tables[type].querySelector("tbody").children[index].remove();
        worksheet[type].splice(index, 1);
        if (deleteCallback) {
            deleteCallback(data);
        }
    });

    editButton.type = "button";
    editButton.classList.add("btn", "btn-sm", "btn-primary", "m-1");
    editButton.innerHTML = `<i class="ti ti-edit"></i>`;

    editButton.addEventListener("click", () => {
        const index = worksheet[type].findIndex((item) => item.key == key);
        const data = worksheet[type][index];
        updateCallback(data);
    });

    return [removeButton, editButton];
};

const addStrategyRow = (data) => {
    const body = tables.strategies.querySelector("tbody");
    const row = document.createElement("tr");
    const [removeButton, editButton] = addRowAction(
        "strategies",
        data.key,
        (data) => onStrategyEdit(data)
    );
    const buttonCell = document.createElement("td");

    row.id = `strategy-${data.key}`;
    row.innerHTML = `
        <td>${data.strategy_body}</td>
        <td>${data.strategy_expected_feedback}</td>
        <td>${data.strategy_risk_value}</td>
        <td>${formatNumeral(
        data.strategy_risk_value_limit.replace('.', ','),
        defaultConfigFormatNumeral
    )}</td>
        <td>${data.strategy_decision}</td>
    `;
    buttonCell.appendChild(editButton);
    buttonCell.appendChild(removeButton);
    row.prepend(buttonCell);
    body.appendChild(row);
};

const updateStrategyRow = (data) => {
    const row = tables.strategies.querySelector(`#strategy-${data.key}`);
    row.querySelector("td:nth-child(2)").innerHTML = data.strategy_body;
    row.querySelector("td:nth-child(3)").innerHTML =
        data.strategy_expected_feedback;
    row.querySelector("td:nth-child(4)").innerHTML = data.strategy_risk_value;
    row.querySelector("td:nth-child(5)").innerHTML = formatNumeral(
        data.strategy_risk_value_limit.replace('.', ','),
        defaultConfigFormatNumeral
    );
    row.querySelector("td:nth-child(6)").innerHTML = data.strategy_decision;
};

const onStrategySave = (data) => {
    for (let key of Object.keys(data)) {
        if (key == "key" || key == "id" || key == "strategy_risk_value" || key == "strategy_expected_feedback") {
            continue;
        }

        if (
            !data[key] ||
            data[key] == "Pilih" ||
            strategyQuills[key]?.getLength() <= 1
        ) {
            Swal.fire(
                "Peringatan",
                "Pastikan semua isian harus terisi",
                "warning"
            );
            return;
        }
    }

    data.strategy_risk_value_limit = unformatNumeral(
        data.strategy_risk_value_limit.replace('.', ','),
        defaultConfigFormatNumeral
    );

    if (data.key) {
        worksheet.strategies[
            worksheet.strategies.findIndex((item) => item.key == data.key)
        ] = data;
        updateStrategyRow(data);
    } else {
        data.key = generateRandomKey();
        worksheet.strategies.push(data);
        addStrategyRow(data);
    }
    strategyModal.hide();
};

const onStrategyEdit = (data) => {
    strategyForm.querySelector('[name="key"]').value = data.key;
    strategyForm.querySelector('[name="id"]').value = data.id;
    strategyQuills["strategy_body"].root.innerHTML = data.strategy_body;
    strategyQuills["strategy_expected_feedback"].root.innerHTML =
        data.strategy_expected_feedback;
    strategyQuills["strategy_risk_value"].root.innerHTML =
        data.strategy_risk_value;
    strategyRiskValueLimit.value = formatNumeral(
        data.strategy_risk_value_limit.replace('.', ','),
        defaultConfigFormatNumeral
    );
    strategyDecisionChoices.setChoiceByValue(data.strategy_decision);

    strategyModal.show();
};

strategyForm.addEventListener("submit", (e) => {
    e.preventDefault();

    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData);

    data.strategy_risk_value_limit = unformatNumeral(
        strategyRiskValueLimit.value,
        defaultConfigFormatNumeral
    );
    if (data.hasOwnProperty("search_terms")) {
        delete data.search_terms;
    }
    onStrategySave(data);
});

strategyModalElement.addEventListener("hidden.bs.modal", () => {
    strategyForm.reset();
    strategyForm.querySelector('[name="key"]').value = "";

    strategyRiskValueLimit.value = fetchers?.risk_metric?.limit
        ? formatNumeral(
            fetchers?.risk_metric?.limit.replace('.', ','),
            defaultConfigFormatNumeral
        )
        : "";
    strategyDecisionChoices.destroy();
    strategyDecisionChoices.init();

    Object.keys(strategyTextareas).forEach((key) => {
        strategyTextareas[key].innerHTML = "";
        strategyQuills[key].deleteText(0, strategyQuills[key].getLength());
    });
});

const identificationForm = document.querySelector("#identificationForm");
const identificationTabs = document.querySelector("#identificationTabs");
const identificationInherentTab = document.querySelector(
    "#identificationInherentTab"
);
const identificationResidualTab = document.querySelector(
    "#identificationResidualTab"
);

const identificationDateRange = identificationForm.querySelector(
    "#risk_impact_date-picker"
);
const identificationStartDate = identificationForm.querySelector(
    '[name="risk_impact_start_date"]'
);
const identificationEndDate = identificationForm.querySelector(
    '[name="risk_impact_end_date"]'
);

const identificationRiskCategoryT2 = identificationForm.querySelector(
    '[name="risk_category_t2"]'
);
const identificationRiskCategoryT3 = identificationForm.querySelector(
    '[name="risk_category_t3"]'
);
const identificationExistingControlType = identificationForm.querySelector(
    '[name="existing_control_type"]'
);
const identificationControlEffectivenessAssessment =
    identificationForm.querySelector(
        '[name="control_effectiveness_assessment"]'
    );
const identificationRiskImpact = identificationForm.querySelector(
    '[name="risk_impact_category"]'
);

const identificationRiskCategoryT2Choices = new Choices(
    identificationRiskCategoryT2,
    defaultConfigChoices
);
const identificationRiskCategoryT3Choices = new Choices(
    identificationRiskCategoryT3,
    defaultConfigChoices
);
identificationRiskCategoryT2Choices.setChoices(
    fetchers.risk_categories
        .filter((item) => item.type == "T2")
        .map((item) => ({
            value: item.id,
            label: item.name,
            customProperties: item,
        }))
);
identificationRiskCategoryT2.addEventListener("change", (e) => {
    const current = identificationRiskCategoryT2Choices.getValue();

    if (current?.value?.toString()?.toLowerCase() != "pilih") {
        identificationRiskCategoryT3Choices
            .setChoiceByValue("Pilih")
            .clearChoices()
            .setChoices([
                { value: "Pilih", label: "Pilih" },
                ...fetchers.risk_categories
                    .filter(
                        (item) => item.parent_id == current.customProperties.id
                    )
                    .map((item) => ({
                        value: item.id,
                        label: item.name,
                        customProperties: item,
                    })),
            ])
            .enable();
    } else {
        identificationRiskCategoryT3Choices
            .setChoiceByValue("Pilih")
            .clearChoices()
            .setChoices([{ value: "Pilih", label: "Pilih" }])
            .disable();
    }
});
identificationRiskCategoryT3Choices.disable();

const identificationExistingControlTypeChoices = new Choices(
    identificationExistingControlType,
    defaultConfigChoices
);
const identificationControlEffectivenessAssessmentChoices = new Choices(
    identificationControlEffectivenessAssessment,
    defaultConfigChoices
);
const identificationRiskImpactChoices = new Choices(
    identificationRiskImpact,
    defaultConfigChoices
);

const identificationSelects = {};
for (let t of identificationTabs.querySelectorAll(".form-select")) {
    identificationSelects[t.name] = t;
}

const identificationChoices = {};
const identificationChoicesInit = async () => {
    for (let t of identificationTabs.querySelectorAll(".form-select")) {
        identificationSelects[t.name] = t;
    }

    Object.keys(identificationSelects).forEach((key) => {
        const choices = [
            {
                value: "Pilih",
                label: "Pilih",
            },
        ];
        const hasCustomData =
            identificationSelects[key].hasAttribute("data-custom");

        if (hasCustomData) {
            if (
                key.includes("[impact_scale]") ||
                key == "inherent_impact_scale"
            ) {
                for (let item of fetchers.bumn_scales) {
                    choices.push({
                        value: item.id,
                        label: item.scale,
                        customProperties: item,
                    });
                }
            } else if (
                key.includes("[impact_probability_scale]") ||
                key == "inherent_impact_probability_scale"
            ) {
                for (let item of fetchers.heat_maps) {
                    choices.push({
                        value: item.id,
                        label: item.impact_probability,
                        customProperties: item,
                    });
                }
            } else if (key.includes("risk_cause_number")) {
                for (let item of risk_numbers) {
                    choices.push({
                        value: item,
                        label: item,
                    });
                }
            }
        }
        identificationChoices[key] = new Choices(identificationSelects[key], {
            ...defaultConfigChoices,
            choices: choices,
        });
    });

    identificationSelects?.risk_cause_number?.addEventListener(
        "change",
        (e) =>
        (identificationRiskCauseCode.value =
            identificationRiskNumber.value +
            "." +
            identificationChoices.risk_cause_number.getValue(true))
    );
    identificationSelects?.inherent_impact_scale?.addEventListener(
        "change",
        (e) => {
            calculateRisk(...identificationInherentItems);
        }
    );

    identificationRiskImpact.addEventListener("change", (e) => {
        const risk_impact_category =
            identificationRiskImpactChoices.getValue(true);
        if (risk_impact_category !== "Pilih") {
            identificationChoices.inherent_impact_scale.enable();
            if (risk_impact_category == "kualitatif") {
                identificationInherentImpactValue.value = "";
                identificationInherentImpactValue.disabled = true;
            } else {
                identificationInherentImpactValue.disabled = false;
            }

            let choices = [];
            for (let item of fetchers.bumn_scales) {
                if (item.impact_category !== risk_impact_category) continue;
                choices.push({
                    id: item.id,
                    value: item.id,
                    label: item.scale,
                    customProperties: item,
                });
            }

            for (let i = 1; i < 5; i++) {
                identificationChoices[`residual[${i}][impact_scale]`]
                    .clearChoices()
                    .setChoices(choices)
                    .enable();
            }
            identificationChoices.inherent_impact_scale
                .clearChoices()
                .setChoices(choices);

            for (let info of document.querySelectorAll(".info-category-risk")) {
                if (info.id.includes(risk_impact_category)) {
                    info.classList.replace("d-none", "d-block");
                } else {
                    info.classList.replace("d-block", "d-none");
                }
            }

            for (let label of incidentForm.querySelectorAll(
                ".label-category-risk"
            )) {
                if (label.dataset[risk_impact_category]) {
                    label.innerHTML = label.dataset[risk_impact_category];
                } else {
                    label.innerHTML = risk_impact_category;
                }
            }
        } else {
            for (let label of incidentForm.querySelectorAll(
                ".label-category-risk"
            )) {
                if (label.hasAttribute("data-kuantitatif")) {
                    label.innerHTML = "Dampak";
                } else {
                    label.innerHTML = "";
                }
            }

            for (let info of document.querySelectorAll(".info-category-risk")) {
                info.classList.replace("d-block", "d-none");
            }

            identificationChoices.inherent_impact_scale
                .setChoiceByValue("Pilih")
                .disable();

            for (let i = 1; i < 5; i++) {
                identificationChoices[`residual[${i}][impact_scale]`]
                    .setChoiceByValue("Pilih")
                    .disable();
            }

            identificationChoices.inherent_impact_probability_scale.setChoiceByValue(
                "Pilih"
            );
        }

        calculateRisk(...identificationInherentItems);
        residualItems.forEach((item) => calculateRisk(...item));
    });
};

await identificationChoicesInit();

identificationRiskImpact.addEventListener("change", (e) => {
    const risk_impact_category = identificationRiskImpactChoices.getValue(true);
    if (risk_impact_category !== "Pilih") {
        identificationChoices.inherent_impact_scale.enable();

        let choices = [];
        for (let item of fetchers.bumn_scales) {
            if (item.impact_category !== risk_impact_category) continue;
            choices.push({
                id: item.id,
                value: item.id,
                label: item.scale,
                customProperties: item,
            });
        }

        for (let i = 1; i < 5; i++) {
            identificationChoices[`residual[${i}][impact_scale]`]
                .clearChoices()
                .setChoices(choices)
                .enable();
        }
        identificationChoices.inherent_impact_scale
            .clearChoices()
            .setChoices(choices);

        for (let label of identificationForm.querySelectorAll(
            ".label-category-risk"
        )) {
            if (label.dataset[risk_impact_category]) {
                label.innerHTML = label.dataset[risk_impact_category];
            } else {
                label.innerHTML = risk_impact_category;
            }
        }
    } else {
        for (let label of identificationForm.querySelectorAll(
            ".label-category-risk"
        )) {
            if (label.hasAttribute("data-kuantitatif")) {
                label.innerHTML = "Dampak";
            } else {
                label.innerHTML = "";
            }
        }

        identificationChoices.inherent_impact_scale
            .setChoiceByValue("Pilih")
            .disable();

        for (let i = 1; i < 5; i++) {
            identificationChoices[`residual[${i}][impact_scale]`]
                .setChoiceByValue("Pilih")
                .disable();
        }

        identificationChoices.inherent_impact_probability_scale.setChoiceByValue(
            "Pilih"
        );
    }
});

const identificationTargetBody = identificationForm.querySelector(
    '[name="target_body"]'
);
const identificationTargetBodyQuill = new Quill(
    identificationForm.querySelector("#target_body-editor"),
    defaultConfigQuill
);
identificationTargetBodyQuill.enable(false);
identificationTargetBodyQuill.on("text-change", (delta, oldDelta, source) => {
    identificationTargetBody.innerHTML =
        identificationTargetBodyQuill.root.innerHTML;
});

const identificationTextareas = {};
for (let t of identificationForm.querySelectorAll("textarea")) {
    if (t.name == "target_body") {
        continue;
    }

    identificationTextareas[t.name] = t;
}

const identificationQuills = {};
for (let editor of identificationForm.querySelectorAll(".textarea")) {
    const targetId = editor.id.replaceAll("-editor", "");
    if (targetId == "target_body") {
        continue;
    }
    identificationQuills[targetId] = new Quill(editor, defaultConfigQuill);

    identificationQuills[targetId].on(
        "text-change",
        (delta, oldDelta, source) => {
            identificationTextareas[targetId].innerHTML =
                identificationQuills[targetId].root.innerHTML;
        }
    );
}

const identificationDatePicker = flatpickr(identificationDateRange, {
    mode: "range",
    dateFormat: "Y-m-d",
    altInput: true,
    altFormat: "j F Y",
    locale: defaultLocaleFlatpickr,
    onChange: (dates) => {
        identificationStartDate.value =
            dates[0]?.getFullYear() +
            "-" +
            (dates[0]?.getMonth() + 1) +
            "-" +
            dates[0]?.getDate();
        identificationEndDate.value =
            dates[1]?.getFullYear() +
            "-" +
            (dates[1]?.getMonth() + 1) +
            "-" +
            dates[1]?.getDate();
    },
    defaultDate: [identificationStartDate.value, identificationEndDate.value],
});

/**
 * Inherent Calculation
 */
const identificationInherentImpactValue = identificationForm.querySelector(
    '[name="inherent_impact_value"]'
);
const identificationInherentImpactProbability =
    identificationForm.querySelector('[name="inherent_impact_probability"]');
const identificationInherentRiskExposure = identificationForm.querySelector(
    '[name="inherent_risk_exposure"]'
);
const identificationInherentRiskScale = identificationForm.querySelector(
    '[name="inherent_risk_scale"]'
);
const identificationInherentRiskLevel = identificationForm.querySelector(
    '[name="inherent_risk_level"]'
);

const identificationInherentItems = [];
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
    );
};
identificationResidualItemsInit();

const calculateRisk = (
    targetScale,
    targetImpactValue,
    targetImpactProbability,
    targetImpactProbabilityScale,
    targetExposure,
    targetRiskScale,
    targetRiskLevel,
    isResidual = false,
    quarter
) => {
    let scale, probability;

    scale = targetScale.getValue(false);
    probability = targetScale._currentState.choices.find(
        (choice) =>
            scale?.customProperties?.scale &&
            parseInt(targetImpactProbability.value) >=
            choice.customProperties.min &&
            parseInt(targetImpactProbability.value) <=
            choice.customProperties.max
    );

    if (isResidual) {
        if (scale?.customProperties?.scale) {
            if (quarter == 1) {
                targetImpactValue.value =
                    identificationInherentImpactValue.value;
            } else {
                const scaleQ1 =
                    identificationChoices[`residual[1][impact_scale]`].getValue(
                        false
                    );
                if (
                    scaleQ1?.value != "Pilih" &&
                    identificationRiskImpact.value == "kuantitatif"
                ) {
                    const riskValueByLimit = parseFloat(
                        (parseInt(scale.customProperties.scale) /
                            parseInt(scaleQ1.customProperties.scale)) *
                        parseFloat(
                            unformatNumeral(
                                identificationResidualImpactValues[0].value,
                                defaultConfigFormatNumeral
                            )
                        )
                    ).toFixed(2);
                    targetImpactValue.value = formatNumeral(
                        riskValueByLimit.toString().replaceAll(".", ","),
                        defaultConfigFormatNumeral
                    );
                } else {
                    targetImpactValue.value = "";
                    targetExposure.value = "";
                    targetRiskScale.value = "";
                    targetRiskLevel.value = "";
                }
            }
        } else {
            targetImpactValue.value = "";
            targetExposure.value = "";
            targetRiskScale.value = "";
            targetRiskLevel.value = "";
        }
    }

    let impactValue = 0;

    if (identificationRiskImpact.value == "kuantitatif") {
        impactValue = parseFloat(
            unformatNumeral(targetImpactValue.value, defaultConfigFormatNumeral)
        );
    }

    if (scale?.customProperties?.scale && probability) {
        const probabilityValue = parseFloat(targetImpactProbability.value);
        if (
            impactValue >= 0 &&
            probabilityValue &&
            identificationRiskImpact.value == "kuantitatif"
        ) {
            targetExposure.value = formatNumeral(
                (impactValue * (probabilityValue / 100))
                    .toString()
                    .replaceAll(".", ","),
                defaultConfigFormatNumeral
            );
        } else if (
            probabilityValue &&
            identificationRiskImpact.value == "kualitatif"
        ) {
            targetExposure.value = formatNumeral(
                parseFloat(
                    (1 / 100) *
                    parseFloat(fetchers?.risk_metric?.limit ?? "0") *
                    parseInt(scale.customProperties.scale) *
                    (probabilityValue / 100)
                )
                    .toFixed(2)
                    .toString()
                    .replaceAll(".", ","),
                defaultConfigFormatNumeral
            );
        } else {
            targetExposure.value = formatNumeral(
                "0",
                defaultConfigFormatNumeral
            );
        }

        const result = targetImpactProbabilityScale._currentState.choices.find(
            (choice) =>
                choice.customProperties.impact_scale ==
                scale.customProperties.scale &&
                choice.customProperties.impact_probability ==
                probability.customProperties.scale
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
};

const residualItems = [];
const identificationResidualImpactValues = [];
const identificationResidualImpactProbabilities = [];
const identificationResidualRiskExposures = [];
const identificationResidualRiskScales = [];
const identificationResidualRiskLevels = [];

for (let i = 1; i <= 4; i++) {
    identificationResidualImpactValues.push(
        identificationForm.querySelector(
            `[name="residual[${i}][impact_value]"]`
        )
    );
    identificationResidualImpactProbabilities.push(
        identificationForm.querySelector(
            `[name="residual[${i}][impact_probability]"]`
        )
    );
    identificationResidualRiskExposures.push(
        identificationForm.querySelector(
            `[name="residual[${i}][risk_exposure]"]`
        )
    );
    identificationResidualRiskScales.push(
        identificationForm.querySelector(`[name="residual[${i}][risk_scale]"]`)
    );
    identificationResidualRiskLevels.push(
        identificationForm.querySelector(`[name="residual[${i}][risk_level]"]`)
    );
}
/**
 * Initialize AddEventListener to Q1 Items
 */
const residualItemsInit = () => {
    identificationResidualItemsInit();

    for (let i = 1; i < 5; i++) {
        const residualItem = [
            identificationChoices[`residual[${i}][impact_scale]`],
            identificationResidualImpactValues[i - 1],
            identificationResidualImpactProbabilities[i - 1],
            identificationChoices[`residual[${i}][impact_probability_scale]`],
            identificationResidualRiskExposures[i - 1],
            identificationResidualRiskScales[i - 1],
            identificationResidualRiskLevels[i - 1],
            true,
            i,
        ];

        identificationSelects[`residual[${i}][impact_scale]`].addEventListener(
            "change",
            (e) => {
                calculateRisk(...residualItem);
            }
        );
        identificationForm
            .querySelector(`[name="residual[${i}][impact_probability]"`)
            .addEventListener(
                "keyup",
                debounce(() => calculateRisk(...residualItem), 500)
            );

        residualItems.push(residualItem);
    }
};
residualItemsInit();

identificationInherentImpactValue.addEventListener("input", (e) => {
    const value = formatNumeral(e.target.value, defaultConfigFormatNumeral);
    const limit = fetchers.risk_metric.limit;

    e.target.value = value;
    for (let i = 0; i < 4; i++) {
        if (identificationRiskImpact.value == "kuantitatif") {
            identificationResidualImpactValues[i].value = value;
        }
        identificationResidualImpactValues[i].dispatchEvent(new Event("keyup"));
        identificationResidualImpactProbabilities[i].dispatchEvent(
            new Event("keyup")
        );
    }
});

identificationInherentImpactValue.addEventListener(
    "keyup",
    debounce((e) => {
        calculateRisk(...identificationInherentItems);
    }, 500)
);
identificationInherentImpactProbability.addEventListener(
    "keyup",
    debounce(() => {
        calculateRisk(...identificationInherentItems);
    }, 500)
);

const incidentForm = document.querySelector("#incidentForm");
const incidentModalElement = document.querySelector("#incidentModal");
const incidentModal = new Modal(incidentModalElement);

const incidentRiskCauseNumber = incidentForm.querySelector(
    '[name="risk_cause_number"]'
);
const incidentRiskCauseCode = incidentForm.querySelector(
    '[name="risk_cause_code"]'
);
const incidentKRIUnit = incidentForm.querySelector('[name="kri_unit"]');
const incidentKRIUnitChoices = new Choices(
    incidentKRIUnit,
    defaultConfigChoices
);

const incidentTextareas = {};
const incidentQuills = {};
for (let t of incidentForm.querySelectorAll("textarea")) {
    incidentTextareas[t.name] = t;

    incidentQuills[t.name] = new Quill(
        incidentForm.querySelector("#" + t.name + "-editor"),
        defaultConfigQuill
    );
    incidentQuills[t.name].on("text-change", (delta, oldDelta, source) => {
        incidentTextareas[t.name].innerHTML =
            incidentQuills[t.name].root.innerHTML;
    });
}

incidentForm.addEventListener("submit", (e) => {
    e.preventDefault();

    const formData = new FormData(e.target);
    e.target.querySelectorAll("input:disabled").forEach((input) => {
        formData.append(input.name, input.value);
    });

    const data = Object.fromEntries(formData);
    if (data.hasOwnProperty("search_terms")) {
        delete data.search_terms;
    }

    for (let key of Object.keys(data)) {
        if (key == "key" || key == "id") {
            continue;
        }

        if (
            !data[key] ||
            data[key] == "Pilih" ||
            incidentQuills[key]?.getLength() <= 1
        ) {
            Swal.fire(
                "Peringatan",
                "Pastikan semua isian harus terisi",
                "warning"
            );
            return;
        }

        if (key.includes("impact_value") || key.includes("risk_exposure")) {
            data[key] = unformatNumeral(
                data[key],
                defaultConfigFormatNumeral
            ).replaceAll(".", ",");
        }
    }

    onIncidentSave(data);
});

incidentForm.addEventListener("reset", async () => {
    incidentModal.hide();
});

incidentModalElement.addEventListener("show.bs.modal", () => {
    const incidentsLength = worksheet.incidents.length;

    if (incidentsLength >= risk_numbers.length) {
        Swal.fire({
            icon: "warning",
            title: "",
            text: "Tidak dapat menambahkan penyebab risiko karena sudah melebihi batas jumlah penyebab risiko.",
        });

        return e.preventDefault();
    }

    incidentRiskCauseNumber.value = risk_numbers[incidentsLength];
    incidentRiskCauseCode.value =
        currentRiskNumber.value + "." + risk_numbers[incidentsLength];
});

incidentModalElement.addEventListener("hide.bs.modal", async () => {
    const incidentsLength = worksheet.incidents.length;

    incidentKRIUnitChoices.destroy();
    incidentKRIUnitChoices.init();

    incidentForm.reset();
    incidentForm.querySelector('[name="key"]').value = "";
    incidentRiskCauseNumber.value = risk_numbers[incidentsLength];
    incidentRiskCauseCode.value =
        currentRiskNumber.value + "." + risk_numbers[incidentsLength];

    Object.keys(incidentTextareas).forEach((key) => {
        incidentQuills[key].deleteText(0, incidentQuills[key].getLength());
    });
});

const onIncidentSave = (data) => {
    if (data.key) {
        worksheet.incidents[
            worksheet.incidents.findIndex((item) => item.key == data.key)
        ] = data;
        updateIncidentRow(data);
    } else {
        data.key = generateRandomKey();
        worksheet.incidents.push(data);
        addIncidentRow(data);
    }

    const choices = [
        {
            id: "Pilih",
            value: "Pilih",
            label: "Pilih",
        },
    ];
    for (let incident of worksheet.incidents) {
        choices.push({
            id: incident.risk_cause_number,
            value: incident.risk_cause_number,
            label: incident.risk_cause_number,
        });
    }

    treatmentRiskCauseNumber.innerHTML = "<option>Pilih</option>";
    treatmentRiskCauseNumberChoices.destroy();
    treatmentRiskCauseNumberChoices.init();
    treatmentRiskCauseNumberChoices
        .setChoices(choices)
        .setChoiceByValue("Pilih");
    incidentModal.hide();
};

const onIncidentEdit = (data) => {
    incidentModal.show();

    Object.keys(data).forEach((key) => {
        const element = incidentForm.querySelector(`[name="${key}"]`);
        const event = new Event("change");

        if (key.includes("impact_value") || key.includes("risk_exposure")) {
            element.value = formatNumeral(
                data[key],
                defaultConfigFormatNumeral
            );
        } else if (identificationChoices.hasOwnProperty(key)) {
            element.value = data[key];
            identificationChoices[key].setChoiceByValue(data[key]);
        } else if (element.tagName == "TEXTAREA") {
            incidentQuills[key].root.innerHTML = data[key];
            incidentQuills[key].emitter.emit("text-change");
            return;
        } else if (key == "kri_unit") {
            incidentKRIUnitChoices.setChoiceByValue(data[key]);
        } else {
            element.value = data[key];
        }
        element.dispatchEvent(event);
    });
    // Set the flatpickr dates
    if (data.identification_start_date && data.identification_end_date) {
        identificationDatePicker.setDate([
            data.identification_start_date,
            data.identification_end_date,
        ]);
    }
};

const addIncidentRow = (data) => {
    const body = tables.incidents.querySelector("tbody");
    const row = document.createElement("tr");
    const [removeButton, editButton] = addRowAction(
        "incidents",
        data.key,
        (data) => onIncidentEdit(data),
        (data) => {
            worksheet.incidents = worksheet.incidents
                .filter((item) => item.key != data.key)
                .map((item, key) => {
                    item.risk_cause_number = risk_numbers[key];
                    item.risk_cause_code =
                        currentRiskNumber.value + "." + risk_numbers[key];
                    onIncidentSave(item);
                    return item;
                });

            treatmentTable.querySelector('tbody').innerHTML = '';
            worksheet.mitigations = worksheet.mitigations.filter((item) => item.risk_cause_number != data.risk_cause_number)
                .map(item => {
                    addTreatmentRow(item);
                    return item;
                });

            const choices = [
                {
                    id: "Pilih",
                    value: "Pilih",
                    label: "Pilih",
                },
            ];

            for (let incident of worksheet.incidents) {
                choices.push({
                    id: incident.risk_cause_number,
                    value: incident.risk_cause_number,
                    label: incident.risk_cause_number,
                });
            }

            treatmentRiskCauseNumber.innerHTML = "<option>Pilih</option>";
            treatmentRiskCauseNumberChoices.destroy();
            treatmentRiskCauseNumberChoices.init();
            treatmentRiskCauseNumberChoices
                .setChoices(choices)
                .setChoiceByValue("Pilih");
        }
    );
    const buttonCell = document.createElement("td");
    buttonCell.appendChild(editButton);
    buttonCell.appendChild(removeButton);

    row.id = `incident-${data.key}`;
    row.innerHTML = `
        <td>${data.risk_cause_number}</td>
        <td>${data.risk_cause_code}</td>
        <td>${data.risk_cause_body}</td>
        <td>${data.kri_body}</td>
        <td>${incidentForm.querySelector(
        `select[name="kri_unit"] option[value="${data.kri_unit}"]`
    )?.textContent ?? ""
        }</td>
        <td>${data.kri_threshold_safe}</td>
        <td>${data.kri_threshold_caution}</td>
        <td>${data.kri_threshold_danger}</td>
    `;
    row.prepend(buttonCell);

    body.appendChild(row);
};

const updateIncidentRow = (data) => {
    const row = tables.incidents.querySelector("#incident-" + data.key);
    const cols = row.querySelectorAll("td");
    const [removeButton, editButton] = addRowAction(
        "incidents",
        data.key,
        (data) => onIncidentEdit(data),
        (data) => {
            worksheet.incidents = [
                ...worksheet.incidents
                    .filter((item) => item.key != data.key)
                    .map((item, key) => {
                        item.risk_cause_number = risk_numbers[key];
                        item.risk_cause_code =
                            currentRiskNumber.value + "." + risk_numbers[key];
                        onIncidentSave(item);
                        return item;
                    }),
            ];

            treatmentTable.querySelector('tbody').innerHTML = '';
            worksheet.mitigations = worksheet.mitigations.filter((item) => item.risk_cause_number != data.risk_cause_number)
                .map(item => {
                    addTreatmentRow(item);
                    return item;
                });

            const choices = [
                {
                    id: "Pilih",
                    value: "Pilih",
                    label: "Pilih",
                },
            ];

            for (let incident of worksheet.incidents) {
                choices.push({
                    id: incident.risk_cause_number,
                    value: incident.risk_cause_number,
                    label: incident.risk_cause_number,
                });
            }

            treatmentRiskCauseNumber.innerHTML = "<option>Pilih</option>";
            treatmentRiskCauseNumberChoices.destroy();
            treatmentRiskCauseNumberChoices.init();
            treatmentRiskCauseNumberChoices
                .setChoices(choices)
                .setChoiceByValue("Pilih");
        }
    );

    cols[0].innerHTML = '';
    cols[0].appendChild(editButton);
    cols[0].appendChild(removeButton);
    cols[1].textContent = data.risk_cause_number;
    cols[2].textContent = data.risk_cause_code;
    cols[3].innerHTML = data.risk_cause_body;
    cols[4].textContent = data.kri_body;
    cols[5].textContent =
        incidentForm.querySelector(
            `select[name="kri_unit"] option[value="${data.kri_unit}"]`
        )?.textContent ?? "";
    cols[6].textContent = data.kri_threshold_safe;
    cols[7].textContent = data.kri_threshold_caution;
    cols[8].textContent = data.kri_threshold_danger;
};

const treatmentForm = document.querySelector("#treatmentForm");
const treatmentRiskNumber = treatmentForm.querySelector('[name="risk_number"]');
const treatmentRiskCauseNumber = treatmentForm.querySelector(
    '[name="risk_cause_number"]'
);
const treatmentRiskCauseNumberChoices = new Choices(
    treatmentRiskCauseNumber,
    defaultConfigChoices
);
treatmentRiskCauseNumber.addEventListener("change", (e) => {
    const value = treatmentRiskCauseNumberChoices.getValue(true);
    if (value != "Pilih") {
        const data = worksheet.incidents.find(
            (incident) =>
                incident.risk_cause_number ==
                treatmentRiskCauseNumberChoices.getValue(true)
        );
        treatmentRiskCauseBodyQuill.root.innerHTML = data.risk_cause_body;
    }
});

const treatmentRiskCauseBody = treatmentForm.querySelector(
    '[name="risk_cause_body"]'
);
const treatmentRiskCauseBodyQuill = new Quill(
    treatmentForm.querySelector("#risk_cause_body-editor"),
    defaultConfigQuill
);
treatmentRiskCauseBodyQuill.enable(false);

let choices = [];
const treatmentRiskTreatmentOption = treatmentForm.querySelector(
    '[name="risk_treatment_option"]'
);
const treatmentRiskTreatmentOptionChoices = new Choices(
    treatmentRiskTreatmentOption,
    defaultConfigChoices
);
choices = treatmentRiskTreatmentOptionChoices._currentState.choices.map(
    (item) => {
        item.value = item?.value?.toString();
        return item;
    }
);
treatmentRiskTreatmentOptionChoices.clearChoices().setChoices(choices);

const treatmentRiskTreatmentType = treatmentForm.querySelector(
    '[name="risk_treatment_type"]'
);
const treatmentRiskTreatmentTypeChoices = new Choices(
    treatmentRiskTreatmentType,
    defaultConfigChoices
);
choices = treatmentRiskTreatmentTypeChoices._currentState.choices.map(
    (item) => {
        item.value = item?.value?.toString();
        return item;
    }
);
treatmentRiskTreatmentTypeChoices.clearChoices().setChoices(choices);

const treatmentTable = treatmentForm.querySelector("#worksheetTreatmentTable");
const treatmentModalButton = treatmentForm.querySelector(
    "#treatmentModalButton"
);
const treatmentModalElement = document.querySelector("#treatmentModal");
const treatmentModal = new Modal(treatmentModalElement);
const treatmentMitigationForm = treatmentModalElement.querySelector(
    "#treatmentMitigationForm"
);
const mitigationCost = treatmentMitigationForm.querySelector(
    '[name="mitigation_cost"]'
);
mitigationCost.addEventListener("keyup", (e) => {
    e.target.value = formatNumeral(e.target.value, defaultConfigFormatNumeral);
});
const mitigationPic = treatmentMitigationForm.querySelector(
    '[name="mitigation_pic"]'
);
mitigationPic.value = `${fetchers?.unit_head?.name ?? ""}`;

const mitigationProgramType = treatmentMitigationForm.querySelector(
    '[name="mitigation_rkap_program_type"]'
);
const mitigationProgramTypeChoices = new Choices(
    mitigationProgramType,
    defaultConfigChoices
);

const mitigationDateRange = treatmentMitigationForm.querySelector(
    "#mitigation_date-picker"
);
const mitigationStartDate = treatmentMitigationForm.querySelector(
    '[name="mitigation_start_date"]'
);
const mitigationEndDate = treatmentMitigationForm.querySelector(
    '[name="mitigation_end_date"]'
);

const mitigationTextareas = {};
for (let t of treatmentMitigationForm.querySelectorAll("textarea")) {
    mitigationTextareas[t.name] = t;
}

const mitigationQuills = {};
for (let editor of treatmentMitigationForm.querySelectorAll(".textarea")) {
    const targetId = editor.id.replaceAll("-editor", "");
    mitigationQuills[targetId] = new Quill(editor, defaultConfigQuill);
    mitigationQuills[targetId].on("text-change", (delta, oldDelta, source) => {
        mitigationTextareas[targetId].innerHTML =
            mitigationQuills[targetId].root.innerHTML;
    });
}

treatmentModalButton.addEventListener("click", (e) => {
    if (
        treatmentRiskCauseNumber.value == "Pilih" ||
        treatmentRiskTreatmentOption.value == "Pilih" ||
        treatmentRiskTreatmentType.value == "Pilih" ||
        !treatmentRiskCauseNumber.value ||
        !treatmentRiskTreatmentOption.value ||
        !treatmentRiskTreatmentType.value
    ) {
        Swal.fire({
            icon: "warning",
            title: "",
            text: "Pastikan penyebab risiko, Opsi dan jenis rencana perlakuan risiko telah terisi.",
        });
        return;
    }

    treatmentModal.show();
});

const mitigationDatePicker = flatpickr(mitigationDateRange, {
    mode: "range",
    dateFormat: "Y-m-d",
    altInput: true,
    altFormat: "j F Y",
    locale: defaultLocaleFlatpickr,
    onChange: (dates) => {
        mitigationStartDate.value =
            dates[0]?.getFullYear() +
            "-" +
            (dates[0]?.getMonth() + 1) +
            "-" +
            dates[0]?.getDate();
        mitigationEndDate.value =
            dates[1]?.getFullYear() +
            "-" +
            (dates[1]?.getMonth() + 1) +
            "-" +
            dates[1]?.getDate();
    },
    defaultDate: [mitigationStartDate.value, mitigationEndDate.value],
});

const addTreatmentRow = (data) => {
    const body = treatmentTable.querySelector("tbody");
    const row = document.createElement("tr");
    const [removeButton, editButton] = addRowAction(
        "mitigations",
        data.key,
        (data) => onTreatmentEdit(data)
    );
    const buttonCell = document.createElement("td");
    buttonCell.appendChild(editButton);
    buttonCell.appendChild(removeButton);
    row.id = `treatment-${data.key}`;
    row.innerHTML = `
        <td>${data.risk_cause_number}</td>
        <td>${treatmentRiskTreatmentOptionChoices._currentState.choices.find(
        (choice) =>
            choice.value == data?.risk_treatment_option?.toString()
    )?.label ?? ""
        }</td>
        <td>${treatmentRiskTreatmentTypeChoices._currentState.choices.find(
            (choice) =>
                choice.value == data?.risk_treatment_type?.toString()
        )?.label ?? ""
        }</td>
        <td>${data.mitigation_plan}</td>
        <td>${data.mitigation_output}</td>
        <td>${dayjs(data.mitigation_start_date).format("MMMM, DD YYYY")}</td>
        <td>${dayjs(data.mitigation_end_date).format("MMMM, DD YYYY")}</td>
        <td>${formatNumeral(
            data.mitigation_cost,
            defaultConfigFormatNumeral
        )}</td>
        <td>${mitigationProgramTypeChoices._currentState.choices.find(
            (choice) => choice.value == data.mitigation_rkap_program_type
        )?.label ?? ""
        }</td>
        <td>${data.mitigation_pic}</td>
    `;
    row.prepend(buttonCell);

    body.appendChild(row);
};

const updateTreatmentRow = (data) => {
    const row = treatmentTable.querySelector("#treatment-" + data.key);
    const cells = row.querySelectorAll("td");

    cells[1].textContent = data.risk_cause_number;
    cells[2].innerHTML =
        treatmentRiskTreatmentOptionChoices._currentState.choices.find(
            (choice) => choice.value == data.risk_treatment_option?.toString()
        )?.label ?? "";
    cells[3].innerHTML =
        treatmentRiskTreatmentTypeChoices._currentState.choices.find(
            (choice) => choice.value == data.risk_treatment_type?.toString()
        )?.label ?? "";
    cells[4].innerHTML = data.mitigation_plan;
    cells[5].innerHTML = data.mitigation_output;
    cells[6].textContent = dayjs(data.mitigation_start_date).format(
        "MMMM, DD YYYY"
    );
    cells[7].textContent = dayjs(data.mitigation_end_date).format(
        "MMMM, DD YYYY"
    );
    cells[8].textContent = formatNumeral(
        data.mitigation_cost,
        defaultConfigFormatNumeral
    );
    cells[9].textContent =
        mitigationProgramTypeChoices._currentState.choices.find(
            (choice) => choice.value == data.mitigation_rkap_program_type
        )?.label ?? "";
    cells[10].textContent = data.mitigation_pic;
};

const onTreatmentEdit = (data) => {
    Object.keys(data).forEach((key) => {
        const element = treatmentMitigationForm.querySelector(
            `[name="${key}"]`
        );
        const event = new Event("change");
        if (!element) return;

        if (key.includes("mitigation_cost")) {
            element.value = formatNumeral(
                data[key],
                defaultConfigFormatNumeral
            );
        } else if (key == "mitigation_rkap_program_type") {
            element.value = data[key];
            mitigationProgramTypeChoices.setChoiceByValue(data[key]);
        } else if (element.tagName == "TEXTAREA") {
            element.value = data[key];
            mitigationQuills[key].root.innerHTML = data[key];
        } else {
            element.value = data[key];
        }

        element.dispatchEvent(event);
    });

    // Set the flatpickr dates
    if (data.mitigation_start_date && data.mitigation_end_date) {
        mitigationDatePicker.setDate([
            data.mitigation_start_date,
            data.mitigation_end_date,
        ]);
    }

    treatmentRiskCauseNumberChoices.setChoiceByValue(data.risk_cause_number);
    treatmentRiskTreatmentOptionChoices.setChoiceByValue(
        data?.risk_treatment_option?.toString()
    );
    treatmentRiskTreatmentTypeChoices.setChoiceByValue(
        data?.risk_treatment_type?.toString()
    );
    mitigationPic.value = `${fetchers?.unit_head?.name ?? ""}`;

    treatmentModal.show();
};

const onTreatmentSave = (data) => {
    data.mitigation_cost = unformatNumeral(
        data.mitigation_cost,
        defaultConfigFormatNumeral
    ).replaceAll(".", ",");
    if (data.key) {
        worksheet.mitigations[
            worksheet.mitigations.findIndex((item) => item.key == data.key)
        ] = data;
        updateTreatmentRow(data);
    } else {
        data.key = generateRandomKey();
        worksheet.mitigations.push(data);
        addTreatmentRow(data);
    }

    setTimeout(() => treatmentModal.hide(), 325);
};

treatmentMitigationForm.addEventListener("submit", (e) => {
    e.preventDefault();

    const formData = new FormData(treatmentMitigationForm);

    const data = Object.fromEntries(formData);
    if (data.hasOwnProperty("search_terms")) {
        delete data.search_terms;
    }

    data.mitigation_plan = mitigationQuills.mitigation_plan.root.innerHTML;
    data.mitigation_output = mitigationQuills.mitigation_output.root.innerHTML;
    data.mitigation_pic = mitigationPic.value;
    data.organization_code = fetchers.unit_head.organization_code;
    data.organization_name = fetchers.unit_head.organization_name;
    data.unit_code = fetchers.unit_head.unit_code;
    data.unit_name = fetchers.unit_head.unit_name;
    data.sub_unit_code = fetchers.unit_head.sub_unit_code;
    data.sub_unit_name = fetchers.unit_head.sub_unit_name;
    data.personnel_area_code = fetchers.unit_head.personnel_area_code;
    data.personnel_area_name = fetchers.unit_head.personnel_area_name;
    data.position_name = fetchers.unit_head.position_name;
    data.risk_number = currentRiskNumber.value;
    data.risk_cause_number = treatmentRiskCauseNumberChoices.getValue(true);
    data.risk_treatment_option = treatmentForm.querySelector(
        '[name="risk_treatment_option"]'
    ).value;
    data.risk_treatment_type = treatmentForm.querySelector(
        '[name="risk_treatment_type"]'
    ).value;
    treatmentRiskCauseNumber.dispatchEvent(new Event("change"));

    for (let key of Object.keys(data)) {
        if (key == "key" || key == "id") {
            continue;
        }

        if (
            !data[key] ||
            data[key] == "Pilih" ||
            mitigationQuills[key]?.getLength() <= 1
        ) {
            Swal.fire(
                "Peringatan",
                "Pastikan semua isian harus terisi",
                "warning"
            );
            return;
        }
    }

    onTreatmentSave(data);
});

treatmentMitigationForm.addEventListener("reset", () => {
    treatmentModal.hide();
});

treatmentModalElement.addEventListener("hidden.bs.modal", () => {
    treatmentRiskTreatmentOptionChoices.destroy();
    treatmentRiskTreatmentOptionChoices.init();
    treatmentRiskTreatmentTypeChoices.destroy();
    treatmentRiskTreatmentTypeChoices.init();

    treatmentMitigationForm.reset();
    treatmentRiskCauseNumberChoices.setChoiceByValue("Pilih");
    treatmentRiskNumber.value = currentRiskNumber.value;
    treatmentRiskCauseBody.innerHTML = "";
    treatmentRiskCauseBodyQuill.root.innerHTML = "";

    treatmentMitigationForm.querySelector('[name="key"]').value = "";

    mitigationProgramTypeChoices.destroy();
    mitigationProgramTypeChoices.init();

    mitigationPic.value = `${fetchers?.unit_head?.name ?? ""}`;
    Object.keys(mitigationTextareas).forEach((key) => {
        mitigationTextareas[key].innerHTML = "";
        mitigationQuills[key].deleteText(0, mitigationQuills[key].getLength());
    });

    mitigationDatePicker.setDate(
        [
            dayjs(`${new Date().getFullYear()}-01-01`, "YYYY-MM-DD").format(
                "YYYY-MM-DD"
            ),
            dayjs(`${new Date().getFullYear()}-12-31`, "YYYY-MM-DD").format(
                "YYYY-MM-DD"
            ),
        ],
        false,
        "Y-m-d"
    );
});

worksheetTabSubmitButton.addEventListener("click", async (e) => {
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
                    .post(window.location.href, { ...worksheet })
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
});
