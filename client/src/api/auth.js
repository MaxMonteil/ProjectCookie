import { client } from './client'

const login = credentials => client('login', { body: credentials })
const register = credentials => client('register', { body: credentials })

export const auth = {
  login,
  register,
}
