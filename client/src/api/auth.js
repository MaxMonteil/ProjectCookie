import { client } from './client'

const login = credentials => client('login', { body: credentials })
const register = credentials => client('register', { body: credentials })
const changePass = details => client('changepassword', { body: details })
const resetPass = details => client('changepasswordrecovery', { body: details })
const sendPassReset = details =>
  client('sendpasswordrecovery', { body: details })
const verify = token => client('verify', { body: token })

export const auth = {
  login,
  register,
  changePass,
  resetPass,
  sendPassReset,
  verify,
}
