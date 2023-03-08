export interface IQuestionData {
    summaries: ITypeData[];
    keywords: ITypeData[];
    statements: ITypeData[];
    summaries_per_type: { [x: number]: ITypeData[] };
    random: {
        summaries: number[];
        keywords: number[];
        statements: number[];
    };
}

export interface ITypeData {
    type: number;
    content: string;
}

export interface ISelected {
    keywords: IDividedPoints[][];
    summaries: IDividedPoints[];
    statements: ISelectedPoints[];
}

export interface IResults {
    keywords: IResult;
    summaries: IResult;
    statements: IResult;
    winners: number[];
    percentages: {
        statements: number[];
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
