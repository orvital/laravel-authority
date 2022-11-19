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
- /open
- /user
- /site
- /team

- /user/profile                 panel
- /user/tokens                  token

- /user/settings
- /user/password

- secure
- public

- email
- token
- board
- panel

- /account
- /profile
- /company

GET|HEAD    auth/cookie

GET|HEAD    auth/access ...........  auth/access ................  auth ...........
POST        auth/access ...........  auth/access ................  auth ...........
DELETE      auth/access ...........  auth/access ................  auth ...........
GET|HEAD    auth/forgot ...........  auth/forgot ................  auth/forgot ...........
POST        auth/forgot ...........  auth/forgot ................  auth/forgot ...........
GET|HEAD    auth/forgot/{token} ...  auth/forgot/{token} ........  auth/forgot/{token} ...
PUT         auth/forgot/{token} ...  auth/forgot/{token} ........  auth/forgot/{token} ...
GET|HEAD    auth/signup ...........  auth/signup ................  auth/signup ...........
POST        auth/signup ...........  auth/signup ................  auth/signup ...........

GET|HEAD    user/unlock ...........  auth/user/unlock ...........  auth/access/unlock ...........
POST        user/unlock ...........  auth/user/unlock ...........  auth/access/unlock ...........
GET|HEAD    user/verify ...........  auth/user/verify ...........  auth/access/verify ...........
POST        user/verify ...........  auth/user/verify ...........  auth/access/verify ...........
GET|HEAD    user/verify/{id}/{hash}  auth/user/verify/{id}/{hash}  auth/access/verify/{id}/{hash}

GET|HEAD    account ...............  user .......................  user ...............
PUT         account ...............  user .......................  user ...............
POST        account ...............  user .......................  user ...............
GET|HEAD    account/tokens ........  user/tokens ................  user/tokens ........
POST        account/tokens ........  user/tokens ................  user/tokens ........
DELETE      account/tokens/{token}   user/tokens/{token}.........  user/tokens/{token} 


/api/user
/api/auth
/api/auth/token