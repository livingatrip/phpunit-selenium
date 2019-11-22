# Selenium-Grid + PHPUnit + Docker

<!--[//]: <> > This is the example application for the article [Selenium-Grid mit Docker im PHP Magazin 5.16](https://///////entwickler.de/php-magazin/php-magazin-5-16-252647.html "Parallele Akzeptanztests in wenigen Minuten")-->

## Requirements

* Docker
* Composer
* VNC Viewer (optional)

## Install

Use Composer and run 

```
composer install
```

## Running Standalone Server

Chrome
```
$ docker run -d -p 4444:4444 selenium/standalone-chrome
```

Firefox
```
$ docker run -d -p 4444:4444 selenium/standalone-firefox
```

> **NOTE** (from Selenium Docker readme): When executing docker run for an image with Chrome or Firefox please either mount -v /dev/shm:/dev/shm or use the flag --shm-size=2g to use the host's shared memory.

Example
```
$ docker run -d -p 4444:4444 -v /dev/shm:/dev/shm selenium/standalone-chrome
# OR
$ docker run -d -p 4444:4444 --shm-size=2g selenium/standalone-chrome
```

## Running a Grid

```
$ docker run -d -p 4444:4444 --name selenium-hub selenium/hub:3.4.0
$ docker run -d -P --link selenium-hub:hub selenium/node-chrome:3.4.0
$ docker run -d -P --link selenium-hub:hub selenium/node-firefox:3.4.0
```

### Watching Tests

Use the IP/Port with the VNC Viewer. The passwort is *secret*:

```
$ vncviewer 0.0.0.0:49338
```

> **Note**: use docker ps to see container port to access from VNC

## Using PHPUnit
Every test is executed in order. This should take ~6s.

```
$ vendor/bin/phpunit --verbose --bootstrap vendor/autoload.php tests/Example_grid
```

Output:

```
PHPUnit 5.7.27 by Sebastian Bergmann and contributors.

Runtime:       PHP 5.6.40-13+ubuntu16.04.1+deb.sury.org+1

..                                                                  2 / 2 (100%)

Time: 5.95 seconds, Memory: 3.50MB

OK (2 tests, 3 assertions)
```