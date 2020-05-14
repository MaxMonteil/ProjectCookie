# ProjectCookie Client

## Project setup
```
npm install
```

### Compiles and hot-reloads for development
```
npm run serve
```

### Compiles and minifies for production
```
npm run build
```

### Lints and fixes files
```
npm run lint
```

## Client-Server Communication Reference

This is a reference of all the routes of the client side along with the server endpoints it communicates with. It describes the format and structure of the data it requests and sends.

### Parsing JSON data

When the client sends JSON data to the server, it sets the `Content-Type` header to `application/json`. This data type cannot be handled by the PHP super global `$_POST`. Instead you must retrieve the data from PHP's input stream and then decode it.

```php
$data = json_decode(file_get_contents('php://input'), true);
```

So if the client POSTS this:

```jsonc
{
    "name": "John Doe",
    "age": 30
}
```

The above PHP code will give us this:

```php
$data = json_decode(file_get_contents('php://input'), true);

// $data['name'] => 'John Doe'
// $data['age'] => 30
```

### Errors

```jsonc
{
    "message": "oops something went wrong" //string
}
```

### Auth

#### Login

| endpoint | method |
| -------- |:------:|
| /login   | POST   |

##### Data

```jsonc
{
    "email": "abc123@mail.edu", // string
    "password": "password123",  // string
}
```

##### Expected Response

```jsonc
{
    "jwt": "jwt_token_oaiwhtalwkj", // string
    "email": "abc123@mail.edu"      // string
}
```

#### Register

| endpoint | method |
| -------- |:------:|
| /register   | POST   |

##### Data

```jsonc
{
    "email": "abc123@mail.edu",         // string
    "password": "password123",          // string
    "confirmpassword": "password123",   // string
}
```

#### Change Password

| endpoint | method |
| -------- |:------:|
| /changepassword   | POST   |

##### Data

```jsonc
{
    "email": "abc123@mail.edu",         // string
    "oldpassword": "password123",       // string
    "newpassword": "123456pass",        // string
    "confirmnewpassword": "123456pass", // string
}
```

### User

#### Get User

| endpoint | method |
| -------- |:------:|
| /user    | POST   |

##### Data

```jsonc
{
    "email": "abc123@mail.edu", // string
}
```

##### Expected Response

### Courses

#### Get all courses

| endpoint | method |
| -------- |:------:|
| /courses    | GET   |

##### Expected Response

```jsonc
{
    "courses": [
        {
            "id": "fpiu314",            // string
            "name": "web dev",          // string
            "startDate": "YYYY-MM-DD",  // string
            "studentCount": 459,        // number
            "description": "This course is about web dev..." // string
        }
        // ...
    ],
    // available search options the user can use for a more advanced search
    "searchOptions": {
        "subject": [
            "history",
            "math"
            // ...
        ],
        "language": [
            "english",
            "french"
            // ...
        ]
    },
}
```

#### Get all courses by subject

| endpoint | method |
| -------- |:------:|
| /subjects    | POST   |

##### Data

```jsonc
{
    "subjects": [
        "history",
        "math"
        // ...
    ]
}
```

##### Expected Response

```jsonc
{
    "history": [
        {
            "id": "fpiu314",            // string
            "name": "web dev",          // string
            "startDate": "YYYY-MM-DD",  // string
            "studentCount": 459,        // number
            "description": "This course is about web dev..." // string
        }
        // ...
    ]
    // ...
}
```

#### Get all subjects

| endpoint | method |
| -------- |:------:|
| /subjects    | GET   |

##### Expected Response

```jsonc
{
    "subjects": [
        "history",
        "math"
        // ...
    ],
}
```

#### Get enrolled courses

| endpoint | method | description |
| -------- |:------:| ----------- |
| /enrolled    | GET   | get all enrolled courses |
| /enrolled    | POST   | get a certain number of courses |

##### Data

```jsonc
{
    "limit": 4 // number, number of courses to return
}
```

##### Expected response

```jsonc
{
    "courses": [
        {
            "id": "fpiu314",    // string
            "name": "web dev",  // string
            "progress": 32      // number
        },
        // ...
    ]
}
```

### Search

#### Search for a query

| endpoint | method |
| -------- |:------:|
| /search    | POST   |

##### Data

```jsonc
{
    "search": "web dev",        // string, user's search term

    // optional parameters, if they are empty string, disregard
    "options": {
        "subject": "history"    // string
        "language": "english"   // string
        "price": 10             // number | null
    }
}
```

##### Expected Response

```jsonc
{
    "courses": [
        {
            "id": "fpiu314",            // string
            "name": "web dev",          // string
            "startDate": "YYYY-MM-DD",  // string
            "studentCount": 459,        // number
            "description": "This course is about web dev..." // string
        }
        // ...
    ],
    // available search options the user can use for a more advanced search
    "searchOptions": {
        "subject": [
            "history",
            "math"
            // ...
        ],
        "language": [
            "english",
            "french"
            // ...
        ]
    },
}
```

