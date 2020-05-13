import { client } from './client'

const getAllCourses = () => client('courses')
const withOptions = searchOptions => client('courses', { body: searchOptions })

export const search = {
  getAllCourses,
  withOptions,
}
