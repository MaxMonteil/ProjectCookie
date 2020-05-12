import { client } from './client'

const login = credentials => client('login', { body: credentials })
const register = credentials => client('register', { body: credentials })
const changePass = credentials =>
  client('changepassword', { body: credentials })

export const auth = {
  login,
  register,
  changePass,
}
