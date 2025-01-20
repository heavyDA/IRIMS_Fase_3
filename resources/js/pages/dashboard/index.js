const dashboardFilter = document.querySelector('#dashboard-filter')
const selectYear = dashboardFilter.querySelector('select[name="year"]')
const selectUnit = dashboardFilter.querySelector('select[name="unit"]')

const selectYearChoices = new Choices(selectYear, defaultConfigChoices)
const selectUnitChoices = new Choices(selectUnit, defaultConfigChoices)