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

function decodeHtml(html) {
    const txt = document.createElement('textarea');
    txt.innerHTML = html;
    return txt.value;
}

const defaultConfigFormatNumeral = { prefix: 'Rp.', delimiter: '.', numeralPositiveOnly: true, numeralDecimalMark: ',' }


export {
    defaultConfigFormatNumeral,
    decodeHtml,
    showFormAlert,
    formatDataToStructuredObject
}