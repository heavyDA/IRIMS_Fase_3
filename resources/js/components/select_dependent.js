import Choices from "choices.js"
import 'choices.js/src/styles/choices.scss'
import '../../scss/externals/choices.scss'

const handleLoadData = async (url, params) => {
    const response = await fetch(url + '?' + new URLSearchParams(params).toString())
        .then(response => response.json())
        .catch(error => error)

    return response?.data ?? []
}

export const SelectDependent = (select) => {
    if (!select.dataset.hasOwnProperty('children')) {
        return null
    }

    const children = select.dataset.children.split(',')
    const childSelects = []
    const childChoices = []

    for (const child of children) {
        const childSelect = document.querySelector(`select[name=${child}]`)
        const childChoice = new Choices(childSelect, {
            loadingText: "Memuat hasil pencarian...",
            noResultsText: "Hasil pencarian tidak ditemukan",
            noChoicesText: "Tidak ada pilihan",
            itemSelectText: "Tekan untuk memilih",
            searchFloor: 3,
            searchEnabled: true,
            allowHTML: false
        })

        childSelect.value = childSelect.dataset.value
        childSelects.push(childSelect)
        childChoices.push(childChoice)
    }

    const params = {}
    params[select.name] = select.value || select.dataset.value

    // Initialize default value
    childSelects.forEach(async (childSelect, index) => {
        SelectDependent(childSelect)
        if (childSelect.dataset.value) {
            const data = await handleLoadData(childSelect.dataset.url, params)
            childChoices[index]
                .setChoices(data.map(item => {
                    item.selected = childSelect.dataset.value == item.id
                    return item
                }), 'id', 'name', true)
                .enable()
        }
    })

    // Action when option is changed
    select.addEventListener('change', (e) => {
        const params = {}
        params[e.target.name] = e.target.value

        childSelects.forEach(async (childSelect, index) => {
            childSelect.value = null
            childChoices[index].clearStore()
            childSelect.dispatchEvent(new Event('change'))

            if (e.target.value) {
                const data = await handleLoadData(childSelect.dataset.url, params)
                childChoices[index]
                    .setChoices(data.map(item => {
                        item.selected = childSelect.dataset.value == item.id
                        return item
                    }), 'id', 'name', true)
                    .enable()
            } else {
                childChoices[index].disable()
            }
        })
    });
}
