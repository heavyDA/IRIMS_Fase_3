import { autoMergeCells } from "js/components/helper";

// Call the function when the page loads with columns to exclude
// Example: exclude columns 3 and 4 (risk_value and risk_value_limit)
document.addEventListener('DOMContentLoaded', () => {
    autoMergeCells('#contextTable', [5])
    autoMergeCells('#identificationTable', [4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14])
}); 