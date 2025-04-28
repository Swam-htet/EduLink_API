-- login to mysql
mysql -u root -p

-- hash value for Password$123S
-- $2y$12$49vaeAaUmFdhsI2cz4ITc.rz5KDWKyyokcje1U2WWFFGB.J/CqXnu

use central_edulink;

-- tenent seeder to central database
-- University of Greenwich
INSERT INTO tenants (name, domain, database_name, created_at, updated_at) VALUES
('Yangon International School', 'yis_edulink', 'yis_edulink', NOW(), NOW());


-- use tenant database
USE yis_edulink;


-- Add 5 staff members (3 teachers and 2 staff)
INSERT INTO staff (first_name, last_name, email, password, phone, gender, date_of_birth, address, role, nrc, profile_photo, joined_date, status, qualifications, created_at, updated_at) VALUES
-- Teachers
('U', 'Aung Min', 'aung.min@example.com', '$2y$12$wxmsI28PwyGzO4P3SivhbuWk3yqWliWHPxAbtQeopghbjBZWM2.ya', '+959123456789', 'male', '1985-05-15', '123 Main St, Yangon', 'teacher', '12/ABC(N)123456', 'https://i.pravatar.cc/150?img=1', '2024-01-15', 'active', '{"degree": "M.Ed", "subject": "Mathematics", "experience": "10 years"}', NOW(), NOW()),

('Daw', 'Hnin Yu', 'hnin.yu@example.com', '$2y$12$wxmsI28PwyGzO4P3SivhbuWk3yqWliWHPxAbtQeopghbjBZWM2.ya', '+959123456790', 'female', '1988-08-20', '456 Oak St, Yangon', 'teacher', '12/DEF(N)123457', 'https://i.pravatar.cc/150?img=2', '2024-01-15', 'active', '{"degree": "B.Ed", "subject": "English", "experience": "8 years"}', NOW(), NOW()),

('U', 'Kyaw Zaw', 'kyaw.zaw@example.com', '$2y$12$wxmsI28PwyGzO4P3SivhbuWk3yqWliWHPxAbtQeopghbjBZWM2.ya', '+959123456791', 'male', '1983-03-10', '789 Pine St, Yangon', 'teacher', '12/GHI(N)123458', 'https://i.pravatar.cc/150?img=3', '2024-01-15', 'active', '{"degree": "M.Sc", "subject": "Physics", "experience": "12 years"}', NOW(), NOW()),

-- Staff
('Daw', 'Su Su', 'su.su@example.com', '$2y$12$wxmsI28PwyGzO4P3SivhbuWk3yqWliWHPxAbtQeopghbjBZWM2.ya', '+959123456792', 'female', '1990-11-25', '321 Elm St, Yangon', 'staff', '12/JKL(N)123459', 'https://i.pravatar.cc/150?img=4', '2024-01-15', 'active', '{"position": "Administrative Assistant", "department": "Office"}', NOW(), NOW()),

('U', 'Myo Min', 'myo.min@example.com', '$2y$12$wxmsI28PwyGzO4P3SivhbuWk3yqWliWHPxAbtQeopghbjBZWM2.ya', '+959123456793', 'male', '1987-07-30', '654 Maple St, Yangon', 'staff', '12/MNO(N)123460', 'https://i.pravatar.cc/150?img=5', '2024-01-15', 'active', '{"position": "IT Support", "department": "Technology"}', NOW(), NOW());


-- add new student
INSERT INTO `students`
(`id`, `student_id`, `first_name`, `last_name`, `email`, `phone`, `password`, `gender`, `date_of_birth`, `address`, `enrollment_date`, `status`, `guardian_name`, `guardian_phone`, `guardian_relationship`, `nrc`, `profile_photo`, `created_at`, `updated_at`)
VALUES
(NULL, '1234567890', 'Student', 'One', 'student.one@example.com', '09123456789', '$2y$12$49vaeAaUmFdhsI2cz4ITc.rz5KDWKyyokcje1U2WWFFGB.J/CqXnu', 'male', '2025-04-22', 'Yangon', '2025-04-22', 'active', 'Student One', '09123456789', 'Father', '1234567890', NULL, '2025-04-22 10:00:00', '2025-04-22 10:00:00'),
(NULL, '1234567891', 'Student', 'Two', 'student.two@example.com', '09123456789', '$2y$12$49vaeAaUmFdhsI2cz4ITc.rz5KDWKyyokcje1U2WWFFGB.J/CqXnu', 'male', '2025-04-22', 'Yangon', '2025-04-22', 'active', 'Student Two', '09123456789', 'Father', '1234567890', NULL, '2025-04-22 10:00:00', '2025-04-22 10:00:00'),
(NULL, '1234567892', 'Student', 'Three', 'student.three@example.com', '09123456789', '$2y$12$49vaeAaUmFdhsI2cz4ITc.rz5KDWKyyokcje1U2WWFFGB.J/CqXnu', 'male', '2025-04-22', 'Yangon', '2025-04-22', 'active', 'Student Three', '09123456789', 'Father', '1234567890', NULL, '2025-04-22 10:00:00', '2025-04-22 10:00:00'),
(NULL, '1234567893', 'Student', 'Four', 'student.four@example.com', '09123456789', '$2y$12$49vaeAaUmFdhsI2cz4ITc.rz5KDWKyyokcje1U2WWFFGB.J/CqXnu', 'male', '2025-04-22', 'Yangon', '2025-04-22', 'active', 'Student Four', '09123456789', 'Father', '1234567890', NULL, '2025-04-22 10:00:00', '2025-04-22 10:00:00'),
(NULL, '1234567894', 'Student', 'Five', 'student.five@example.com', '09123456789', '$2y$12$49vaeAaUmFdhsI2cz4ITc.rz5KDWKyyokcje1U2WWFFGB.J/CqXnu', 'male', '2025-04-22', 'Yangon', '2025-04-22', 'active', 'Student Five', '09123456789', 'Father', '1234567890', NULL, '2025-04-22 10:00:00', '2025-04-22 10:00:00');

