# API

## Auth

Header

```
API-Token: <Your Token>
```

## Endpoints

### Create URL Redirect

POST /api/create

#### Body Params

| Key | Type | Description |
| --- | --- | --- |
| target | string | Target URL |

#### Response

application/json

```
{
    "ok": true,
    "data": {
        "shorten_url": "https://9s.gs/xxxxxx",
        "token": "xxxxxx",
        "target": "https://example.com/xxx",
        "manage_token": "yyyyyyyy"
    }
}
```
