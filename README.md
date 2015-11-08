![Travis-CI](https://travis-ci.org/breaktherules/rest-hotel-client.svg?branch=rc-2015-11-09)

Hotel Client Application
=======================

Introduction
------------
This simple application demonstrates accomplishes the following.
* It is able to make REST API calls and consume data.
* It is able to use a jquery Slider to allow the user filter the results
* It demonstrates how CORS based ajax call work [and when they don't work]

Installation & Execution
------------
```
git clone https://github.com/breaktherules/rest-hotel-client .
composer update
php -S 0.0.0.0:8080 -t public public/index.php
```


then visit http://localhost:8080/ with your browser


Important Points About the Application
======================================

Testable Code
-------------
Both Controller and Model Code are tested. Please note that travis-ci is integrated.


Single Responsibility Principle & Separation Of Concern
-------------------------------------------------------
The entire business of communicating to the REST API is constrained in a single Model called HotelRestClient.
The class could implement a Repository interface, which I did not due to lack of time. In that case it would be even easier to replace the class later when you use DB as the client code will already be using familiar code.
To make Proxy Calls to server to simulate Ajax, we used to a separate class so that

Code within view should not make decisions about business logic. Nor the code in Controller. The job of Controller is to wire things up.
The job of view is purely presentational and all decision making logic is restricted within models.


Exception Handling
-------------------
Please note the lack of if-structure in Controller which is a huge boost for readability as the reader does not have mentally branch the flow.
There is a normal flow of code which allows the successful execution. And then in case of error code flows the exception .
Its nothing new, but since I see so many people don't use this, I thought to point this out.


Use of Configuration
--------------------
Any API access points or default values have been put into a config file. Hence it provides a central way to control these values rather than scattered all over.

PSR-2 Compliant Code
--------------------
The code I worte is PSR-2 compliant. Some code used either from ZF2 or borrowed from somewhere may not be as such.

Proper Use of namespaces
-----------------------
The classes have been organized into proper namespaces. Note the Exception classes.


Running the Tests
-----------------
Although you can see the status of test in travis-ci. Here is how it looks when you run it on command line.

```
$ cd test
$ ../vendor/bin/phpunit
PHPUnit 5.0.8 by Sebastian Bergmann and contributors.

.....                                                              5 / 5 (100%)

Time: 2.69 seconds, Memory: 5.75Mb

OK (5 tests, 7 assertions)
```