-- add new course
INSERT INTO `courses`
(`id`, `title`, `code`, `description`, `duration`, `created_at`, `updated_at`)
VALUES
(NULL, 'Level 1', 'LEVEL1', 'Level 1 Course', 10, '2025-04-22 10:00:00', '2025-04-22 10:00:00'),
(NULL, 'Level 2', 'LEVEL2', 'Level 2 Course', 10, '2025-04-22 10:00:00', '2025-04-22 10:00:00'),
(NULL, 'Level 3', 'LEVEL3', 'Level 3 Course', 10, '2025-04-22 10:00:00', '2025-04-22 10:00:00'),
(NULL, 'Level 4', 'LEVEL4', 'Level 4 Course', 10, '2025-04-22 10:00:00', '2025-04-22 10:00:00'),
(NULL, 'Level 5', 'LEVEL5', 'Level 5 Course', 10, '2025-04-22 10:00:00', '2025-04-22 10:00:00'),
(NULL, 'Level 6', 'LEVEL6', 'Level 6 Course', 10, '2025-04-22 10:00:00', '2025-04-22 10:00:00'),
(NULL, 'Level 7', 'LEVEL7', 'Level 7 Course', 10, '2025-04-22 10:00:00', '2025-04-22 10:00:00'),
(NULL, 'Level 8', 'LEVEL8', 'Level 8 Course', 10, '2025-04-22 10:00:00', '2025-04-22 10:00:00'),
(NULL, 'Level 9', 'LEVEL9', 'Level 9 Course', 10, '2025-04-22 10:00:00', '2025-04-22 10:00:00'),
(NULL, 'Level 10', 'LEVEL10', 'Level 10 Course', 10, '2025-04-22 10:00:00', '2025-04-22 10:00:00');


-- subject
INSERT INTO `subjects`
(`id`, `course_id`, `title`, `code`, `description`, `credits`, `created_at`, `updated_at`)
VALUES
(NULL, 1, 'Math', 'MATH101', 'Math Course', 2, '2025-04-22 10:00:00', '2025-04-22 10:00:00'),
(NULL, 1, 'English', 'ENGL101', 'English Course', 2, '2025-04-22 10:00:00', '2025-04-22 10:00:00'),
(NULL, 1, 'Science', 'SCI101', 'Science Course', 2, '2025-04-22 10:00:00', '2025-04-22 10:00:00'),
(NULL, 1, 'Social Studies', 'SOCS101', 'Social Studies Course', 2, '2025-04-22 10:00:00', '2025-04-22 10:00:00'),
(NULL, 1, 'History', 'HIST101', 'History Course', 2, '2025-04-22 10:00:00', '2025-04-22 10:00:00'),
(NULL, 1, 'Geography', 'GEOG101', 'Geography Course', 2, '2025-04-22 10:00:00', '2025-04-22 10:00:00'),
(NULL, 1, 'Biology', 'BIO101', 'Biology Course', 2, '2025-04-22 10:00:00', '2025-04-22 10:00:00');

