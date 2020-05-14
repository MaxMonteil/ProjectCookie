import { client } from './client'

const getOne = data => client('lessons', { body: data })

export const lessons = {
  getOne,
}
