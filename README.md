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

CREATE TABLE Users(
	UserID int NOT NULL AUTO_INCREMENT,
    Name varchar(30),
    Email varchar(30),
    Password varchar(30),
	PRIMARY KEY(UserID)
);
CREATE TABLE UserJoinCourse(
	UserID int NOT NULL,
    CourseID int NOT NULL, 
	CourseProgress varchar(15) NOT NULL,
	PRIMARY KEY(UserID, CourseID),
    FOREIGN KEY (UserID) REFERENCES Users(UserID),
    FOREIGN KEY (CourseID) REFERENCES Courses(CourseID)
);
CREATE TABLE UserDoQuiz(
	UserID int NOT NULL,
    QuizID int NOT NULL, 
	QuizProgress varchar(15) NOT NULL,
	PRIMARY KEY(UserID, QuizID),
    FOREIGN KEY (UserID) REFERENCES Users(UserID),
    FOREIGN KEY (QuizID) REFERENCES Quizzes(QuizID)
);
CREATE TABLE UserAttendClass(
	UserID int NOT NULL,
    ClassID int NOT NULL, 
	ClassProgress varchar(15) NOT NULL,
	PRIMARY KEY(UserID, ClassID),
    FOREIGN KEY (UserID) REFERENCES Users(UserID),
    FOREIGN KEY (ClassID) REFERENCES Classes(ClassID)
);
CREATE TABLE Quizzes(
	QuizID int NOT NULL AUTO_INCREMENT,
    QuestionsWithAns varchar(100),
    PRIMARY KEY(QuizID),
	CourseID int, 
    FOREIGN KEY (CourseID) REFERENCES Courses(CourseID)
);
CREATE TABLE Courses(
	CourseID int NOT NULL AUTO_INCREMENT,
    PRIMARY KEY(CourseID),
    CourseName varchar(50),
    Topic varchar(50),
    Description varchar(200),
    Teacher varchar(50),
    RecommendedUsers varchar(500),
    StartDate DATETIME,
    EndDate DATETIME,
    Cost varchar(20),
    NumOfViewers int,
    SyllabusName varchar(40) UNIQUE,
    FOREIGN KEY (SyllabusName) REFERENCES Syllabus(SyllabusName)
);

CREATE TABLE Classes(
	ClassID int NOT NULL AUTO_INCREMENT,
    PRIMARY KEY(ClassID),
    VideoPath varchar(200),
	Description varchar(200), 
    ModuleName varchar(100),
    CourseID int,
    FOREIGN KEY (CourseID) REFERENCES Courses(CourseID)
);


INSERT INTO `users`(`Name`, `Email`, `Password`) VALUES ("Rebica Smith","rebicasmith@gmail.com","stayCalm"),
("Saeed Raheel","sr46@aub.edu.lb","Ready2Roll"),
("Max Monteil","mmm110@mail.aub.edu","anonymous"),
("Karim Majed","rebicasmith@gmail.com","anonymous"),
("Hanin Wehbi","hanin.wehbi@gmail.com","jumpToMoon@midnt");

INSERT INTO `userjoincourse`(`UserID`, `CourseID`, `CourseProgress`) VALUES (2,1,"the creater"),
(1,1,"30"),
(2,2,"the creater"),
(3,2,"25");

INSERT INTO `userdoquiz`(`UserID`, `QuizID`, `QuizProgress`) VALUES (2,2,"the creater"),
(3,2,"95"),
 (1,2,"95");
INSERT INTO `userattendclass`(`UserID`, `ClassID`, `ClassProgress`) VALUES (3,5,"00:15:00"),
(1,6,"Finished");

INSERT INTO `courses`(`CourseName`, `Topic`, `Description`, `Teacher`, `RecommendedUsers`, `StartDate`, `EndDate`, `Cost`, `NumOfViewers`, `SyllabusName`) VALUES 
("Web programming","CMPS","This course help the students practice developing web pages and create a complete web project","Saeed Raheel","Seniors","2020-02-21 09:00:00","2020-05-2 10:00:00","$2500",1,"CMPS1"),
("Programming Languages","CMPS","This course help students to choose from different languages according to their needs","Saeed Raheel","Seniors","2020-02-21 08:00:00","2020-05-2 09:00:00","$2500",1,"CMPS2");

INSERT INTO `classes`(`VideoPath`, `Description`, `ModuleName`, `CourseID`) VALUES ("C:/user/msm56/Desktop/class1","Intro","Functional programming",2),
("C:/user/msm56/Desktop/class2","Slide 1 of FP","Pogramming language design",2),
("C:/user/msm56/Desktop/class3","Slide 2 of FP","Pogramming language design",2),
("C:/user/msm56/Desktop/class4","Slide 1 of OPP","Pogramming language design",2),
("C:/user/msm56/Desktop/class5","Slide 2 of OPP","Pogramming language design",2),
("C:/user/msm56/Desktop/class6","Slide 1 of Type Systems","Pogramming language design",2),
("C:/user/msm56/Desktop/class7","Slide 2 of Type Systems","Pogramming language design",2),
("C:/user/msm56/Desktop/class8","Slide 1 of Regex","Pogramming language implementation",2),
("C:/user/msm56/Desktop/class9","Slide 1 of Lexer","Pogramming language implementation",2),
("C:/user/msm56/Desktop/class10","Slide 1 of Grammer","Pogramming language implementation",2),
("C:/user/msm56/Desktop/class11","Slide 1 of Parser","Pogramming language implementation",2),
("C:/user/msm56/Desktop/class12","Slide 1 of Type Derivation","Pogramming language implementation",2),
("C:/user/msm56/Desktop/class13","Slide 1 of HTML & CSS","Front End",1),
("C:/user/msm56/Desktop/class14","Slide 1 of JS","Front End",1),
("C:/user/msm56/Desktop/class15","Slide 1 of JQuery & AJAX","Frontend",1),
("C:/user/msm56/Desktop/class16","Slide 1 of PHP","Backend",1),
("C:/user/msm56/Desktop/class17","Slide 1 of Cookies & sessions","Backend",1),
("C:/user/msm56/Desktop/class18","Slide 1 of ASP.Net",".net using VS",1);

INSERT INTO `quizzes`(`QuestionsWithAns`, `CourseID`) VALUES ( "What are higher order functions: a)",2),
( "Are html, ccs & js used for the frontend: a)",1);








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
