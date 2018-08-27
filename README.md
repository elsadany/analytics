# Google Analytics
##  Retrieve data from Google Analytics
Using this package you can easily retrieve data from Google Analytics.

## Installation
``` bash
composer require elsadany/google-analytics dev-master
```
```php
///  config/app ->providers

Elsadany\Analytics\AnalyticsServiceProvider::class,
```
publish the config file of this package with this command:
``` bash
php artisan vendor:publish
```
The following config file will be published in `config/analyticsConfig.php`
```php
return[
    /*
     * The view id of which you want to display data.
     */
    'view_id'=>'',
/*
the path of your layout
*/
    'extend'=>'',
/*
Content Area Name
*/
    'ContentArea'=>'',
    /*
     * Path to the client secret json file. Take a look at the README of this package
     * to learn how to get this file. You can also pass the credentials as an array 
     * instead of a file path.
     */
//the service key path from the root example 'public/service.json'
    'service_path'=>''
];

```

## How to obtain the credentials to communicate with Google Analytics

### Getting credentials

The first thing you’ll need to do is to get some credentials to use Google API’s. I’m assuming that you’ve already created a Google account and are signed in. Head over to [Google API’s site](https://console.developers.google.com/apis) and click "Select a project" in the header.

![1](https://spatie.github.io/laravel-analytics/v2/1.jpg)

Next up we must specify which API’s the project may consume. In the list of available API’s click "Google Analytics API". On the next screen click "Enable".

![2](https://spatie.github.io/laravel-analytics/v2/2.jpg)

Now that you’ve created a project that has access to the Analytics API it’s time to download a file with these credentials. Click "Credentials" in the sidebar. You’ll want to create a "Service account key".

![3](https://spatie.github.io/laravel-analytics/v2/3.jpg)

On the next screen you can give the service account a name. You can name it anything you’d like. In the service account id you’ll see an email address. We’ll use this email address later on in this guide. Select "JSON" as the key type and click "Create" to download the JSON file.

![4](https://spatie.github.io/laravel-analytics/v2/4.jpg)

Save the json inside your Laravel project at the location specified in the `service_account_credentials_json` key of the config file of this package. Because the json file contains potentially sensitive information I don't recommend committing it to your git repository.

### Granting permissions to your Analytics property

I'm assuming that you've already created a Analytics account on the [Analytics site](https://analytics.google.com/analytics). Go to "User management" in the Admin-section of the property.

![5](https://spatie.github.io/laravel-analytics/v2/5.jpg)

On this screen you can grant access to the email address found in the `client_email` key from the json file you download in the previous step. Read only access is enough.

![6](https://spatie.github.io/laravel-analytics/v2/6.jpg)

### Getting the view id

The last thing you'll have to do is fill in the `view_id` in the config file. You can get the right value on the [Analytics site](https://analytics.google.com/analytics). Go to "View setting" in the Admin-section of the property.

![7](https://spatie.github.io/laravel-analytics/v2/7.jpg)

You'll need the `View ID` displayed there.

![8](https://spatie.github.io/laravel-analytics/v2/8.jpg)


#- /now you can get reports on /google-analytics/show
