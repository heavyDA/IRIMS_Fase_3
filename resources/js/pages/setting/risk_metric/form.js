import { formatNumeral } from "cleave-zen";
import { defaultConfigFormatNumeral } from "~js/components/helper";

const form = document.querySelector('#risk-metrics-form');
const currencyFields = form.querySelectorAll('.currency');

currencyFields.forEach(field => {
    field.addEventListener('input', e => {
        e.target.value = formatNumeral(e.target.value, defaultConfigFormatNumeral);
    })
})