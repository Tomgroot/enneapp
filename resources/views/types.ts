export interface IQuestionData {
    summaries: ITypeData[],
    keywords: ITypeData[],
    scale: ITypeData[],
}

export interface ITypeData {
    type: string,
    content: string,
}
