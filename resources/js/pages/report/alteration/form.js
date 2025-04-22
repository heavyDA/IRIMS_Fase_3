import { defaultConfigChoices, defaultConfigQuill } from "~js/components/helper";
import Quill from "quill";
import "quill/dist/quill.snow.css";
import "~css/quill.css";
import Choices from "choices.js";

const alterationForm = document.querySelector('#alteration-form');

const worksheetSelect = alterationForm.querySelector('select[name="worksheet_id"]');
const worksheetChoice = new Choices(worksheetSelect, defaultConfigChoices)

const textareas = alterationForm.querySelectorAll('textarea');
const textareaEditors = [];
for (const textarea of textareas) {
    textareaEditors[textarea.name] = new Quill(`#${textarea.name}-editor`, defaultConfigQuill)
    textareaEditors[textarea.name].root.innerHTML = textarea.value;
    textareaEditors[textarea.name].on("text-change", (delta, oldDelta, source) => {
        textarea.value = textareaEditors[textarea.name].root.innerHTML;
    })
}