# Job Back office application

## About me

-   This is my first MVC application in laravel.
-   I will implement all what i have learned so far in php.
-   I will try to focus on the backend work more so i will not use any frontend frameworks only html with blade and some tailwind css.

## Description

-   Job-backoffice web client to manage job vacancy posts and job applications and see all the analytics to view applicants.
-   It will be accessible for Company Owners and admins only.
-   Job seeker will be able to apply for jobs on the job-app not in job-backoffice.

## Tech Stack

-   Laravel
-   MySQL (mariaDB)
-   Tailwind CSS

## what did I do so far

Made a navigation system for the admins and the company owner
And built a Role middleware to validate owner based access control "OBAC"

The Admin has access to: (can see all companies related data)

-   Dashboard
-   job applications
-   job vacancies
-   companies
-   job categories
-   users

The company owner has access to: (can see only his company related data)

-   Dashboard
-   job applications
-   job vacancies
-   my company

All the data are fake data made with seeded to test the users with all relations to the database
