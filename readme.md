# Laravel Authority

## Authentication

Guards: `session`, `sanctum`
Middleware Groups: `web`, `api`
Middlewares: `auth`, `guest`

## Guest

-                                   /auth
- /auth/login                       /auth/access
- /auth/register                    /auth/signup
- /auth/recovery                    /auth/rescue    /forgot  /regain

## Authenticated

- /user/profile                     /user
- /user/verification (email)        /user/verify
- /user/confirmation (password)     /user/unlock
                                    /user/tokens

- /team

- /account
- /profile
- /company
