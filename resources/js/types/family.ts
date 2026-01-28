export interface Person {
  id: string
  name: string
  gender: 'male' | 'female' | 'other'
  birth?: string
  death?: string
}

export interface Relationship {
  parent_id: string
  child_id: string
  type?: 'father' | 'mother'
}
