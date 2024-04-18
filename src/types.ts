export enum ContentType { TEXT, AUDIO, VIDEO }

export type ContentPreview =
    { title: string, description: string, thumbnail: string, background: string, type: ContentType, url: string } |
    { title: string, description: string, thumbnail: string, background: string, subcontents: ContentPreview[] }