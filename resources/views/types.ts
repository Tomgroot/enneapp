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
    type: number,
    content: string,
}

export interface IOption extends ITypeData {}
export interface IScale extends ITypeData {}
