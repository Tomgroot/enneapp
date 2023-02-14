export interface IQuestionData {
    summaries: ITypeData[],
    keywords: ITypeData[],
    scale: ITypeData[],
    summaries_per_type: {[x: number]: ITypeData[]}
    random: {
        summaries: number[][],
        keywords: number[][],
        scale: number[],
    }
}

export interface ITypeData {
    type: string,
    content: string,
}

export interface IOption {
    content: string,
}

export interface IScale extends IOption {}
