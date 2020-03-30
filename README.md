# AUB Board

AUB Board is an application aiming to help students locked in the AUB dorms during the COVID-19 quarantine.

Currently, to leave campus, a student must obtain permission from the Protection Office at least a day in advance. Board will help students piggyback their tasks onto students who have obtained permission.

## User Stories

The only kind of user is the Student, these stories are from their point of view.

A student can:

### Profile

* Create profile with their AUB email to see and use Board (no anonymous users)
* Specify their dorm (location)
* Add a telephone number
* Request communication information from another student's profile
* See all communication information requests
* Accept or decline communication information requests
* Make a request with the PO to leave the campus
* Store the PO permission to easily show security when returning to campus

### Board

* See all open boards (indoor and outdoor)
* Filter boards by dorm
* Create an outdoors board to accept outside tasks when you have permission from the PO
* Create an indoors board to accept indoor tasks
* Hide their boards to stop accepting more tasklist requests
* See posted tasklists
* Accept or reject posted tasklists
* Archive their boards
* Delete their boards
* Comment on a board

### Tasklist

* Create and save a tasklist to post or reuse later
* Edit created tasklists
* Post a tasklist to an open board
* Comment on tasklists posted to their boards
* Comment on tasklists they posted
* Delete their tasklists

## How Board works

Only AUB students can create accounts which they must do to start using Board.

Account creation asks for their email, a password, and the dorm they are in.

The app works by letting students create and post Boards which serve to show intent to accept other student tasks.

Students can create tasklists in their profile, these are essentially todo lists or grocery lists. They can be saved in case the student wants to reuse them later. Their tasks can then be added to open boards or listed on their on board. They can only add one tasklist per board.

Boards are shown on the home page and exist in 2 variants:

* outdoor boards, which can only be posted by students with PO (Protection Office) permission
* indoor boards that any student can post

A board has a title, an optional expected time the student will do the task, a description, and the list of requested tasklists. A student is only allowed to have 3 boards at a time to reduce spamming.

As a student receives task requests to their board, they can accept or decline them. They can also comment on a task asking for a modification or explaining why they declined it.
Once they no longer want to take on more tasks, they can lock the board, this hides it from the homepage, and only the owner and students with an accepted tasklist can continue interacting with the board.

Additionally, Board lets a student request permission to leave the campus directly from the app. The first time they do, they will be prompted for any extra information needed. This is assuming AUB has some sort of API that can issue authentication tokens. The reply email could then be stored in the app too so students have an easier time accessing it.

When a student completes a board, they can post a comment saying so and decide on a place to meet in dorms to exchange groceries. It is also possible to request more direct contact information from a student's profile.

## Technology Stack

* \[Database\] PostgreSQL
* \[Back-end\] PHP using the Laravel framework
* \[Front-end\] JS using the Vue JS framework
* \[Client hosting\] Netlify

The database is PostgreSQL because I've been seeing it a lot in job postings and most of the work I do has been with NoSQL databases and I want to learn more about relational databases.

Board will also serve as the final project for CMPS 278 - Web development, that's why the back-end must use PHP.

The front-end and the client hosting were chosen because I am already very familiar with them and there is not a lot of time for the project.

### Additional Services

Other services that I haven't decided on yet or don't know enough about.

* Server hosting
* Phone number confirmation (twilio ?)
* Email confirmation and notification (sendgrid, mailchimp, convertkit ?)
