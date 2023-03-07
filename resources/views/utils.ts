import type {
    IDividedPoints,
    IResult,
    IResults,
    ISelected,
    ISelectedPoints,
    ITypeData,
} from './types';

export function calculateResults(selected: ISelected): IResults {
    const results = {
        scales: { per_type: [] as number[] } as IResult,
        keywords: { per_type: [] as number[] } as IResult,
        summaries: { per_type: [] as number[] } as IResult,
        winners: [] as number[],
        percentages: {
            scales: [] as number[],
            keywords: [] as number[],
            summaries: [] as number[],
            total: [] as number[],
        },
        ordered: [] as number[],
    };

    results.scales.per_type = accumulatePointsPerType(selected.scales);
    results.keywords.per_type = accumulateDividedPointsPerType(
        selected.keywords
    );
    results.summaries.per_type = accumulatePointsPerType(selected.summaries);

    results.percentages.scales = calculatePercentages(results.scales.per_type);
    results.percentages.keywords = calculatePercentages(
        results.keywords.per_type
    );
    results.percentages.summaries = calculatePercentages(
        results.summaries.per_type
    );
    for (let i = 1; i <= 9; i++) {
        results.percentages.total[i] =
            (results.percentages.summaries[i] * 2 +
                results.percentages.keywords[i] +
                results.percentages.scales[i] * 2) /
            5;
    }

    results.winners = calculateWinners(results.percentages.total);
    results.ordered = calculateOrdered(results.percentages.total);

    return results;
}

export function accumulatePointsPerType(
    pointData: ISelectedPoints[]
): number[] {
    const per_type = [] as number[];
    for (let i = 1; i <= 9; i++) {
        per_type[i] = 0;
    }
    pointData.forEach((point) => {
        if (point.content != '' && point.points && point.points > 0) {
            per_type[point.type] += point.points;
        }
    });
    return per_type;
}

export function accumulateDividedPointsPerType(
    pointData: IDividedPoints[][]
): number[] {
    const per_type = [] as number[];
    for (let i = 1; i <= 9; i++) {
        per_type[i] = 0;
    }
    pointData.forEach((points) => {
        points.forEach((point) => {
            if (point.content != '' && point.points && point.points > 0) {
                per_type[point.type] += point.points;
            }
        });
    });
    return per_type;
}

export function calculateWinners(per_type: number[]): number[] {
    let winners = [] as number[];
    let highest = 0;
    per_type.forEach((value, type) => {
        if (value > highest) {
            winners = [type];
            highest = value;
        } else if (value == highest) {
            winners.push(type);
        }
    });
    return winners;
}

function calculatePercentages(perType: number[]): number[] {
    const percentages = [] as number[];
    let count = 0;
    perType.forEach((value: number, i: number) => {
        if (i > 0 && i <= 9) {
            count += value;
        }
    });
    perType.forEach((value: number, i: number) => {
        if (i > 0 && i <= 9) {
            percentages[i] = (value / count) * 100;
        }
    });
    return percentages;
}

function calculateOrdered(percentages: number[]): number[] {
    const sortable = [] as number[][];
    for (let i = 1; i <= 9; i++) {
        sortable.push([i, percentages[i]]);
    }

    sortable.sort(function (a, b) {
        return b[1] - a[1];
    });

    const objSorted = [] as number[];
    sortable.forEach(function (item) {
        objSorted.push(item[0]);
    });
    return objSorted;
}
