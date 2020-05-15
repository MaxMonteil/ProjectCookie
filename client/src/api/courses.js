import { client } from './client'

const getAllCourses = () => client('courses')

const getOne = id => client('courses', { body: id })

const getBySubject = subjects => client('subjects', { body: subjects })

const getAllSubjects = () => client('subjects')

const getEnrolled = (email, limit) => client(`enrolled/${email}`, { body: limit })

const getCompleted = email => client(`completed/${email}`)

const getPublished = user => client('published', { body: user })

const getDrafts = user => client('drafts', { body: user })

export const courses = {
  getAllCourses,
  getOne,
  getBySubject,
  getAllSubjects,
  getEnrolled,
  getCompleted,
  getPublished,
  getDrafts,
}
