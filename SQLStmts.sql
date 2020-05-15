CREATE TABLE Users(
	UserID int NOT NULL AUTO_INCREMENT,
    Name varchar(200),
    Email varchar(200) UNIQUE,
    Password varchar(256),
    Verified tinyint(1) default 0,
    EmailHash varchar(256),
	PRIMARY KEY(UserID)
);

CREATE TABLE UserJoinCourse(
	UserID int NOT NULL,
    CourseID int NOT NULL, 
	CourseProgress varchar(15) NOT NULL,
    Completed Boolean default FALSE,
    CompletedOn varchar(60),
	PRIMARY KEY(UserID, CourseID),
    FOREIGN KEY (UserID) REFERENCES Users(UserID),
    FOREIGN KEY (CourseID) REFERENCES Courses(CourseID)
);
CREATE TABLE UserDoQuiz(
	UserID int NOT NULL,
    QuizID int NOT NULL, 
	Completed Boolean default FALSE,
	PRIMARY KEY(UserID, QuizID),
    FOREIGN KEY (UserID) REFERENCES Users(UserID),
    FOREIGN KEY (QuizID) REFERENCES Quizzes(QuizID)
);

CREATE TABLE UserAttendClass(
	UserID int NOT NULL,
    ClassID int NOT NULL, 
	ClassProgress varchar(15) NOT NULL,
    Completed Boolean default FALSE,
	PRIMARY KEY(UserID, ClassID),
    FOREIGN KEY (UserID) REFERENCES Users(UserID),
    FOREIGN KEY (ClassID) REFERENCES Classes(ClassID)
);

CREATE TABLE Quizzes(
	QuizID int NOT NULL AUTO_INCREMENT,
    QuestionsAns varchar(200),
    PRIMARY KEY(QuizID),
	CourseID int, 
    FOREIGN KEY (CourseID) REFERENCES Courses(CourseID)
);

CREATE TABLE Courses(
	CourseID int NOT NULL AUTO_INCREMENT,
    PRIMARY KEY(CourseID),
    CourseName varchar(200),
    Subject varchar(200),
    Description varchar(200),
    RecommendedUsers varchar(500),
    StartDate varchar(60),
    EndDate varchar(60),
    Price varchar(20),
    NumOfViewers int,
    Teacher varchar(200),
    Language varchar(200),
    SyllabusName varchar(40) UNIQUE,
);


CREATE TABLE Classes(
	ClassID int NOT NULL AUTO_INCREMENT,
    ClassName varchar(200),
    PRIMARY KEY(ClassID),
    VideoLink varchar(256),
	Description varchar(200), 
    ModuleName varchar(100) UNIQUE,
    CourseID int,
    FOREIGN KEY (CourseID) REFERENCES Courses(CourseID)
);

INSERT INTO `users`(`Name`, `Email`, `Password`) VALUES ("Rebica Smith","rebicasmith@gmail.com","stayCalm"),
("Saeed Raheel","sr46@aub.edu.lb","Ready2Roll"),
("Max Monteil","mmm110@mail.aub.edu","anonymous"),
("Karim Majed","rebicasmith@gmail.com","anonymous"),
("Hanin Wehbi","hanin.wehbi@gmail.com","jumpToMoon@midnt");


INSERT INTO `userjoincourse`(`UserID`, `CourseID`, `CourseProgress`) VALUES (1,1,"30"), 
(3,2,"25");
INSERT INTO `userdoquiz`(`UserID`, `QuizID`, `Completed`) VALUES (3,2, TRUE),
(1,2, FALSE);
INSERT INTO `userattendclass`(`UserID`, `ClassID`, `ClassProgress`, 'Completed') VALUES (3,5,"00:15:00", FALSE),
(1,6, NULL, TRUE);


INSERT INTO `courses`(`CourseName`, `Subject`, `Description`, `RecommendedUsers`, `StartDate`, `EndDate`, `Price`, `NumOfViewers`,`Teacher`, `Language`, `SyllabusName`) VALUES 
("Web programming","CMPS","This course help the students practice developing web pages and create a complete web project","Seniors","2020-02-21","2020-05-2","$2500",1, "Saeed Raheel", "English", "CMPS1"),
("Programming Languages","CMPS","This course help students to choose from different languages according to their needs","Seniors","2020-02-21","2020-05-2","$2500",1, "Saeed Raheel", "English", "CMPS2");

INSERT INTO `classes`('ClassName',`VideoPath`, `Description`, `ModuleName`, `CourseID`) VALUES ("Programming Languages","C:/user/msm56/Desktop/class1","Intro","Functional programming",2),
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

INSERT INTO `quizzes`(`QuestionsWithAns`, `CourseID`) VALUES ( "What are higher order functions: a)",2),
( "Are html, ccs & js used for the frontend: a)",1);