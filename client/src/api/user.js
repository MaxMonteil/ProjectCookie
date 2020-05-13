import { client } from './client'

const get = email => client('get', { body: email })

export const user = {
  get,
}
