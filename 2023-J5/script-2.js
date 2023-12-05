const fs = require('fs');

function getMinSeedLocation(ranges) {
    let min = Number.MAX_SAFE_INTEGER;

    for (const range of Object.values(ranges)) {
        for (const ran of range) {
            min = Math.min(min, ran.min, ran.max);
        }
    }

    return min;
}

function arrayIntersect(array1, array2) {
    const [start1, end1] = array1;
    const [start2, end2] = array2;

    return start1 <= end2 && end1 >= start2;
}

function getSeedRanges(seeds) {
    const res = [];
    for (let i = 0; i < seeds.length; i += 2) {
        const nb = parseInt(seeds[i]);
        const size = parseInt(seeds[i + 1]);
        res.push({ min: nb, max: nb + size });
    }

    return res;
}

function convertRange(range, mappings) {
    const resultRanges = [];
    const { min, max } = range;

    for (const mapping of mappings) {
        const [destStart, sourceStart, length] = mapping;
        const sourceEnd = sourceStart + length;

        if (arrayIntersect([min, max], [sourceStart, sourceEnd])) {
            const mappedMin = Math.max(min, sourceStart);
            const mappedMax = Math.min(max, sourceEnd);

            resultRanges.push({
                min: destStart + (mappedMin - sourceStart),
                max: destStart + (mappedMax - sourceStart),
            });
        }
    }

    if (resultRanges.length === 0) {
        resultRanges.push(range);
    }

    return resultRanges;
}

const input = fs.readFileSync(__dirname + '/data.txt', 'utf-8');
const rows = input.split(/\r?\n/);
const seeds = rows[0].substring(7).split(' ').map(Number);
rows.shift();
let mappingName = '';
const mappings = {};

let ranges = getSeedRanges(seeds);

for (const row of rows) {
    if (row.trim() === '') {
        continue;
    }

    if (row.includes('map:')) {
        [mappingName] = row.split('map:');
        mappingName = mappingName.trim()
        mappings[mappingName] = [];
    } else {
        mappings[mappingName].push(row.trim().split(' ').map(Number));
    }
}

for (const range of ranges) {
    let newRanges = [];
    for (const [mappingName, mapping] of Object.entries(mappings)) {
        const convertedRanges = convertRange(range, mapping);
        newRanges = [...newRanges, ...convertedRanges];
    }
    ranges = { [mappingName]: newRanges };
}

console.log(ranges)
const res = getMinSeedLocation(ranges);
console.log(res);
