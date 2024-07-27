# National Weather Service API Plugin for CakePHP

Interact with the National Weather Service API using CakePHP Plugin

Methods that are available are based on the routes listed on the National Weather Service website at 
https://www.weather.gov/documentation/services-web-api#/.


## Contents

* [Installation](#installation)
* [Usage / How To Use](#usage)
* [Overriding Default Configuration](#overriding-default-configuration)
* [Report Issues / Feature Requests](#report-issues-or-feature-requests)
* [Versoining](#version-numbering)

## Installation

You can install this plugin into your CakePHP application using [composer](https://getcomposer.org).

The recommended way to install composer packages is:

```sh
composer require almostengr/national-weather-service-api
```

## Usage

This plugin is to be used like any other component within CakePHP.

In your Controller class, add the code below. If you do not already have an ```initialize()``` method 
in your controller class, you may copy and paste the code below as it is written.

```php
public function initialize(): void
{
    parent::initialize();

    $this->loadComponenent("NwsApi");
}
```

Inside of your controller method, you will call one of the endpoints like the below.

```php
$this->NwsApi->getAlertTypes();
```

## Overriding Default Configuration

This plugin has default values for the API URL and the timeout. To override the defaults, 
add an entry to your app_local.php file.

```json
[
    "NwsApi":
    {
        "url": "api.weather.gov",
        "timeout": 30,
    }
]
```

## Report Issues or Feature Requests

Issues and feature requests should be submitted to the project issue tracker at 
https://github.com/almostengr/cakephp-nws-api.

Upcoming features and functionality are also listed on the project issue tracker.

## Version Numbering

The version number for this plugin is in the following format. Using the example of 

```txt
5.2024.07.26
```

"5" represents the major CakePHP version number that the plugin is designed for

"2024.07.26" represents the date, in YYYY-MM-DD format, that the release was created
