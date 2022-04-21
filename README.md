# EasyPractice Technical Challenge

Welcome to the EasyPractice tech challenge! Below you'll find a list of tasks to complete on this project. Make sure you're familiar with Git, Laravel and Vue.js before starting. This challenge should take no more than 3 hours.

## Note from Mihai

Because the tasks were short and then time was 3 hours I took the liberty to rewrite the whole project using Laravel 9/PHP 8 and also turn the Laravel into a cookie based authentication api with Laravel Sanctum consumed by a VUE SPA. Due to this, some of the conditions from below changed and I will add my points to the steps for installing the project. For each task I will write below if it's completed or not as well as adding some insight into the modifications if it applies. Everything was done in about 3-3.5 hours including the rewriting.

### About the app
REQUIREMENTS:
- LARAVEL 9
- PHP 8+

You will notice that the controllers and models are skinny. The controllers only take care of receiving the data and passing it to a service that holds the logic then the controller will return a nice json of the result.
To take care of the logic I have created a service class that acts as a layer between controllers and models `ClientService.php`. This service is injected in the controller methods that will make use of it.
I have also added a `renderable` in app > Exceptions > Handler.php in the `register` method to reformat the error messages returned to the user so they don't include technical data using the `RespondsWithHttpStatus` trait. This trait also uses another trait called `LogsToDebug` which will only log errors to a .debug file located in the storage > logs folders. This is purely used for debugging purposes but it's something that I like to use alongside testing. 


## Working on the challenge

1. Clone the repo
2. Copy `.env.example` to `.env`
3. Update the `.env` file to include the correct database connection details
4. Update the `.env` file `SESSION_DRIVER` from `file` to `cookie`
5. Run `composer install`, `php artisan key:generate`, `php artisan migrate`, `npm install` and `npm run dev` (ignore the build warnings)
6. (OPTIONAL) Running `php artisan db:seed` will add clients and bookings to the database, it will also add a user if there are none
7. Finally you should do `php artisan config:cache`, `php artisan route:cache` and `php artisan view:cache` to rebuild the caches.
7. Open up the project in the browser and click on "Register" to create a new user. All the work will be done while logged in.
8. Code indentation should be set up at 4 spaces in both PHP and JS files.
9. Work through the tasks in a new branch named `challenge/{your-name}`. Commit as often as you like.
10. Once you have completed the tasks, create a new [Pull Request](https://docs.github.com/en/github/collaborating-with-pull-requests/proposing-changes-to-your-work-with-pull-requests/creating-a-pull-request) and send us the link to it.

## The tasks

Complete as many as you can. If you got some time left, there's BONUS tasks, but they're not required ;)

**Solve this first:**
- [ ] (BUG) I created some seeders that you can run with `php artisan db:seed`, but it gives an error. Can you make it work?
- Fixed

**And these in any order:**
- [ ] (BUG) For some reason, the client bookings are not showing up in the front-end. Can you fix that?
- Fixed
- [ ] (BUG) The list of bookings displayed on a client page has unformatted dates. Can you make sure they look something like this: `Monday 19 January 2020, 14:00 to 15:00`
- Fixed
- [ ] (FEATURE) Currently, any logged-in user can view all of the system's clients, including those created by other users. Users are obviously not happy with that. Can you make it so that a single Client only belongs to one User?
- Added
- Notes: To achieve this I have created a new trait called `MultiTenantable.php` found in app > traits and added this trait to the Client model. This way the queries will always return the clients that belong to the respective user.
- [ ] (BUG) When trying to delete a client, the front-end does not update. Can you improve the experience, so the user knows the client was actually deleted? (tip: use `php artisan db:seed --class=ClientSeeder` to generate some clients if you have none)
- Fixed
- Notes: I added vuetoaster for the frontend message reporting while in the backend I made a trait called `RespondsWithHttpStatus` that's used by the controller to return nice json that the frontend can use.
- [ ] (FEATURE) We noticed users started entering random data when creating clients. We should include some validation. Make sure that, when creating a client:
  - The `name` is up to 190 characters and it's required
  - The `email` is an actual valid email address. Hint: "arunas@example" is NOT a valid email address in our case.
  - The `phone` can only contain digits, spaces and a plus sign
  - At least one of (phone/email) is required
- Added
- Notes: The validation is only done in the backend (allthough ideally it would be both front and back) through Laravel Request classes that can be found in app > requests. The validation for the client can be found in `ClientRequest.php` which is injected in the client controller methods. I used this approach because this way the validation will be done before the request reacheas the controller and we won't have to bloat the controller even more with validation data.
- [ ] (FEATURE) The client bookings are currently displayed in random order. Please display them in chronological order, newest first.
- Added
- [ ] (FEATURE) Users want a quick way to see future and past bookings. When viewing client bookings, can you make a dropdown with three values - "All bookings", "Future bookings only" and "Past bookings only". Make it so that selecting an item from the dropdown would only show bookings that apply to the selected filter. When the page loads, default to "All bookings".
- Added

**BONUS TASKS!**
- [ ] *BONUS:* (FEATURE) Users have requested the ability to write journals for their clients. A Journal should have a date field (without hours/minutes) and a text field (unlimited length). A client can have many journals. A user should be able to view, create and delete journals.
- Added
- [ ] *BONUS:* (REFACTOR) We strive for fast and readable code that follows Laravel's/Vue.js style and best practices. Take the time remaining and refactor any code you think can be improved, including ours. The goal is to leave the code better than you found it ;)
- As I said in the begining because the timeframe was looking good I decided to rewrite the entire project based on how I would usually do it and decided to add the Sanctum auth to create a vuejs SPA.

## Thank You!

Thank you so much for participating in this tech challenge. Hope you had fun! If you have any questions or suggestions, please email us at karolis@mangoapps.dk
