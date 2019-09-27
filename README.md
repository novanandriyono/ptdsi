# Jwt login - ptdsi
this for ptdsi
 
## How to use
first add JWT_KEY=YOUR_KEY on .env

this jwt_login use csrf_token so at the firsttime we must get our csrf_token.
csrf_token available if you use get method on login route and it will give you  response json with csrf_token value.

##

### Get csrf_token
- method get /login
results
{
    "_token": "SMxwEJbWu6YHaXP4anIrklYCDl3yFWLZvfYA0pcJ"
}

##

### Send post method
- method post /login
/login?_token=csrf_token&email=useremail&password=userpassword
- result 
{
    "jwt_token": "JWT_TOKEN",
}

if we want to perform login please use params email, password and _token(we can get from method get on login route) and if login success will show with response json jwt_token, you can save jwt token.


## How to Validate Jwt_token
we can perform post method to decodetoken route and dont forget before we perform post, we must set csrf_token first
 
- method post /decodetoken
/decodetoken?jwt_token=JWT_TOKEN&_token=csrf_token
- results
{
    "id": 1,
    "email": "user@email.com",
    "name": "user name"
} 


Please take alook on web route 
 all API set on web route

note: this jwt doesnt have expired :-) just for interview. and please follow up


best regards
Novan