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
-   course_id \* $ -> course
-   teacher_id \* $ -> staff
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
-   student_id -> student
-   class_id -> class
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
-   class_id -> class
-   staff_id -> staff(tutor)
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
-   class_schedule_id -> class schedule
-   student_id -> student
-   status - present, absent, late, excused
-   time_in
-   time_out
-   remarks
-   created_at
-   updated_at
-   deleted_at

<!-- exam system -->

### Exam Table

-   id \*
-   class_id -> class
-   subject_id -> subject
-   title \*
-   description
-   total_marks \*
-   pass_marks \*
-   duration \* (in minutes)
-   start_date \*
-   end_date \*
-   status - draft, published, ongoing, completed, cancelled \*(admin)
-   created_at \*
-   updated_at \*
-   deleted_at

### Exam Questions Table

-   id \*
-   exam_id -> exam
-   question \*
-   type - multiple_choice, true_false, fill_in_blank, short_answer, long_answer, matching, ordering \*(admin)
-   marks \*
-   explanation
-   answer_guidelines (for manual grading)
-   requires_manual_grading - true, false \*
-   allow_partial_marks - true, false \*
-   difficulty_level - 1,2,3,4,5 \*
-   time_limit (in minutes)
-   created_at \*
-   updated_at \*
-   deleted_at

JSON Structures for different question types:

```json
// Multiple Choice Question
{
    "options": [
        {
            "id": "a",
            "text": "Option text",
            "image_url": "optional/path/to/image.jpg"
        }
    ],
    "correct_answer": "a",
    "marking_scheme": {
        "correct": 2,
        "incorrect": 0
    }
}

// True/False Question
{
    "options": [
        {"id": "true", "text": "True"},
        {"id": "false", "text": "False"}
    ],
    "correct_answer": "true",
    "marking_scheme": {
        "correct": 1,
        "incorrect": 0
    }
}

// Fill in the Blanks
{
    "blank_answers": [
        {
            "id": 1,
            "acceptable_answers": ["answer1", "answer 1"],
            "case_sensitive": false
        }
    ],
    "marking_scheme": {
        "per_blank": 1
    }
}

// Matching Question
{
    "matching_pairs": {
        "questions": [
            {
                "id": "q1",
                "text": "Question text"
            }
        ],
        "answers": [
            {
                "id": "a1",
                "text": "Answer text"
            }
        ],
        "correct_pairs": {
            "q1": "a1"
        }
    },
    "marking_scheme": {
        "per_correct_pair": 1
    }
}

// Ordering Question
{
    "options": [
        {
            "id": "1",
            "text": "Item text"
        }
    ],
    "correct_order": ["1", "2", "3"],
    "marking_scheme": {
        "perfect_order": 2,
        "partial_correct": 1
    }
}
```

### Student Exam Responses Table

-   id \*
-   exam_id -> exam
-   student_id -> student
-   question_id -> exam_questions
-   selected_choice (for multiple choice/true false)
-   written_answer (for text-based answers)
-   matching_answers (JSON)
-   ordering_answer (JSON)
-   fill_in_blank_answers (JSON)
-   is_correct
-   marks_obtained \*
-   needs_grading \*
-   grading_comments
-   graded_by -> staff
-   graded_at
-   started_at \*
-   answered_at \*
-   time_taken \* (in seconds)
-   created_at \*
-   updated_at \*
-   deleted_at

JSON Structures for responses:

```json
// Multiple Choice/True False Response
{
    "selected_choice": "a",
    "time_taken": 45
}

// Fill in Blanks Response
{
    "fill_in_blank_answers": {
        "1": "student answer"
    }
}

// Matching Response
{
    "matching_answers": {
        "q1": "a1"
    }
}

// Ordering Response
{
    "ordering_answer": ["1", "2", "3"]
}

// Essay/Long Answer Grading
{
    "grading_details": {
        "content_score": 8,
        "structure_score": 7,
        "total_score": 15,
        "comments": "Grading comments here"
    }
}
```

### Exam Results Table

-   id \*
-   exam_id -> exam
-   student_id -> student
-   total_marks_obtained \*
-   total_questions \*
-   correct_answers \*
-   wrong_answers \*
-   percentage \*
-   status - pass, fail \*
-   started_at \*
-   completed_at \*
-   created_at \*
-   updated_at \*
-   deleted_at
