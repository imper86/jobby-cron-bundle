# Jobby bundle - cron job manager for Symfony
This bundle uses excellent [hellogerard/jobby](https://github.com/jobbyphp/jobby)
library to provide you easy way to manage cron jobs.

## Installation
As always use [composer](https://getcomposer.org/) to install bundle:

```sh
composer require imper86/jobby-cron-bundle
```

Add the following line to the crontab:
```
* * * * * cd /path/to/project && php bin/console i86:jobby:execute 1>> /dev/null 2>&1
```

### Additional steps for apps without symfony flex
Add bundle to your ```bundles.php```

```php
Imper86\JobbyBundle\Imper86JobbyBundle::class => ['all' => true],
```

## Configuration
Configuration of this bundle is mirror of [Jobby](https://github.com/jobbyphp/jobby)
config, splitted into two sections - globals and jobs.

In *globals* section you can define default config for every job.

Example, minimal config:
```yaml
imper86_jobby:
    jobs:
        foojob:
            command: 'app:foo'
        barjob:
            command: 'app:bar'
            schedule: '*/15 * * * *'
``` 

Please use ```./bin/console config:dump imper86_jobby``` for details.

## Contributing
Any help will be appreciated :).
