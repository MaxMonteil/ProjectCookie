import { client } from './client'

const getAllCourses = () => client('courses')

const getBySubject = subjects => client('subjects', { body: subjects })

const getAllSubjects = () => client('subjects')

const getEnrolled = limit => client('enrolled', { body: limit })

const getCompleted = () => client('completed')

const getPublished = user => client('published', { body: user })

const getDrafts = user => client('drafts', { body: user })

export const courses = {
  getAllCourses,
  getBySubject,
  getAllSubjects,
  getEnrolled,
  getCompleted,
  getPublished,
  getDrafts,
}
