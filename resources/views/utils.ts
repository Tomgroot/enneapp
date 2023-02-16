import type { IOption, IResult, IResults, IScale } from './types';

export function calculateResults(
    selected: number[],
    options: IOption[][],
    scales: IScale[],
    nrOfKeywords: number
): IResults {
    const results = {
        scales: { per_type: [] as number[] } as IResult,
        keywords: { per_type: [] as number[] } as IResult,
        summaries: { per_type: [] as number[] } as IResult,
    };

    for (let i = 1; i <= 9; i++) {
        results.scales.per_type[i] = 0;
        results.keywords.per_type[i] = 0;
        results.summaries.per_type[i] = 0;
    }

    selected.forEach((value, key) => {
        // Scales
        if (key < scales.length) {
            if (value === 1) {
                const type: number = scales[key].type;
                results.scales.per_type[type]++;
            }
        } else {
            const type: number = options[key - scales.length][value].type;
            if (key < scales.length + nrOfKeywords + 1) {
                results.keywords.per_type[type]++;
            } else {
                results.summaries.per_type[type]++;
            }
        }
    });

    return results;
}
