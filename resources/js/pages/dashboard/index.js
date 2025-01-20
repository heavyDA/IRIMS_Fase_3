import Choices from "choices.js"
import { defaultConfigChoices } from "js/components/helper"

const dashboardFilter = document.querySelector('#dashboard-filter')
const selectYear = dashboardFilter.querySelector('select[name="year"]')
const selectUnit = dashboardFilter.querySelector('select[name="unit"]')

const selectYearChoices = new Choices(selectYear, defaultConfigChoices)
const selectUnitChoices = new Choices(selectUnit, defaultConfigChoices)

selectYear.addEventListener('change', e => {
    dashboardFilter.submit()
});

selectUnit.addEventListener('change', e => {
    dashboardFilter.submit()
});