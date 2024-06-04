# API PHP

## How it works?

1) Change the directory to /public (`cd public`);
2) In the public directory (/public), start the server `php -S localhost:8000`
3) To get a Balance, use the endpoint localhost:8000/balance
4) To make a transaction use POST method, with the follow payload: 

```
{
    "type": "withdraw", 
    "amount": 100
}
```
5) Allowed Operations: withdraw / deposit;
6) Amount must be numeric and greater than Zero