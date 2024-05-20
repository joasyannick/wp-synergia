export enum Media { TEXT, AUDIO, VIDEO }
export type SingleContentPreview = { cardinality: 'one', id: number, title: string, description: string, thumbnail: string, background: string, media: Set<Media>, url: string }
export type CompositeContentPreview = { cardinality: 'many', id: number, title: string, description: string, thumbnail: string, background: string, subcontents: ContentPreview[] }
export type ContentPreview = SingleContentPreview | CompositeContentPreview
export function isSingleContentPreview( preview: ContentPreview ): preview is SingleContentPreview { return preview.cardinality === 'one' }