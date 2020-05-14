import { client } from './client'

const getAllCourses = () => client('courses')

const getBySubject = subjects => client('subjects', { body: subjects })

const getAllSubjects = () => client('subjects')

const getEnrolled = limit => client('enrolled', { body: limit })

const getCompleted = () => client('completed')

export const courses = {
  getAllCourses,
  getBySubject,
  getAllSubjects,
  getEnrolled,
  getCompleted,
}
