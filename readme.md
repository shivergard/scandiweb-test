# Test app for Scandi Web

## Requirements

1) PHP 5.5.9+ (req for laravel)

2) SQLite (you can change project DB to another database, I just did not bother for this set up anything else)

3) Node.js, Gulp (installed globally)

## Installation

1) Clone repo

1) run "composer install"

4) run "php vendor/bin/phinx  migrate -e development"

## Notes

1) I really did not bother with beautiful frontend validation, but you will be notified if input is invalid, and will not be able to submit anything.

2) Borrowed base code for paginator from: [React Paginator](https://github.com/dgoguerra/react-paginator) (MIT Licence).

3) Made parser that parses time like Log Work in Jira. You can type 1 month or 2w, or just number that defaults to minutes. 

And you can combine time units: 1 month 2days 3 minutes.

4) I am probably the last person you would choose to design site for you.


## Notes on backed "framework" part

For test I created "micro framework" with limited features somewhat inspired by laravel/lumen-framework, silexphp/Silex.
All "framework" part is located in "framework" dir, I did not extract it to separate package.

Features include:

1) Routing with GET/POST routes (Framework class, wrapped nikic/fast-route)

2) Dependency Injection (Framework class, wrapped php-di/php-di)

3) Middlewares (Middleware class, my implementation)

4) Controllers (Controller class, my implementation)

5) Paginator (ArrayPaginator class, wrapped illuminate/pagination)

6) Responses (Response class, wrapped Symfony Response Classes)

7) Views (View class, wrapped twig/twig)

8) Eloquent ORM (Framework class, wrapped illuminate/database)

9) Migrations (robmorgan/phinx package)

What I skipped:

1) Basically everything on "framework part" that is out of scope of this task

2) Single style of exception handling

3) Configuration, all parameters are suited for demoing task, that's all

4) Left develop dependecies in