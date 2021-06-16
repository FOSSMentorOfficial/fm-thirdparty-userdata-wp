# ThirdParty User Data

It is used to show the user data from the third party APIs. It has the feature to cache the data for 60 mins and load the requested data from the cache object until expire.


## Installation

Following are the basic requirements before plugin installation:

``` 

-- Install latest Wordpress and use min PHP 7.2 
-- Use any dummy/default WP theme to test the plugin. 

```

After the installation, plugin must be actiave from the backend plugin section.

This plugin is a composer package so it must be install using the `composer require` command in the `composer.json` file.

For WP to install this plugin, you have to do one of the following:


### Composer

As a first step, simply require the package via composer

# using composer.json file in the main WP project directory

```

"require": {
        "fossmentorofficial/fm-thirdparty-userdata-wp": "^1.0.1"
    }

``` 

My plugin is only available on GITHUB server. So, must need to provide the Git repository url as well.

```

"repositories": [
	{
		"type": "vcs",
		"url": "git@github.com:fossmentorofficial/fm-thirdparty-userdata-wp.git"
	}
]

```

After the successful installation, this plugin will show under the `plugins` directory.

## Configuration

There are no specific configurations require to use this plugin but this plugin only display the results when use the 'my-lovely-users-table' slug in the url. This is not a page, posts or taxonomy but only a direct plugin url.

For example on my local server, I've the following WP project url:
http://localhost/wp-test-project/

To view the results we must have to open the plugin url by:
http://localhost/wp-test-project/my-lovely-users-table


### fm-thirdparty-userdata-wp.php

This const variable is used to define the path for the script file used in this plugin. This path must be set as per WP setting of the target server.

```php

define( 'SCRIPT_URL', plugin_dir_url( __FILE__ ).'scripts/custom.js' );

``` 


## License and Copyright

Copyright (c) 2021 FOSSMentor

My Private Plugin code is licensed under [GNU GPI v2.0](./LICENSE).

The developer is engineering the Web since 2010