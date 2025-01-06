import { autoMergeCells } from "js/components/helper";

// Call the function when the page loads with columns to exclude
// Example: exclude columns 3 and 4 (risk_value and risk_value_limit)
document.addEventListener('DOMContentLoaded', () => autoMergeCells('#contextTable', [5]));