-- class
INSERT INTO `classes`
(`id`, `name`, `code`, `course_id`, `teacher_id`, `capacity`, `start_date`, `end_date`, `status`, `description`, `created_at`, `updated_at`)
VALUES
(NULL, 'Class 1', 'CLASS1', 1, 1, 30, '2025-04-22', '2025-04-22', 'scheduled', 'Class 1 Description', '2025-04-22 10:00:00', '2025-04-22 10:00:00'),
(NULL, 'Class 2', 'CLASS2', 2, 1, 30, '2025-04-22', '2025-04-22', 'scheduled', 'Class 2 Description', '2025-04-22 10:00:00', '2025-04-22 10:00:00'),
(NULL, 'Class 3', 'CLASS3', 3, 1, 30, '2025-04-22', '2025-04-22', 'scheduled', 'Class 3 Description', '2025-04-22 10:00:00', '2025-04-22 10:00:00'),
(NULL, 'Class 4', 'CLASS4', 4, 1, 30, '2025-04-22', '2025-04-22', 'scheduled', 'Class 4 Description', '2025-04-22 10:00:00', '2025-04-22 10:00:00'),
(NULL, 'Class 5', 'CLASS5', 5, 1, 30, '2025-04-22', '2025-04-22', 'scheduled', 'Class 5 Description', '2025-04-22 10:00:00', '2025-04-22 10:00:00');


-- class schedule
INSERT INTO `class_schedules`
(`id`, `class_id`, `staff_id`, `subject_id`, `date`, `start_time`, `end_time`, `late_mins`, `status`, `cancellation_reason`, `created_at`, `updated_at`)
VALUES
(NULL, 1, 1, 1, '2025-05-20', '10:00:00', '11:00:00', 0, 'active', NULL, '2025-05-22 10:00:00', '2025-05-22 10:00:00'),
(NULL, 1, 1, 1, '2025-05-21', '10:00:00', '11:00:00', 0, 'active', NULL, '2025-05-22 10:00:00', '2025-05-22 10:00:00'),
(NULL, 1, 1, 1, '2025-05-22', '10:00:00', '11:00:00', 0, 'active', NULL, '2025-05-22 10:00:00', '2025-05-22 10:00:00'),
(NULL, 1, 1, 1, '2025-05-23', '10:00:00', '11:00:00', 0, 'active', NULL, '2025-05-22 10:00:00', '2025-05-22 10:00:00'),
(NULL, 1, 1, 2, '2025-05-20', '10:00:00', '11:00:00', 0, 'active', NULL, '2025-05-22 10:00:00', '2025-05-22 10:00:00'),
(NULL, 1, 1, 2, '2025-05-21', '10:00:00', '11:00:00', 0, 'active', NULL, '2025-05-22 10:00:00', '2025-05-22 10:00:00'),
(NULL, 1, 1, 2, '2025-05-22', '10:00:00', '11:00:00', 0, 'active', NULL, '2025-05-22 10:00:00', '2025-05-22 10:00:00'),
(NULL, 1, 1, 2, '2025-05-23', '10:00:00', '11:00:00', 0, 'active', NULL, '2025-05-22 10:00:00', '2025-05-22 10:00:00');


-- Landing Page Configuration Data
INSERT INTO tenant_configs (`key`, `value`, `type`, `group`, `description`, `is_system`, `created_at`, `updated_at`) VALUES
-- Hero Section
(
    'hero',
    '{
        "title": "Welcome to Yangon International School",
        "subtitle": "Empowering minds, shaping futures through quality education and innovation",
        "image": "https://images.unsplash.com/photo-1505852679233-d9fd70aff56d?q=80&w=3540&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
    }',
    'json',
    'landing',
    'Hero section configuration',
    true,
    NOW(),
    NOW()
),

-- Features Section
(
    'features',
    '[
        {
            "icon": "GraduationCap",
            "title": "Academic Excellence",
            "description": "Comprehensive curriculum aligned with international standards for grades K-12"
        },
        {
            "icon": "Users",
            "title": "Expert Faculty",
            "description": "Experienced teachers dedicated to nurturing student growth and development"
        },
        {
            "icon": "Palette",
            "title": "Arts & Culture",
            "description": "Rich programs in music, visual arts, drama, and cultural activities"
        },
        {
            "icon": "Trophy",
            "title": "Sports Programs",
            "description": "Diverse athletic programs fostering teamwork and physical development"
        },
        {
            "icon": "Globe",
            "title": "Global Perspective",
            "description": "International curriculum preparing students for global opportunities"
        },
        {
            "icon": "Laptop",
            "title": "Digital Learning",
            "description": "Modern technology integration with personalized learning platforms"
        }
    ]',
    'json',
    'landing',
    'Features section configuration',
    true,
    NOW(),
    NOW()
),

-- Statistics Section
(
    'statistics',
    '[
        {
            "icon": "Users",
            "value": 1200,
            "label": "Students Enrolled"
        },
        {
            "icon": "GraduationCap",
            "value": 98,
            "label": "Graduation Rate"
        },
        {
            "icon": "BookOpen",
            "value": 45,
            "label": "Programs Offered"
        },
        {
            "icon": "Award",
            "value": 25,
            "label": "Years of Excellence"
        }
    ]',
    'json',
    'landing',
    'Statistics section configuration',
    true,
    NOW(),
    NOW()
),

