import Choices from "choices.js"
import Swal from "sweetalert2"
import { defaultConfigChoices } from "~js/components/helper"

const userForm = document.querySelector('#userForm')
const unitSelect = userForm.querySelector('select[name="sub_unit_code"]')
const unitSelectChoices = new Choices(unitSelect, defaultConfigChoices)
const unitPositionName = userForm.querySelector('input[name="position_name"]')

unitSelect.addEventListener('change', e => {
    if (e.target.value && e.target.value !== 'Pilih') {
        unitPositionName.value = unitSelectChoices.getValue()?.customProperties?.position_name
    }
})

document.addEventListener('DOMContentLoaded', async e => {
    await axios.get(`${window.location.origin}/setting/positions/all`)
        .then(response => {
            if (response.status == 200) {
                unitSelectChoices.setChoices([
                    {
                        value: 'Pilih',
                        label: 'Pilih',
                    },
                    ...response.data.data.map(unit => ({
                        value: unit.sub_unit_code,
                        label: `[${unit.sub_unit_code_doc}] ${unit.sub_unit_name}`,
                        customProperties: unit
                    }))
                ])
            }
        })
        .catch(error => {
            console.log(error)
            Swal.fire({
                icon: 'error',
                text: error.response?.data?.message ?? error?.message,
            })
        })

    if (unitSelect.dataset?.value) {
        unitSelectChoices.setChoiceByValue(unitSelect.dataset.value)
    }
})