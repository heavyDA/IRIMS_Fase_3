const showFormAlert = (element) => {
    element = element || document.querySelector('#' + element) || document.querySelector('.' + element)

    if (element) {
        element.classList.remove('hide')
        element.classList.add('show')
    }
}

const formatDataToStructuredObject = (input) => {
    const data = {};

    // Helper function to process entries
    const processEntries = (entries) => {
        for (const [key, value] of entries) {
            const keyParts = key.split(/[\[\]]+/).filter(Boolean); // Split by brackets and remove empty parts
            let current = data;

            for (let i = 0; i < keyParts.length; i++) {
                const part = keyParts[i];

                if (i === keyParts.length - 1) {
                    // If it's the last part, set the value
                    current[part] = value;
                } else {
                    // Create nested structure if it doesn't exist
                    current[part] = current[part] || (isNaN(keyParts[i + 1]) ? {} : []);
                    current = current[part];
                }
            }
        }
    };

    // Detect input type
    if (input instanceof FormData) {
        processEntries(input.entries());
    } else if (typeof input === 'object' && input !== null) {
        processEntries(Object.entries(input));
    } else {
        throw new Error("Input must be a FormData object or a plain object.");
    }

    return data;
}

function autoMergeCells(target, excludeColumns = []) {
    const table = document.querySelector(target);
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));

    // First pass: Merge rows vertically
    for (let col = 0; col < rows[0].cells.length; col++) {
        // Skip excluded columns
        if (excludeColumns.includes(col)) continue;

        let currentValue = null;
        let startRow = 0;
        let rowsToMerge = 1;

        for (let row = 0; row < rows.length; row++) {
            const currentCell = rows[row].cells[col];
            const currentCellValue = currentCell.innerHTML.trim();

            if (currentValue === null) {
                currentValue = currentCellValue;
                startRow = row;
                continue;
            }

            if (currentCellValue === currentValue) {
                rowsToMerge++;
                currentCell.style.display = 'none';
            } else {
                if (rowsToMerge > 1) {
                    rows[startRow].cells[col].rowSpan = rowsToMerge;
                }
                currentValue = currentCellValue;
                startRow = row;
                rowsToMerge = 1;
            }
        }

        // Handle the last group
        if (rowsToMerge > 1) {
            rows[startRow].cells[col].rowSpan = rowsToMerge;
        }
    }

    // Second pass: Merge columns horizontally
    rows.forEach(row => {
        const cells = Array.from(row.cells)
            .filter(cell => cell.style.display !== 'none')
            .map((cell, index) => ({ cell, originalIndex: index }))
            .filter(({ originalIndex }) => !excludeColumns.includes(originalIndex));

        let currentValue = null;
        let startCell = 0;
        let cellsToMerge = 1;

        for (let i = 0; i < cells.length; i++) {
            const currentCell = cells[i].cell;
            const currentCellValue = currentCell.innerHTML.trim();

            if (currentValue === null) {
                currentValue = currentCellValue;
                startCell = i;
                continue;
            }

            if (currentCellValue === currentValue) {
                cellsToMerge++;
                currentCell.style.display = 'none';
            } else {
                if (cellsToMerge > 1) {
                    cells[startCell].cell.colSpan = cellsToMerge;
                }
                currentValue = currentCellValue;
                startCell = i;
                cellsToMerge = 1;
            }
        }

        // Handle the last group
        if (cellsToMerge > 1) {
            cells[startCell].cell.colSpan = cellsToMerge;
        }
    });
}

function decodeHtml(html) {
    const txt = document.createElement('textarea');
    txt.innerHTML = html;
    return txt.value;
}

const defaultConfigFormatNumeral = { prefix: 'Rp.', delimiter: '.', numeralPositiveOnly: true, numeralDecimalMark: ',' }
const defaultConfigQuill = {
    height: 120,
    modules: {
        toolbar: [
            ['bold', 'italic', 'underline', 'strike'],
            [{ 'align': [] }],
            [{ 'indent': '-1' }, { 'indent': '+1' }],
        ]
    },
    theme: 'snow'
};
const defaultConfigChoices = {
    classNames: { containerOuter: 'choices flex-grow-1' },
    removeItems: false,
    removeItemButton: false,
    shouldSort: false,
    duplicateItemsAllowed: false,
    placeholder: true,
    placeholderValue: null,
    allowHTML: true,
}

const defaultLocaleFlatpickr = {
    firstDayOfWeek: 1,
    weekdays: {
        shorthand: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
        longhand: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
    },
    months: {
        shorthand: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
        longhand: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
    }
}


export {
    defaultConfigFormatNumeral,
    defaultConfigQuill,
    defaultConfigChoices,
    defaultLocaleFlatpickr,
    decodeHtml,
    showFormAlert,
    formatDataToStructuredObject,
    autoMergeCells
}