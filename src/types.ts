enum PostType { TEXT, AUDIO, VIDEO }
type PostPreview = { title: string, featuredImage: string, description: string, url: string, type: PostType }

export type { PostPreview }