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

```json
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

```json
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

```json
{
    "email": "abc123@mail.edu", // string
    "password": "password123",  // string
}
```

##### Expected Response

```json
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

```json
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

```json
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

```json
{
    "email": "abc123@mail.edu",         // string
}
```

##### Expected Response
