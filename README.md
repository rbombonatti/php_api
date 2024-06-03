# API PHP

## How it works?

1) In the public directory (/public), start the server `php -S localhost:8000`
2) To get a Balance, use the endpoint localhost:8000/balance
3) To make a transaction use POST method, with the follow payload: 

```
{
    "type": "withdraw", 
    "amount": 100
}
```
