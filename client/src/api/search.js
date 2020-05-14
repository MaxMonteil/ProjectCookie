import { client } from './client'

const withOptions = searchOptions => client('search', { body: searchOptions })

export const search = {
  withOptions,
}
