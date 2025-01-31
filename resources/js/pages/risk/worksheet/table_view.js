import { autoMergeCells } from "js/components/helper";

// Call the function when the page loads with columns to exclude
// Example: exclude columns 3 and 4 (risk_value and risk_value_limit)
document.addEventListener('DOMContentLoaded', () => {
    let excludeColumns = [1, 5]
    autoMergeCells('#contextTable', excludeColumns)

    excludeColumns = Array.from({ length: 52 }, (x, i) => i + 4)
    autoMergeCells('#identificationTable', excludeColumns)
}); 