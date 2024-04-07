export enum PostType { TEXT, AUDIO, VIDEO }
export type PostPreview = { title: string, featuredImage: string, description: string, url: string, type: PostType }