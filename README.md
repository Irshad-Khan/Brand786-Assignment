# Running Application
- git clone from repo
- goto project folder install composer
- run command php artisan jwt:secret it will add secret key in .env file
- run command php artisan migrate --seed

# php-assessment
## PHP Laravel assessment task

This code challenge is to assess your skills in developing a simple API for a todo list application. For this code challenge you must use laravel and expose the API endpoints.

Please note that the code should be clean, commented and well structured. We will test the endpoints using postman so you provide us with a postman collection with all the endpoints.

Creating the exact models needed for the application to work properly is completely up to you. You can opt to use MySQL, MariaDB or PostgreSQL as you database.

### Register :
- Require email, password and password confirmation as post body
- Route should create a user that is not verified in the database
- Route should send a verification email to the user's email.
- Return appropriate response

### Verification :
- Create logic for verifying the user from the verification code sent to the user’s email address

### Login :
- Require email and password as the post body.
- Authenticate the user through provided credentials.
- If user is verified and email/password are correct, respond with a JWT token, otherwise show the appropriate response

### Logout :
- Invalidate the user's JWT token

### ToDo List :
- Users can view only their todo items in the list.
- Send out a paginated list of ToDos (up to 10 items per page, preferably use Laravel's built in pagination)
- Implement logic to search items in the list by name.

### Create ToDo :
- 2 fields required: title and description of the ToDo item
- On success save the item to the database
- Return appropriate response

### View ToDo :
- Respond with an object containing the title and description of the requested ToDo

### Update ToDo :
- 2 fields required: title and description of the ToDo item
- On success save updated item to the database
- Return appropriate response

### Delete ToDo :
- Delete the item from the database.
- Return appropriate response.

