# Laravel Authority

## Authentication

Guards:             `session`, `sanctum`
Middleware Groups:  `web`, `api`
Middlewares:        `auth`, `guest`

users
    id - integer
    name - string
 
roles
    id - integer
    name - string
    permissions - array
 
teams
    id - integer
    name - string
 
teameables
    team_id - integer
    teamable_id - integer
    teamable_type - string

user->teams()
role->teams()

team->users()
team->roles()


## Routes

**guest**

GET|HEAD  auth/access                   
POST      auth/access                   
GET|HEAD  auth/cookie                   
GET|HEAD  auth/recovery                 
POST      auth/recovery                 
GET|HEAD  auth/recovery/{token}         
PUT       auth/recovery/{token}         
GET|HEAD  auth/signup                   
POST      auth/signup                   

**authenticated**

POST      auth/logout                   user/logout                   
GET|HEAD  auth/unlock                   user/unlock                   
POST      auth/unlock                   user/unlock                   
GET|HEAD  auth/verify                   user/verify                   
POST      auth/verify                   user/verify                   
GET|HEAD  auth/verify/{id}/{hash}       user/verify/{id}/{hash}       

GET|HEAD  auth/user                     
PUT       auth/user/password            user/password            
PUT       auth/user/profile             user/profile             
GET|HEAD  user/tokens                   
POST      user/tokens                   
DELETE    user/tokens/{token}           


GET|HEAD   auth/cookie            

<!-- guest:session -->
GET|HEAD   auth/access            
POST       auth/access            
GET|HEAD   auth/signup            
POST       auth/signup            
GET|HEAD   auth/forgot            
POST       auth/forgot            
GET|HEAD   auth/forgot/{token}    
PUT        auth/forgot/{token}    

<!-- auth:session -->
DELETE     auth/access               auth/secured/access            
GET|HEAD   auth/unlock               auth/secured/unlock            
POST       auth/unlock               auth/secured/unlock            
GET|HEAD   auth/verify               auth/secured/verify            
POST       auth/verify               auth/secured/verify            
GET|HEAD   auth/verify/{id}/{hash}   auth/secured/verify/{id}/{hash}

GET|HEAD   user                   
PUT        user                   
POST       user                   
GET|HEAD   user/tokens            
POST       user/tokens            
DELETE     user/tokens/{token}    

## Guest

- /auth/login                       /auth/access            /auth
- /auth/register                    /auth/signup            /auth/signup
- /auth/recovery                    /auth/rescue            /auth/rescue    (forgot, regain)

forgot
rescue
reissue
recover
restore
recovery

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

GET|HEAD  auth/cookie ..........
GET|HEAD  auth/access ..........
POST      auth/access ..........
DELETE    auth/access ..........
GET|HEAD  auth/signup ..........
POST      auth/signup ..........
GET|HEAD  auth/forgot ..........
POST      auth/forgot ..........
GET|HEAD  auth/forgot/{token} ..
PUT       auth/forgot/{token} ..

GET|HEAD  user/unlock ..........
POST      user/unlock ..........
GET|HEAD  user/verify ..........
POST      user/verify ..........
GET|HEAD  user/verify/{id}/{hash

GET|HEAD  account ..............
PUT       account ..............
POST      account ..............
GET|HEAD  account/tokens .......
POST      account/tokens .......
DELETE    account/tokens/{token}

GET|HEAD  api/hubs .............
POST      api/hubs .............
GET|HEAD  api/me ...............
GET|HEAD  api/roles ............
GET|HEAD  api/teams ............
POST      api/token ............
GET|HEAD  api/token ............
DELETE    api/token ............
GET|HEAD  api/users ............



GET|HEAD  auth/cookie ............

GET|HEAD  auth/access ............
POST      auth/access ............
DELETE    auth/access ............

GET|HEAD  auth/signup ............
POST      auth/signup ............

GET|HEAD  auth/forgot ............
POST      auth/forgot ............
GET|HEAD  auth/forgot/{token} ....
PUT       auth/forgot/{token} ....

GET|HEAD  auth/unlock ............
POST      auth/unlock ............

GET|HEAD  auth/verify ............
POST      auth/verify ............
GET|HEAD  auth/verify/{id}/{hash} 



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

POST   /account                 Create Account
PATCH  /account/password        Update Password
PATCH  /account/email           Update Email

POST   /account/recovery        Create Password Recovery
POST   /account/verification    Create Email Verification


| GET|HEAD | auth/forgot              | `password.request`    
| POST     | auth/forgot              | `password.email`        
| GET|HEAD | auth/forgot/{token}      | password.reset        
| PUT      | auth/forgot/{token}      | password.update       
