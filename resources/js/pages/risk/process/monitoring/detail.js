import { autoMergeCells } from 'js/components/helper'

if (residualTable) {
    let excludes = [2, 3];
    for (let i = 5; i <= 32; i++) excludes.push(i)
    autoMergeCells('#residualTable', excludes)
}