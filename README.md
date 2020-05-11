# CMPS 278 Final Project specifications

## Table of Contents

* [About](#about)
* [Tasks](#tasks)
* [Specifications](#specifications)

## About

This is the final project for the CMPS 278 web development course. The project is essentially a Udemy clone.

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
