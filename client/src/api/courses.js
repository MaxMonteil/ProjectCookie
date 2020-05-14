import { client } from './client'

const getAllCourses = () => client('courses')

const getBySubject = subjects => client('subjects', { body: subjects })

const getAllSubjects = () => client('subjects')

export const courses = {
  getAllCourses,
  getBySubject,
  getAllSubjects,
}
