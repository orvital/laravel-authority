# Laravel Authority

## Authentication

Guards: `session`, `sanctum`
Middleware Groups: `web`, `api`
Middlewares: `auth`, `guest`

## Guest

- /auth/login                       /auth/access            /auth
- /auth/register                    /auth/signup            /auth/signup
- /auth/recovery                    /auth/rescue            /auth/rescue    (forgot, regain)

## Authenticated

- /user/profile                     /user
- /user/verification (email)        /user/verify
- /user/confirmation (password)     /user/unlock

- /auth
- /user
- /team


- /user/profile                 panel
- /user/tokens                  token

- /user/settings
- /user/password

email
token

- /account
- /profile
- /company
