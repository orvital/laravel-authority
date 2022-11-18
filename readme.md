# Laravel Authority

## Authentication

Guards: `session`, `sanctum`
Middleware Groups: `web`, `api`
Middlewares: `auth`, `guest`

## Guest

- /login
- /register
- /recovery (password)
- /invite

## Authenticated

- /logout
- /verification (email)
- /confirmation (password)