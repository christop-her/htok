# API Documentation

Welcome to the API documentation for our PHP-based system. This document provides detailed information about the available API endpoints, their request formats, and responses.

## Base URL
```
https://example.com/api/v1/
```

---

## Endpoints

### 1. User Signup

**Endpoint:**

```
POST /auth/signup.php
```

**Description:**  
Create a new user account.

**Request:**

```json
{
    "username": "johndoe",
    "email": "johndoe@email.com",
    "userpassword": "password",
    "cpassword": "password",
    "userrole": "user_role",
    "department": "department",
    "gender": "gender",
    "dateOfBirth": "2020-07-18"
}
```

**Response:**

- **201 Created**

```json
{
  "message": "User successfully registered",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "johndoe@example.com"
  }
}
```

- **400 Bad Request**

```json
{
  "error": "Validation error"
}
```

---

### 2. User Login

**Endpoint:**

```
POST /auth/login.php
```

**Description:**  
Authenticate a user and retrieve a JWT token.

**Request:**

```json
{
  "email": "johndoe@example.com",
  "userpassword": "password123"
}
```

**Response:**

- **200 OK**

```json
{
  "message": "Login successful",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "johndoe@example.com"
  }
}
```

- **401 Unauthorized**

```json
{
  "success": false,
  "message": "Invalid email or password"
}
```

---

### 3. Book an Appointment

**Endpoint:**

```
POST /book.php
```

**Description:**  
Book an appointment with a doctor.

**Request:**

```json
{
  "DoctorEmail": "doctor@example.com",
  "email": "patient@example.com",
  "reason": "Consultation"
}
```

**Response:**

- **200 Created**

```json
{
    "success": true,
    "message": "Booked successfully"
}
```

- **400 Bad Request**

```json
{
  "error": "Unable to book appointment"
}
```

---



- **400 Bad Request:** The request is malformed or contains invalid parameters.
- **401 Unauthorized:** The request requires authentication, or the provided token is invalid.
- **404 Not Found:** The resource was not found.
- **500 Internal Server Error:** A server error occurred.

---

