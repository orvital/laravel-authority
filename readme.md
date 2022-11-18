# Laravel Authority

## Authentication

Guards: `session`, `sanctum`
Middleware Groups: `web`, `api`
Middlewares: `auth`, `guest`

## Guest

- /auth/login                       /auth/access
- /auth/register                    /auth/signup
- /auth/recovery                    /auth/rescue

## Authenticated

- /user/verification (email)        /user/verify
- /user/confirmation (password)     /user/unlock
- /user/logout                      /user/logout

- /team

- /account
- /profile
- /company
