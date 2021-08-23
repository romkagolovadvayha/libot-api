# Listing Bot Rest Api
Cryptocurrency exchange trading bot
____


## Add Bot
### Request
``` POST /add.bot ```

```userId``` - user uniq id

```params``` - key/value list settings bot

### Response

```apacheconf
HTTP/1.1 200 OK
Date: Thu, 24 Feb 2011 12:36:30 GMT
Status: 200 OK
Connection: close
Content-Type: application/json
```


## Add Listing
### Request
``` POST /add.listing ```

```channel``` - channel source get info

```currency``` - currency listing information

### Response

```apacheconf
HTTP/1.1 200 OK
Date: Thu, 24 Feb 2011 12:36:30 GMT
Status: 200 OK
Connection: close
Content-Type: application/json
```


## Add Transfer Buy
### Request
``` POST /add.transfer ```

```botId``` - bot uniq Id

```currencyBuy``` - Cryptocurrency trade exchange buy

```sumBuy``` - sum buy

```currencySell``` - Cryptocurrency trade exchange sell

### Response

```apacheconf
HTTP/1.1 200 OK
Date: Thu, 24 Feb 2011 12:36:30 GMT
Status: 200 OK
Connection: close
Content-Type: application/json
```

## Add User
### Request
``` POST /add.user ```

```login``` - user login

```password``` - not crypto password

```fullname``` - user fullname

### Response

```apacheconf
HTTP/1.1 200 OK
Date: Thu, 24 Feb 2011 12:36:30 GMT
Status: 200 OK
Connection: close
Content-Type: application/json
```

## Get Bots
### Request
``` GET /get.bots ```

```userId``` - user id

### Response

```apacheconf
HTTP/1.1 200 OK
Date: Thu, 24 Feb 2011 12:36:30 GMT
Status: 200 OK
Connection: close
Content-Type: application/json
```

## Get Listings List
### Request
``` GET /get.listings ```

```login``` - user login

### Response

```apacheconf
HTTP/1.1 200 OK
Date: Thu, 24 Feb 2011 12:36:30 GMT
Status: 200 OK
Connection: close
Content-Type: application/json
```


## Get Transfers List
### Request
``` GET /get.transfers ```

```botId``` - bot id

### Response

```apacheconf
HTTP/1.1 200 OK
Date: Thu, 24 Feb 2011 12:36:30 GMT
Status: 200 OK
Connection: close
Content-Type: application/json
```

## Get User
### Request
``` GET /get.user ```

```login``` - user login

### Response

```apacheconf
HTTP/1.1 200 OK
Date: Thu, 24 Feb 2011 12:36:30 GMT
Status: 200 OK
Connection: close
Content-Type: application/json
```

## Update Bot
### Request
``` POST /update.bot ```

```botId``` - bot id

```active``` - bot active boolean

```params``` - key/value list settings bot

### Response

```apacheconf
HTTP/1.1 200 OK
Date: Thu, 24 Feb 2011 12:36:30 GMT
Status: 200 OK
Connection: close
Content-Type: application/json
```

## Update User
### Request
``` POST /update.user ```

```login``` - user login

```password``` - not crypto password

```fullname``` - user fullname

### Response

```apacheconf
HTTP/1.1 200 OK
Date: Thu, 24 Feb 2011 12:36:30 GMT
Status: 200 OK
Connection: close
Content-Type: application/json
```
