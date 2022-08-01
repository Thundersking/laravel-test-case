## TestCase for laravel testing

### Install
```sh
composer require vion/test-case
```

### Basic Usage
Create a file `.env.testing` and add params:
```sh
VION_USERNAME_TEST=admin@test.ru
VION_PASSWORD_TEST=password
VION_OAUTH_CLIENT_ID=3
```
Inherit TestCase in your test file and use trait `CreatesApplication;`
 