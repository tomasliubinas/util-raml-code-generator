
## vendor-auth-client

Provides methods to manipulate `Auth` API.
It automatically authenticates all requests and maps required data structure for you.

#### Usage

This library provides `ClientFactory` class, which you should use to get the API client itself:

```php
use Paysera\Test\TestClient\ClientFactory;

$clientFactory = ClientFactory::create([
    'base_url' => 'https://my-api.example.com/rest/v1', // optional, in case you need a custom one.
    'basic' => [                                        // use this, it API requires Basic authentication.
        'username' => 'username',
        'password' => 'password',
    ],
    'oauth' => [                                        // use this, it API requires OAuth v2 authentication.
        'token' => [
            'access_token' => 'my-access-token',
            'refresh_token' => 'my-refresh-token',
        ],
    ],
    // other configuration options, if needed
]);

$authClient = $clientFactory->getAuthClient();
```

Please use only one authentication mechanism, provided by `Vendor`.

Now, that you have instance of `AuthClient`, you can use following methods
### Methods

    
Create auth token


```php
use Paysera\Test\TestClient\Entity as Entities;

$credentials = new Entities\Credentials();

$credentials->setUsername($username);
$credentials->setPassword($password);
    
$result = $authClient->createAuthToken($credentials);
```
---

Invalidate auth token


```php

$authClient->deleteAuthToken();
```
---


Creates system token by the requested scopes. If user can&#039;t access all the scopes - returns token created by the scopes user can access


```php
use Paysera\Test\TestClient\Entity as Entities;

$systemTokenRequest = new Entities\SystemTokenRequest();

$systemTokenRequest->setScope($scope);
$systemTokenRequest->setAudience($audience);
    
$result = $authClient->createOptionalSystemToken($systemTokenRequest);
```
---


Creates system token by the requested scopes. If user can&#039;t access all the scopes - returns challenge


```php
use Paysera\Test\TestClient\Entity as Entities;

$systemTokenRequest = new Entities\SystemTokenRequest();

$systemTokenRequest->setScope($scope);
$systemTokenRequest->setAudience($audience);
    
$result = $authClient->createStrictSystemToken($systemTokenRequest);
```
---






```php
use Paysera\Test\TestClient\Entity as Entities;

$filter = new Entities\Filter();

$filter->setLimit($limit);
$filter->setOffset($offset);
$filter->setOrderBy($orderBy);
$filter->setOrderDirection($orderDirection);
    
$authClient->getTokens($filter);
```
---

