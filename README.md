# Project Documentation

This is a simple documentation of my project, developed to transform manual school systems into a web-based system.

## Introduction

By no means is this project perfect, but it fulfills many requirements of schools.
## Download 

You can download the project from the GitHub repository using the git clone command. Here's how
1. Open your terminal or command prompt.
2. Navigate to the directory where you want to clone the repository.
3. Run the following command:
```
git clone https://github.com/Saboor-Hamedi/student-management-system.git
```

## Install Composer

. If you haven't already installed Composer, you can download and install it from getcomposer.org.
. Follow the installation instructions for your operating system.

### Create composer.json:

. In your project directory, create a file named composer.json if you don't already have one.

#### Add Autoload Configuration:

. Inside composer.json, add the following lines to configure autoloading with PSR-4:

```
  {
    "autoload": {
      "psr-4": {
        "Thesis\\": "App/"
      }
    }
  }
```
# Project Details

This project is built using PHP and MariaDB as its database to store data. Object-oriented programming (OOP) concepts have been utilized to reduce redundancy and enhance functionality.

## Rules

### Authentication

The project includes a clean `Auth` class responsible for controlling authenticated users. Currently, there are four different user types in the database: admin, teachers, students, and parents. They are denoted as follows:

- admin: 0
- student: 1
- teachers: 2
- parents: 3

You can add additional user types as needed.

#### Authenticating Users

To control access to certain pages based on user roles, follow these steps:

1. Visit `config/Auth.php` for more details.
2. Inside the page you want to restrict access to, e.g., `admin.php`, call `Auth::authenticate([0])` at the top of the page.
3. To allow access for multiple user roles, include their roles in the `authenticate` method, e.g., `Auth::authenticate([0,1,2,3])`.

