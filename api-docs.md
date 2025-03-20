## API docs

### Auth API

-   student login
-   student logout
-   student get profile
-   forget password - request token with email
-   reset password - token and password
-   change password - change password with OTP

-   staff login
-   staff logout
-   staff get profile
-   staff password reset - management
-   staff password change - staff by token

<!-- course api -->

### Course API

-   course list - management
-   course detail -management
-   course create - management
-   course update - management
-   course delete - management

-   active course list - student
-   active course detail - student

<!-- subject api -->

### Subject API

-   subject list - management
-   subject detail - management
-   subject create - management
-   subject update - management

<!-- class api -->

### Class API

-   class list - management
-   class detail - management
-   class create - management
-   class update - management

<!-- staff api -->

### Staff API

-   staff list - management
-   staff detail - management
-   staff info update - management
-   staff status update - management

<!-- student api -->

### Student API

-   student list - management
-   student detail - management
-   student info update - management
-   student registration approve - management
-   student registration reject - management
-   student status update - management

-   student profile update - student

<!-- class enrollment -->

### Enrollment API

-   enroll student to class - management (todo : multiple student)
-   confirm class enrollment by student - student
-   class enrollment list - management
-   check class enrollment detail - management
-   update class enrollment - management

-   class enrollment list for single student - student

<!-- class schedule api -->

### Class Schedule API

-   create class schedule - management (todo : multiple schedule )
-   check all class schedule - management
-   check class schedule detail - management
-   update class schedule info(status) - management

-   class schedule list for single student with class id and subject id - student
-   class schedule detail - student

<!-- attendance api -->

-   make attendance by student - student
-   make manual attendance for single student by staff - management (todo : multi student)
-   check all the attendance list - management
-   check the attendance list for student by class id and subject id

-   sending email to student's parent for monthly attendance record - management for single student (todo : multi student)
