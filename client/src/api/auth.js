import { client } from './client'

const login = credentials => client('login', { body: credentials })

export const auth = {
  login,
}
