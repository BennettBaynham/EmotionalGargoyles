Welcome to The Emotional Gargoyles' "Math Games" software!

Sample Teacher login: 
username: hermione
password: pwis123

Sample Student login:
username: Ron
password: ron2012forever


>FOR TEACHERS:
    Thank you for choosing our software!

   >On the login page, you can click "create new user" to make an account, then select either
    student or teacher.  Your students will be linked to you so that you can check their progress,
    so when students are creating their accounts they will have to enter the teacher id (username)
    that you chose when registering.

   >From your main menu screen, you will be able to select and play any of the math games, look 
    at the basic lessons we have included for students, logout, and view your profile (from which
    you can lock game difficulty as well as check up on your students' scores on the various
    games and difficulties.)

>FOR PROGRAMMERS:
    Welcome again! Here I will briefly describe the organization of the software.

   >For starters, all pages check if the user is logged in and if not redirects them to the login
    screen.  

   >From the login screen, you can create a user (adding the user info to user.json) or login.  
    When the user logs in, they are sent to menu_redirector.php, which checks whether the user is 
    a student or a teacher then sends them to the appropriate main menu.  Students are linked to
    their teacher so that the teacher can view their progress.

   >From the main menu (student_menu.php or teacher_menu.php), there are links to various other pages.  
    Logout requires the user to log back in before accessing the software.

   >Each of the games has several difficulties which can be selected within the game or set by the 
    teacher.  Each game keeps track of difficulty, the number of correct answers, and the number 
    of incorrect answers.

   >Any time a user is sent to the main menu, they go to the menu redirector so that they can be sent
    to the appropriate menu.