# aoe2-demo
A little Laravel/Vue app for editing AoE2 civilization lists

author: [Tom LaMarre](https://github.com/tlamarre91)

url: [aoe2-demo.herokuapp.com](https://aoe2-demo.herokuapp.com/)

This app is designed to run locally (with `php artisan serve`) or be deployed to Heroku. Currently, a GitHub webhook is used to automatically deploy any changes committed to this repository's [heroku-deploy](https://github.com/tlamarre91/aoe2-demo/tree/heroku-deploy) branch to the Heroku app running at [aoe2-demo.herokuapp.com](https://aoe2-demo.herokuapp.com/).

The backend is a Laravel application which expects a PostgreSQL database to be running on the same host. The backend features an API for CRUD operations on a collection of resources which happen to be text summaries of civilizations from Age of Empires 2, sharing a model with the list provided by [age-of-empires-2-api.herokuapp.com/api/v1/civilizations](https://age-of-empires-2-api.herokuapp.com/api/v1/civilizations).

The frontend is a Vue app providing a UI for interacting with the backend, with components for:
* Displaying the currently stored list of civilizations
* Adding new civilizations to the list
* Updating civilizations
* Deleting civilizations
* Reinitializing the list to mirror [age-of-empires-2-api.herokuapp.com/api/v1/civilizations](https://age-of-empires-2-api.herokuapp.com/api/v1/civilizations)

## Notes
* Before running locally, make sure PostgreSQL is running, with a database called "aoe2". After database is created, run `php artisan migrate:fresh` (and optionally `php artisan db:seed --class=CivilizationSeeder`) to set up the database schema.
* Also before running locally, build the frontend with `npm run dev` (or continuously rebuild changes with `npm run watch`, or for production run `npm run prod`).
