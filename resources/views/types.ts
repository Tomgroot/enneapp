export interface IQuestionData {
    summaries: ITypeData[];
    keywords: ITypeData[];
    scale: ITypeData[];
    summaries_per_type: { [x: number]: ITypeData[] };
    random: {
        summaries: number[];
        keywords: number[];
        scale: number[];
    };
}

export interface ITypeData {
    type: number;
    content: string;
}

export interface ISelected {
    keywords: IDividedPoints[][];
    summaries: IDividedPoints[];
    scales: ISelectedPoints[];
}

export interface IResults {
    keywords: IResult;
    summaries: IResult;
    scales: IResult;
    winners: number[];
    percentages: {
        scales: number[];
        keywords: number[];
        summaries: number[];
        total: number[];
    };
}

export interface IResult {
    per_type: number[];
    /** @deprecated **/
    winners: number[];
}

export interface IDividedPoints extends ITypeData {
    points: number;
}

export type IOption = ITypeData;
export type IScale = ITypeData;

export type ISelectedPoints = IDividedPoints;
