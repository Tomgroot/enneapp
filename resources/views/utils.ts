import type { IResult, IResults, ISelected, ITypeData } from './types';

export function calculateResults(selected: ISelected): IResults {
    const results = {
        scales: { per_type: [] as number[] } as IResult,
        keywords: { per_type: [] as number[] } as IResult,
        summaries: { per_type: [] as number[] } as IResult,
        winners: [] as number[],
    };

    results.scales.per_type = accumulatePerType(selected.scales);
    results.scales.winners = calculateWinners(results.scales.per_type);

    results.keywords.per_type = accumulatePerType(selected.keywords);
    results.keywords.winners = calculateWinners(results.keywords.per_type);

    results.summaries.per_type = accumulatePerType(selected.summaries);
    results.summaries.winners = calculateWinners(results.summaries.per_type);

    results.winners = calculateOverallWinners(results);

    return results;
}

export function accumulatePerType(typeData: ITypeData[]): number[] {
    const per_type = [] as number[];
    for (let i = 1; i <= 9; i++) {
        per_type[i] = 0;
    }
    typeData.forEach((value) => {
        if (value.content != '') {
            per_type[value.type]++;
        }
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

function calculateOverallWinners(results: Partial<IResults>): number[] {
    const count = [] as number[];
    for (let i = 1; i <= 9; i++) {
        count[i] = 0;
    }
    results.scales?.winners.forEach((value) => {
        count[value]++;
    });
    results.keywords?.winners.forEach((value) => {
        count[value]++;
    });
    results.summaries?.winners.forEach((value) => {
        count[value]++;
    });
    return calculateWinners(count);
}
