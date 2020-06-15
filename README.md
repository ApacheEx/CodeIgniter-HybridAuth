# CodeIgniter-HybridAuth
HybridAuth library for CodeIgniter 3.x

## Dependencies
- [HybridAuth 2.x](https://github.com/hybridauth/hybridauth) for `CodeIgniter-HybridAuth v1`
- [HybridAuth 3.x](https://github.com/hybridauth/hybridauth) for `CodeIgniter-HybridAuth v2`
- [CodeIgniter 3.x](https://www.codeigniter.com)

## Installation
If you're familiar with [composer](https://getcomposer.org) (recommended :+1:):
- go to `application` and run the following command:
```
composer require hybridauth/hybridauth
```
- then, go to `application/config.php` and set `composer_autoload` to `TRUE`:
```php
$config['composer_autoload'] = TRUE;
```
Alternatively, you can:
- download [HybridAuth library](https://github.com/hybridauth/hybridauth/releases)
- unpack the library into `application/third_party/hybridauth` folder

Ok, now copy files from this repository into your project:
```
application/config/hybridauth.php
application/libraries/Hybridauth.php
application/controllers/Hauth.php
application/views/hauth
```

Good, now let's put `http://<yourdomain.com>/index.php/hauth/window/<Provider ID>` as valid `Callback URL` in your provider application.

_e.g for Facebook provider:_
- go to `https://developers.facebook.com/apps/YOUR_APP/fb-login`
- put `http://<yourdomain.com>/index.php/hauth/window/facebook` as `Valid OAuth redirect URIs`

Finally, configure the providers inside the `application/config/hybridauth.php` file
- To make correct configuration for providers please visit the [HybridAuth documentation](https://hybridauth.github.io)

:tada: :tada: :tada:

## Quick Start
- Visit `http://<yourdomain.com>/index.php/hauth` to see enabled providers.
- Modify `Hauth` controller to your fits.

## How to use
First, you should load HA library into the system
```php
$this->load->library('hybridauth');
```
To create a login link you can use
```php
anchor('hauth/window/facebook', 'Facebook');
```
Or just put this link to your html code.
```html
<a href="http://www.example.com/index.php/hauth/window/facebook">Log in with Facebook</a>
```
To access HA instance use `$this->hybridauth->HA`
```php
// Login into facebook.
$adapter = $this->hybridauth->HA->authenticate('Facebook');
// Get user profile.
$profile = $adapter->getUserProfile();
```

It's recommended to use Hauth controller (_/index.php/hauth_).
