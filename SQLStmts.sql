SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT;
SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS;
SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION;
SET NAMES utf8;
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0;
/************************************************************/

DROP DATABASE IF EXISTS project_cookie;
CREATE DATABASE project_cookie;
USE project_cookie;

CREATE TABLE users(
    UserID int NOT NULL AUTO_INCREMENT,
    Name varchar(200),
    Email varchar(200) UNIQUE,
    Password varchar(256),
    Verified tinyint(1) default 0,
    EmailHash varchar(256),
    PRIMARY KEY(UserID)
);

CREATE TABLE courses(
    CourseID int NOT NULL AUTO_INCREMENT,
    PRIMARY KEY(CourseID),
    CourseName varchar(200),
    Subject varchar(200),
    Description varchar(200),
    RecommendedUsers varchar(500),
    StartDate varchar(250),
    CompletionDate DATE,
    Price varchar(20),
    NumOfViewers int,
    Teacher varchar(200),
    Language varchar(200),
    SyllabusName varchar(40) UNIQUE,
    IsDraft Boolean default TRUE,
);

CREATE TABLE quizzes(
    QuizID int NOT NULL AUTO_INCREMENT,
    QuestionsAns varchar(200),
    PRIMARY KEY(QuizID),
    CourseID int,
    FOREIGN KEY (CourseID) REFERENCES courses(CourseID)
);

CREATE TABLE classes(
    ClassID int NOT NULL AUTO_INCREMENT,
    ClassName varchar(200),
    PRIMARY KEY(ClassID),
    VideoPath varchar(256),
    Description varchar(200),
    ModuleName varchar(100),
    CourseID int,
    FOREIGN KEY (CourseID) REFERENCES courses(CourseID)
);

CREATE TABLE userJoinCourse(
    UserID int NOT NULL,
    CourseID int NOT NULL,
    CourseProgress varchar(15) NOT NULL,
    PRIMARY KEY(UserID, CourseID),
    FOREIGN KEY (UserID) REFERENCES users(UserID),
    FOREIGN KEY (CourseID) REFERENCES courses(CourseID)
);

CREATE TABLE userDoQuiz(
    UserID int NOT NULL,
    QuizID int NOT NULL,
    Completed Boolean default FALSE,
    PRIMARY KEY(UserID, QuizID),
    FOREIGN KEY (UserID) REFERENCES users(UserID),
    FOREIGN KEY (QuizID) REFERENCES quizzes(QuizID)
);

CREATE TABLE userAttendClass(
    UserID int NOT NULL,
    ClassID int NOT NULL,
    ClassProgress varchar(15) NULL,
    Completed Boolean default FALSE,
    PRIMARY KEY(UserID, ClassID),
    FOREIGN KEY (UserID) REFERENCES users(UserID),
    FOREIGN KEY (ClassID) REFERENCES classes(ClassID)
);

INSERT INTO `users`(`Name`, `Email`, `Password`)
VALUES
    ("Rebica Smith","rebicasmith@gmail.com","stayCalm"),
    ("Saeed Raheel","sr46@aub.edu.lb","Ready2Roll"),
    ("Max Monteil","mmm110@mail.aub.edu","anonymous"),
    ("Karim Majed","karimmajed@gmail.com","anonymous"),
    ("Hanin Wehbi","hanin.wehbi@gmail.com","jumpToMoon@midnt");


INSERT INTO `userJoinCourse`(`UserID`, `CourseID`, `CourseProgress`)
VALUES
    (1,1,"30"),
    (3,2,"25");

INSERT INTO `userDoQuiz`(`UserID`, `QuizID`, `Completed`)
VALUES
    (3,2, TRUE),
    (1,2, FALSE);

INSERT INTO `userAttendClass`(`UserID`, `ClassID`, `ClassProgress`, `Completed`)
VALUES
    (3,5,"00:15:00", FALSE),
    (1,6, NULL, TRUE);


INSERT
    INTO `courses`(`CourseName`, `Subject`, `Description`, `RecommendedUsers`, `StartDate`, `CompletionDate`, `Price`, `NumOfViewers`,`Teacher`, `Language`, `SyllabusName`, `IsDraft`)
    VALUES
        ("Web programming","CMPS","This course help the students practice developing web pages and create a complete web project","Seniors","2020-02-21","2020-05-2","$2500",1, "Saeed Raheel", "English", "CMPS1", FALSE),
        ("Programming Languages","CMPS","This course help students to choose from different languages according to their needs","Seniors","2020-02-21","2020-05-2","$2500",1, "Saeed Raheel", "English", "CMPS2", FALSE);

INSERT INTO `classes`(`ClassName`,`VideoPath`, `Description`, `ModuleName`, `CourseID`)
VALUES
    ("Programming Languages","C:/user/msm56/Desktop/class1","Intro","Functional programming",2),
    ("Programming Languages", "C:/user/msm56/Desktop/class2","Slide 1 of FP","Pogramming language design",2),
    ("Programming Languages", "C:/user/msm56/Desktop/class3","Slide 2 of FP","Pogramming language design",2),
    ("Programming Languages", "C:/user/msm56/Desktop/class4","Slide 1 of OPP","Pogramming language design",2),
    ("Programming Languages", "C:/user/msm56/Desktop/class5","Slide 2 of OPP","Pogramming language design",2),
    ("Programming Languages", "C:/user/msm56/Desktop/class6","Slide 1 of Type Systems","Pogramming language design",2),
    ("Programming Languages", "C:/user/msm56/Desktop/class7","Slide 2 of Type Systems","Pogramming language design",2),
    ("Programming Languages", "C:/user/msm56/Desktop/class8","Slide 1 of Regex","Pogramming language implementation",2),
    ("Programming Languages", "C:/user/msm56/Desktop/class9","Slide 1 of Lexer","Pogramming language implementation",2),
    ("Programming Languages", "C:/user/msm56/Desktop/class10","Slide 1 of Grammer","Pogramming language implementation",2),
    ("Programming Languages", "C:/user/msm56/Desktop/class11","Slide 1 of Parser","Pogramming language implementation",2),
    ("Programming Languages", "C:/user/msm56/Desktop/class12","Slide 1 of Type Derivation","Pogramming language implementation",2),
    ("Web Development","C:/user/msm56/Desktop/class13","Slide 1 of HTML & CSS","Front End",1),
    ("Web Development", "C:/user/msm56/Desktop/class14","Slide 1 of JS","Front End",1),
    ("Web Development", "C:/user/msm56/Desktop/class15","Slide 1 of JQuery & AJAX","Frontend",1),
    ("Web Development", "C:/user/msm56/Desktop/class16","Slide 1 of PHP","Backend",1),
    ("Web Development", "C:/user/msm56/Desktop/class17","Slide 1 of Cookies & sessions","Backend",1),
    ("Web Development", "C:/user/msm56/Desktop/class18","Slide 1 of ASP.Net",".net using VS",1);

INSERT INTO `quizzes`(`QuestionsAns`, `CourseID`)
VALUES
    ( "What are higher order functions: a)",2),
    ( "Are html, ccs & js used for the frontend: a)",1);

/************************************************************/
SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT;
SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS;
SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION;
SET SQL_NOTES=@OLD_SQL_NOTES;
