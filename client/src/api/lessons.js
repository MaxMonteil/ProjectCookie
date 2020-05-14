import { client } from './client'

const getOne = data => client('lessons', { body: data })

const toggleCompletion = data => client('complete-lesson', { body: data })

export const lessons = {
  getOne,
  toggleCompletion,
}