-- Testimonials Section
(
    'testimonials',
    '[
        {
            "id": "1",
            "name": "Dr. Aung Min",
            "role": "Parent",
            "organization": "Grade 11 Student",
            "content": "The school\'s commitment to academic excellence and character development has tremendously benefited my child. The teachers are exceptional and truly care about each student\'s success.",
            "image": "https://i.pravatar.cc/150?img=11"
        },
        {
            "id": "2",
            "name": "Ma Hnin Yu",
            "role": "Parent",
            "organization": "Grade 8 & Grade 5 Students",
            "content": "Both my children have flourished here. The balance between academics, arts, and sports is perfect, and the international environment has broadened their perspectives.",
            "image": "https://i.pravatar.cc/150?img=12"
        },
        {
            "id": "3",
            "name": "U Kyaw Zaw",
            "role": "Parent & School Board Member",
            "organization": "Grade 10 Student",
            "content": "The school\'s use of technology and modern teaching methods, combined with traditional values, creates an ideal learning environment for our children.",
            "image": "https://i.pravatar.cc/150?img=13"
        }
    ]',
    'json',
    'landing',
    'Testimonials section configuration',
    true,
    NOW(),
    NOW()
),

-- FAQs Section
(
    'faqs',
    '[
        {
            "question": "What curriculum does the school follow?",
            "answer": "We follow an international curriculum combining the best practices from IB and Cambridge frameworks, adapted to meet local educational requirements."
        },
        {
            "question": "What are the class sizes?",
            "answer": "Our average class size is 20 students, ensuring personalized attention and optimal learning conditions."
        },
        {
            "question": "What extracurricular activities are available?",
            "answer": "We offer a wide range of activities including sports, arts, music, debate club, robotics, and various academic clubs."
        },
        {
            "question": "How does the school support university applications?",
            "answer": "Our dedicated college counseling team provides comprehensive support for university applications, including SAT prep, essay writing, and application guidance."
        }
    ]',
    'json',
    'landing',
    'FAQs section configuration',
    true,
    NOW(),
    NOW()
),

-- Contact Information
(
    'contact',
    '{
        "address": "123 Education Street, Bahan Township, Yangon, Myanmar",
        "email": "admissions@yis.edu.mm",
        "phone": "+95 1 234 5678",
        "mapUrl": "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3819.146507899749!2d96.15187007495558!3d16.82884208391365!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30c1eb5e3fffe455%3A0x673b46db7e42c0e!2sBahan%20Township%2C%20Yangon!5e0!3m2!1sen!2smm!4v1709641547744!5m2!1sen!2smm"
    }',
    'json',
    'landing',
    'Contact information configuration',
    true,
    NOW(),
    NOW()
),

-- Branding
(
    'branding',
    '{
        "primaryColor": "#000000",
        "secondaryColor": "#000000",
        "logo": "https://img.icons8.com/color/96/000000/school.png"
    }',
    'json',
    'landing',
    'Branding configuration',
    true,
    NOW(),
    NOW()
),

-- Programs
(
    'programs',
    '[
        {
            "name": "Primary School",
            "grades": "Kindergarten - Grade 5",
            "description": "Foundation years focusing on core skills and creative development",
            "features": ["Phonics & Early Reading", "Mathematics", "Science Discovery", "Arts & Crafts"]
        },
        {
            "name": "Middle School",
            "grades": "Grades 6-8",
            "description": "Transitional years developing academic and personal skills",
            "features": ["Advanced Mathematics", "Sciences", "Languages", "Digital Skills"]
        },
        {
            "name": "High School",
            "grades": "Grades 9-12",
            "description": "College preparatory program with diverse subject choices",
            "features": ["IB Curriculum", "AP Courses", "College Counseling", "Leadership Programs"]
        }
    ]',
    'json',
    'landing',
    'Programs section configuration',
    true,
    NOW(),
    NOW()
),

-- Facilities
(
    'facilities',
    '[
        {
            "name": "Science Labs",
            "description": "Modern laboratories for physics, chemistry, and biology",
            "image": "https://images.unsplash.com/photo-1505852679233-d9fd70aff56d?q=80&w=3540&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
        },
        {
            "name": "Library & Media Center",
            "description": "Extensive collection of books and digital resources",
            "image": "https://images.unsplash.com/photo-1505852679233-d9fd70aff56d?q=80&w=3540&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
        },
        {
            "name": "Sports Complex",
            "description": "Indoor and outdoor facilities for various sports",
            "image": "https://images.unsplash.com/photo-1505852679233-d9fd70aff56d?q=80&w=3540&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
        }
    ]',
    'json',
    'landing',
    'Facilities section configuration',
    true,
    NOW(),
    NOW()
);