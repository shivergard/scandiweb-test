# Test app for Scandi Web

## Requirements

1) PHP 5.5.9+ (req for laravel)

2) SQLite (you can change project DB to another database, I just did not bother for this set up anything else)

3) Node.js, Gulp (installed globally)

## Installation

1) Clone repo

2) Copy .env.example to .env

3) run "composer install"

4) run "php artisan migrate" (and "php artisan db:seed" to seed some fake records)

5) "php artisan key:generate"

If something goes wrong with installation, these commands will help:

1) "php artisan key:generate" -- generates app key

2) "php artisan migrate" -- migrates tables

3) "php artisan db:seed" -- seeds inital records

4) "mpm install" -- installs javascript dependecies

5) "gulp" -- compiles javascript, sass and copies cat pictures

## Notes

1) I really did not bother with beautiful frontend validation, but you will be notified if input is invalid, and will not be able to submit anything.

2) Borrowed base code for paginator from: [React Paginator](https://github.com/dgoguerra/react-paginator) (MIT Licence).

3) Made parser that parses time like Log Work in Jira. You can type 1 month or 2w, or just number that defaults to minutes. 

And you can combine time units: 1 month 2days 3 minutes.

4) I am probably the last person you would choose to design site for you.