# ProjectCookie Client

## Table of Contents

* [Project setup](#project-setup)
    * [Compiles-and-hot-reloads-for-development](#compiles-and-hot-reloads-for-development)
    * [Compiles and minifies for production](#compiles-and-minifies-for-production)
    * [Lints and fixes files](#lints-and-fixes-files)
* [Client-Server Communication Reference](#client-server-communication-reference)
    * [Errors](#errors)
    * [Auth](#auth)
        * [Login](#login)
        * [Register](#register)
        * [Change Password](#change-password)
    * [User](#user)
        * [Get User](#get-user)
    * [Courses](#courses)
        * [Get all courses](#get-all-courses)
        * [Get all courses by subject](#get-all-courses-by-subject)
        * [Get all subjects](#get-all-subjects)
        * [Get enrolled courses](#get-enrolled-courses)
        * [Get completed courses](#get-completed-courses)
        * [Get published and draft courses](#get-published-and-draft-courses)
        * [Create a Course](#create-a-course)
        * [Publish a Course](#publish-a-course)
    * [Lessons](#lessons)
        * [Get one lesson](#get-one-lesson)
        * [Toggle lesson completion](#toggle-lesson-completion)
    * [Search](#search)
        * [Search for a query](#search-for-a-query)

## Project setup
```
npm install
```

### Compiles and hot-reloads for development
```
npm run serve
```

### Compiles and minifies for production
```
npm run build
```

### Lints and fixes files
```
npm run lint
```

## Client-Server Communication Reference

This is a reference of all the routes of the client side along with the server endpoints it communicates with. It describes the format and structure of the data it requests and sends.

### Parsing JSON data

When the client sends JSON data to the server, it sets the `Content-Type` header to `application/json`. This data type cannot be handled by the PHP super global `$_POST`. Instead you must retrieve the data from PHP's input stream and then decode it.

```php
$data = json_decode(file_get_contents('php://input'), true);
```

So if the client POSTS this:

```jsonc
{
    "name": "John Doe",
    "age": 30
}
```

The above PHP code will give us this:

```php
$data = json_decode(file_get_contents('php://input'), true);

// $data['name'] => 'John Doe'
// $data['age'] => 30
```

### Errors

```jsonc
{
    "message": "oops something went wrong" //string
}
```

### Auth

#### Login

| endpoint | method |
| -------- |:------:|
| /login   | POST   |

##### Data

```jsonc
{
    "email": "abc123@mail.edu", // string
    "password": "password123",  // string
}
```

##### Expected Response

```jsonc
{
    "jwt": "jwt_token_oaiwhtalwkj", // string
    "email": "abc123@mail.edu"      // string
}
```

#### Register

| endpoint | method |
| -------- |:------:|
| /register   | POST   |

##### Data

```jsonc
{
    "email": "abc123@mail.edu",         // string
    "password": "password123",          // string
    "confirmpassword": "password123",   // string
}
```

#### Change Password

| endpoint | method |
| -------- |:------:|
| /changepassword   | POST   |

##### Data

```jsonc
{
    "email": "abc123@mail.edu",         // string
    "oldpassword": "password123",       // string
    "newpassword": "123456pass",        // string
    "confirmnewpassword": "123456pass", // string
}
```

### User

#### Get User

| endpoint | method |
| -------- |:------:|
| /user    | POST   |

##### Data

```jsonc
{
    "email": "abc123@mail.edu", // string
}
```

##### Expected Response

### Courses

#### Get all courses

| endpoint | method | description |
| -------- |:------:| ----------- |
| /courses    | GET   | get all courses |
| /courses    | POST   | get a course by id |

##### Data

```jsonc
{
    "courseId": "fpiu314" // string
}
```

##### Expected GET Response

```jsonc
{
    "courses": [
        {
            "id": "fpiu314",            // string
            "name": "web dev",          // string
            "startDate": "YYYY-MM-DD",  // string
            "studentCount": 459,        // number
            "description": "This course is about web dev..." // string
        }
        // ...
    ],
    // available search options the user can use for a more advanced search
    "searchOptions": {
        "subject": [
            "history",
            "math"
            // ...
        ],
        "language": [
            "english",
            "french"
            // ...
        ]
    },
}
```

##### Expected POST Response

```jsonc
{
    "id": "fpiu314",                                    // string
    "name": "web dev",                                  // string
    "teacher": "Jane Doe",                              // string
    "startDate": "YYYY-MM-DD",                          // string
    "studentCount": 459,                                // number
    "description": "This course is about web dev...",   // string
    "price": 20,                                        // number
    "syllabus": [
        {
            "id": "doy32fe",                                // string
            "name": "The Web",                              // string
            "description": "An introduction to the web",    // string
            "lessons": [
                {
                    "id": "lesgh893",               // string
                    "courseId": "fpiu314",          // string
                    "sectionId": "doy32fe",         // string
                    "name": "How the web works",    // string
                },
                // ... other lessons
            ]
        },
        // ... other sections
    ]
}
```

#### Get all courses by subject

| endpoint | method |
| -------- |:------:|
| /subjects    | POST   |

##### Data

```jsonc
{
    "subjects": [
        "history",
        "math"
        // ...
    ]
}
```

##### Expected Response

```jsonc
{
    "history": [
        {
            "id": "fpiu314",            // string
            "name": "web dev",          // string
            "startDate": "YYYY-MM-DD",  // string
            "studentCount": 459,        // number
            "description": "This course is about web dev..." // string
        }
        // ...
    ]
    // ...
}
```

#### Get all subjects

| endpoint | method |
| -------- |:------:|
| /subjects    | GET   |

##### Expected Response

```jsonc
{
    "subjects": [
        "history",
        "math"
        // ...
    ],
}
```

#### Get enrolled courses

| endpoint | method | description |
| -------- |:------:| ----------- |
| /enrolled?email=\<email\>    | GET   | get all the courses enrolled |
| /enrolled?email=\<email\>    | POST   | get a certain number of courses |

##### Data

```jsonc
{
    "limit": 4  // number, number of courses to return
}
```

##### Expected response

```jsonc
{
    "courses": [
        {
            "id": "fpiu314",    // string
            "name": "web dev",  // string
            "progress": 32      // number
        },
        // ...
    ]
}
```

#### Get completed courses

| endpoint | method | description |
| -------- |:------:| ----------- |
| /completed?email=\<email\>    | GET   | get all completed courses |

##### Expected response

```jsonc
{
    "courses": [
        {
            "id": "fpiu314",            // string
            "name": "web dev",          // string
            "completedOn": "YYYY-MM-DD" // number
        },
        // ...
    ]
}
```

#### Get published and draft courses

| endpoint | method | description |
| -------- |:------:| ----------- |
| /published    | POST   | get all published courses |
| /drafts    | POST   | get all drafts |

##### Data

```jsonc
{
    "email": "abc123@aub.mail.edu" // string
}
```

##### Expected response

```jsonc
{
    "courses": [
        {
            "id": "fpiu314",    // string
            "name": "web dev",  // string
            "isDraft": false,   // boolean
        },
        // ...
    ]
}
```

#### Create a Course

| endpoint | method | description |
| -------- |:------:| ----------- |
| /create-course | POST | create a new course |

##### Data

```jsonc
{
    "name": "course name",
    "subject": "math",
    "language": "english",
    "startDate": "YYYY-MM-DD",
    "description": "This is a course about math",
    "price": 30,
    "syllabus": [
        "name": "module name",
        "description": "this module is about arithmetic",
        "lessons": [
            // type class
            {
                "name": "learning addition",
                "type": "class",
                "description": "first we will learn how to add",
                "link": "https://www.youtube.com/fjoefh",
            },

            // type quiz
            {
                "name": "Quiz One",
                "type": "quiz",
                "description": "This quiz is about math",
                "questions": [
                    {
                        "question": "What is 1+1?",
                        "correct": "2",
                        "answers": [
                            "1",
                            "2"
                        ],
                    },
                    // ...
                ]
            },
        ],
    ],
}
```

#### Publish a Course

| endpoint | method | description |
| -------- |:------:| ----------- |
| /publish | POST | publish to the store/home this course |

##### Data

```jsonc
{
    "email": "abc123@mail.aub.edu",
    "id": "courseId",
}
```

### Lessons

#### Get one lesson

| endpoint | method |
| -------- |:------:|
| /lessons    | post   |

##### Data

```jsonc
{
    "email": "abc123@mail.aub.edu", // string or null, to check if they are enrolled
    "courseid": "fpiu314",          // string
    "sectionid": "doy32fe",         // string
    "lessonid": "lesgh893",         // string
}
```

##### Expected Response

```jsonc
{
    "courseName": "web dev", // string
    "lesson": {
        // both types
        "id": "lesgh893",         // string
        "sectionId": "doy32fe",         // string
        "courseId": "fpiu314",          // string
        "prevLessonId": "lessonId", // string, id of the lesson that comes before it, empty string if this is lesson 1
        "nextLessonId": "lessonId", // string, id of the lesson that comes after it, empty string if this is the last lesson
        "name": "lesson name", // string
        "description": "Some description about this lesson", // string
        "completed": true, // boolean

        // type 'class'
        "link": "youtube url",  // string
        "type": "class",        // string

        // type 'quiz'
        "type": "quiz",
        "questions": [
            {
                "question": "actual question being asked", // string
                "answers": [
                    "Option A",
                    "Option B",
                    // ...
                ]
            },
            // ... other questions
        ],
    }
}
```

#### Toggle lesson completion

Set a lesson's completion to true or false.

| endpoint | method |
| -------- |:------:|
| /complete-lesson    | POST   |

##### Data

```jsonc
{
    "email": "abc123@mail.aub.edu", // string or null, to check if they are enrolled
    "courseid": "fpiu314",          // string
    "sectionid": "doy32fe",         // string
    "lessonid": "lesgh893",         // string
}
```

##### Expected Response

Success code 200

### Search

#### Search for a query

| endpoint | method |
| -------- |:------:|
| /search    | POST   |

##### Data

```jsonc
{
    "search": "web dev",        // string, user's search term

    // optional parameters, if they are empty string, disregard
    "options": {
        "subject": "history"    // string
        "language": "english"   // string
        "price": 10             // number | null
    }
}
```

##### Expected Response

```jsonc
{
    "courses": [
        {
            "id": "fpiu314",            // string
            "name": "web dev",          // string
            "startDate": "YYYY-MM-DD",  // string
            "studentCount": 459,        // number
            "description": "This course is about web dev..." // string
        }
        // ...
    ],
    // available search options the user can use for a more advanced search
    "searchOptions": {
        "subject": [
            "history",
            "math"
            // ...
        ],
        "language": [
            "english",
            "french"
            // ...
        ]
    },
}
```

