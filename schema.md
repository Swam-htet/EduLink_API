<!-- database schema -->

## Schema

<!-- course table  -->

### Course table

-   id \* $
-   title \* $
-   code \* $
-   description \*
-   duration \*
-   status - active, inactive \*(admin) $
-   created_at \*
-   updated_at \*
-   deleted_at

<!-- Subject table  -->

### Subject table

-   id \* $
-   course_id $
-   title \* $
-   code \* $
-   description \*
-   credits \*
-   status - active, inactive \*(admin) $
-   created_at \*
-   updated_at \*
-   deleted_at

-   course(populate)

<!-- Staff table  -->

### Staff Table

-   id \* $
-   first_name \* $
-   last_name \*
-   email \* $
-   phone \* $
-   password
-   gender - male, female, other \* $
-   nrc \* $
-   profile_photo \*
-   date_of_birth \* $(date range)
-   address \* $
-   role - teacher, admin, staff \* $
-   joined_date \* $(date range)
-   status - - active, inactive \* $
-   qualifications \*
-   created_at \*
-   updated_at \*
-   deleted_at

<!-- student table -->

### Student Table

-   id \* $
-   student_id \* $
-   first_name \* $
-   last_name \*
-   email \* $
-   phone \* $
-   password \*
-   gender - male, female, other \* $
-   date_of_birth \* $(date range)
-   address \* $
-   enrollment_date \* $(date range)
-   status - pending, active, inactive, suspended, rejected \*(admin) $
-   guardian_name \*(admin) $
-   guardian_phone \*(admin) $
-   guardian_relationship \*(admin) $
-   nrc \*(admin) $
-   profile_photo \*
-   created_at \*
-   updated_at \*
-   deleted_at

<!-- class table -->

### Class Table

-   id \* $
-   name \* $
-   code \* $
-   course_id \* $
-   teacher_id \* $
-   capacity \* $
-   start_date \* $(date range)
-   end_date \* $(date range)
-   status - scheduled, ongoing, completed, cancelled \* $
-   description \*
-   created_at \*
-   updated_at \*
-   deleted_at

<!-- student class enrollment -->

### Student Class Enrollment Table

-   id \*
-   student_id
-   class_id
-   enrolled_at \*
-   status - enrolled, completed, failed \*
-   remarks \*
-   created_at \*
-   updated_at \*
-   deleted_at

-   student(populate)
-   class(populate)

<!-- class schedule -->

### Class Schedule

-   id
-   class_id
-   staff_id
-   date
-   start_time
-   end_time
-   late_mins
-   status - active, completed, cancelled
-   cancellation_reason
-   created_at
-   updated_at
-   deleted_at

<!-- attendance table -->

### Attendance Table

-   id
-   class_schedule_id
-   student_id
-   status - present, absent, late, excused
-   time_in
-   time_out
-   remarks
-   created_at
-   updated_at
-   deleted_at
