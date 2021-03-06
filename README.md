# CMPS 278 Final Project specifications

## Table of Contents

* [About](#about)
* [Setup](#setup)
    * [Client](#client-setup)
    * [Server](#server-setup)
* [Tasks](#tasks)
* [Specifications](#specifications)

## About

This is the final project for the CMPS 278 web development course. The project is essentially a Udemy clone.

## Setup

Clone the project:

```
git clone git@github.com:MaxMonteil/ProjectCookie.git
cd ProjectCookie
```

### Client Setup

__Note: You need to have [node](https://nodejs.org/en/) and [npm](https://www.npmjs.com/get-npm) installed__

```
// from the ProjectCookie folder
cd client

// install dependencies:
npm install

// start the client dev server
npm run serve
```

You can now find the client running on [http://localhost:8080](http://localhost:8080)

### Server Setup

__Note: You need to have [composer](https://getcomposer.org/) installed globally__

```
// from the ProjectCookie folder
cd server

// install dependencies
composer install
```

Set up your environment variables

In the folder `server/core` there is a file called `env.example`. Create a copy of this file in the same folder and name it `.env` (with the dot).
Then in this new file, fill out the empty variables (no spaces):

```
// server/core/.env
DB_NAME=<your database name>
DB_USERNAME=<your database username>
DB_PASSWORD=<your database password> // you can leave this blank if there is no password
// These are already filled out
DB_CONNECTION=mysql:host=localhost
EMAIL_USERNAME=projectcookievalidation@gmail.com
EMAIL_PASSWORD=ProjectCookie1@
```

Now you can start up the server

```
// inside the server folder
php -S localhost:8888
```

You can now find the server running on [http://localhost:8888](http://localhost:8888)

### Team Members

* Marwa
* Karim
* Max

## Tasks

### Division by Team Members

* Marwa
    * Database design
    * Back-end communication with the database
    * Front-end Design
* Karim
    * Back-end
* Max
    * Front-end Design
    * Front-end Implementation

### Database Design + Back-end Connection (Marwa)

Design of the MySQL database for the application and how it connects to eh back-end and which features it exposes.

#### Tables (tentative)

* Users
* Courses
* Quizzes

#### Features (tentative):

* Explore the course catalog
    * Searching
    * Browsing all
    * Most popular courses (i.e. the top 6 courses according to the number of people learning them).
    * Filtering by
        * topic
        * language
        * author
        * cost
        * starting date

* Explore a particular course
    * Description
    * Syllabus
    * Who is it for?
    * Starting/Ending date (i.e. the user can't join before or after these dates)
    * Cost

* User joins a course
* User attends/resumes a course
* User does a quiz
* Get the list of courses currently enrolled in on the homepage

### Back-end (Karim)

The rest of the back-end, beyond the database related tasks. It will follow an API based architecture and thus return JSON instead of full HTML pages.

* Authentication
    * Sign up/in
    * Activation by email
    * Forgot password
    * Logout
* Manage user accounts
    * activate/deactivate
    * suspend
    * delete
* Managing all the details of courses
    * listing
    * filtering
    * adding
    * editing
    * deleting (You cannot delete a course being currently attended)
* Uploading of course material
* Managing Quizzes (MCQ-type)
* Provide customer support
* Format and return database information
* Process front-end requests and return appropriate JSON response

### Front-end (Max) + Design (Marwa + Max)

The front-end will mostly be handling and displaying the UI to the user with proper formatting of the database information.

Marwa and Max will work on creating the design of the application and Max will be in charge of its implementation.

#### UI/Pages

* Authentication
    * Sign up/in
    * activation by email
    * forgot password
    * logout
* Explore the course catalog
    * Searching
    * Browsing all
    * Showing the most popular courses (i.e. the top 6 courses according to the number of people learning them).
    * Filtering by
        * topic
        * language
        * author
        * cost
        * starting date
* Explore a particular course
    * Description
    * Syllabus
    * Who is it for?
    * Starting/Ending date (i.e. the user can't join before or after these dates)
    * Cost
    * Join a course
* User dashboard
    * Attend/Resume lectures
    * Do quizzes
    * Get the list of courses currently enrolled in on the homepage and on user's page
    * Upload course material
    * Manage created courses
* Request Customer support
    * email
    * chat

## Specifications

### Front-end

* Authentication
    * Sign up/in
    * activation by email
    * forgot password
    * logout
* Explore the course catalog
    * Searching
    * Browsing all
    * Showing the most popular courses (i.e. the top 6 courses according to the number of people learning them).
    * Filtering by
        * topic
        * language
        * author
        * cost
        * starting date
* Explore a particular course
    * Description
    * Syllabus
    * Who is it for?
    * Starting/Ending date (i.e. the user can't join before or after these dates)
    * Cost
* Join a course
* Attend/Resume lectures
* Do quizzes
* Get the list of courses currently enrolled in on the homepage
* Request Customer support
    * email
    * chat

### Back-end

* Authentication
    * Sign up/in
    * activation by email
    * forgot password
    * logout
* Manage user accounts
    * activate/deactivate
    * suspend
    * delete
* Managing all the details of courses
    * listing
    * filtering
    * adding
    * editing
    * deleting (You cannot delete a course being currently attended)
* Managing Quizzes (MCQ-type)
* Provide customer support
