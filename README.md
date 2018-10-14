Answers To The Dev Questions
----

##### Write a function that checks if an inputted value is a palindrome. The function should return true/false (bool). You can assume that all input will be a string type and lower case.

./Answers/Palindrome.php

Answers to the dev questions can be found in the ./Answers directory

```
php ./Answers/Palindrome.php
```

```
/**
 * Determines whether or not a string is a palindrome
 *
 * @param string $input              The string to check
 * @param bool   $excludePunctuation Whether or not punctuation should be excluded
 * @return bool
 */
function is_palindrome(string $input, $excludePunctuation = true): bool
{
    # Remove non letters
    $regex = $excludePunctuation ? '/[.,\/#!$%\^&\*;:{}=\-_`~() ]/' : '/ /';
    $input = preg_replace($regex, '', $input);
    # Note, it's not clear whether or not punctuation should be evaluated.
    #  If they were not expected to be cleared then the above pattern would be replaced with '/ /'

    # i goes up to half the size of the string
    for ( $i = 0; $i < ceil(strlen($input) / 2); $i++ ) {
        # Match a single character in the ith position to the matching character from the end of the string backwards
        if ( substr($input, $i, 1) !== substr($input, 0 - 1 - $i, 1) ) {
            return false;
        }
    }

    return true;
}
```

##### Write a function that checks if an inputted value is a numerical range "100-200". Inputted values can be an integer or a string in the previously stated format. The return should be a true/false (bool) value. Ranges should also allow floats (e.g. "100.00"). The range should also be listed as min/max order. Valid values: 100-200, 100.0-200.1. Invalid Values: 100, 200-100.


```
php ./Answers/Range.php
```

```
/**
 * @param string $string
 * @return bool
 */
function is_range(string $string): bool
{
    # explode the string into individual float values
    $ranges = array_map('floatval', explode("-", $string));

    # If there aren't 2 values then it is not a range
    # Or the first value is less than the second value
    if (
        count($ranges) !== 2
        ||
        $ranges[1] < $ranges[0]
    ) {
        return false;
    }

    return true;
}
```

##### What is the difference between a queue and a stack?

```
php ./Answers/Stack.php
```

A stack is first in last out, where a queue is first in first out.  You'd build a queue if you wanted tasks to be 
completed in the order that they were inserted.  You'd build a stack if you wanted tasks to be completed starting with
the most recently added task.

Queues are quite frequently found, especially when building applications that require a back-end worker to perform tasks
for which a response is not immediately expected by a user, or tasks that run periodically.
    Example: Swiftmail's spool queue

Stack's are found less frequently in my experience, the most obvious example I can think of is Javascript's event stack. 

##### In an array with integers between 1 and 1,000,000 one value is in the array twice. How do you determine which one?

```
php ./Answers/Duplicate.php
```

If the input is a sorted array that has each of the values between 0 and 1,000,000 then it's possible write an algorithm
to find the duplicated value in O(log n) using the same principal as a binary search, but simply looking to see if the 
binary search value is greater or lass than the expected value, storing the previous value and looking for the specific
spot where the expected and previous didn't match.

Assuming that the array is of variable size and is not sorted then I would do this by writing a for loop that did the
following:
 1. removed values from the original array one at a time
 2. then assigned the value to a new array with the key as the value and the value of true.  If the key was already 
    defined then return the key, which will be the duplicate value

Pseudocode:  

```
find_duplicate(array) {
    new_array = empty array
    while ( array length > 0 ) {
        value = pop(array)
        if ( new_array has key value ) {
            return value
        }
        new_array[value] = true
    }
    return false
}
```

Note the return false.  It's not clear what should be returned if no duplicate is found.  This should work for any input
and will have a running time of O(n).


# Build a movie collection app


## Installation instructions

Assumptions: You are running PHP7.2 with some of the standard packages/extensions.  Composer will notify you if you have a package/ext missing.

Step 1
----


Make sure you have Node JS and Yarn package manager installed:

1. Node: https://nodejs.org/en/download/
2. Yarn: https://yarnpkg.com/lang/en/docs/install/

Note: If you are using Ubuntu then the default yarn package **is not actually yarn**.  Make sure to follow the instructions on the official website.

Step 2
----
Clone the repo into a local folder

```
git clone https://github.com/GDIBass/movie-collection-app /var/www/folderloc
```

Step 3
----

From the repository folder run composer

```
composer install
```

Step 4
----

Install yarn packages and Run webpack.  This step differs between environments.

```
yarn install --dev
```

Prod:

```
yarn build
```

QA/Stage/Dev:
```
yarn dev 
```

Dev Watch (will watch for changes and re-compile when they are saved):
```
yarn dev
```

Dev Server (runs webpack's dev server.  Automatically reloads page when JS changes are pushed.  Automatically loads new css without page reload).

```
yarn dev-server
```
Note: Getting this working with a non local environment is tricky at best.


Step 5
----

Ensure your .env file is set up,  This should have been done during the composer step, but if not follow these stesp

```
cp .env.dist .env
vim .env
```

Change the DB url, app secret and app environment.  Get your MovieDB Api (can be obtained for free) key and put it in MOVIEDB_API_KEY.

Save changes

```
cp .env .env.test
```

Change environment to test, local DB will automatically switched to sqlite

Step 5
----
Configure DB

```
./bin/console doctrine:database:create
./bin/console doctrine:migrations:migrate
./bin/console doctrine:fixtures:load
```

This will load a base set of fixtures to test the app with.

Step 6
---

Configure your web server.

Example apache config, with the project in /var/www/moviecollections

/etc/apache2/sites-enabled/moviecollection.mydevdomain.com.conf
```
<VirtualHost *:443>
        ServerName moviecollection.mydevdomain.com
        ServerAlias moviecollection.mydevdomain.com

        SSLEngine on
        SSLCertificateFile /etc/letsencrypt/live/mydevdomain.com/fullchain.pem
        SSLCertificateKeyFile /etc/letsencrypt/live/mydevdomain.com/privkey.pem

        DirectoryIndex index.php

        DocumentRoot /home/matj1985/www/mydevdomain/public
        <Directory /home/matj1985/www/mydevdomain/public>
                AllowOverride None
                Order Allow,Deny
                Require all granted
                Allow from All

                <IfModule mod_rewrite.c>
                        Options -MultiViews
                        RewriteEngine On
                        RewriteCond %{REQUEST_FILENAME} !-f
                        RewriteRule ^(.*)$ index.php [QSA,L]
                </IfModule>
        </Directory>

        ErrorLog /var/log/apache2/project_error.log
        CustomLog /var/log/apache2/project_access.log combined
</VirtualHost>

<VirtualHost *:80>
        ServerName moviecollection.mydevdomain.com
        Redirect permanent / https://moviecollection.mydevdomain.com/
</VirtualHost>

```


## Using Behat

Behat is a behavioral driven test suite for functional testing.  In order to use behat your .env file has to be set to the test environment, it will not function in dev.

Behat uses MINK and Selenium to do web testing with Javascript.  Before you run behat you need to make sure you have a selenium server running, and the latest google chrome drivers (Note: **DO NOT USE FIREFOX** - their drivers do not work).

Selenium can be downloaded here: https://www.seleniumhq.org/download/

You also need to update the behat.yml file to your local dev domain.

To run Behat:

```
./vendor/bin/behat
```

There are web and api test suites.  They can be run individually using the following 

```
./vendor/bin/behat --suite api
./vendor/bin/behat --suite web
```

## Using PHPUnit

I've only built out tests for the Base API controller.  Most everything else is covered by behat's functional tests.

```
./vendor/bin/phpunit
```




Original Text 
-----

# Developer Test
This test is comprised of 5 development related questions and a small code test. For the questions please add as much explanation to your answer as you feel is appropriate.

# Questions
## Write a function that checks if an inputted value is a palindrome. The function should return true/false (bool). You can assume that all input will be a string type and lower case.

## Write a function that checks if an inputted value is a numerical range "100-200". Inputted values can be an integer or a string in the previously stated format. The return should be a true/false (bool) value. Ranges should also allow floats (e.g. "100.00"). The range should also be listed as min/max order. Valid values: 100-200, 100.0-200.1. Invalid Values: 100, 200-100.

## What is the difference between a queue and a stack?

## In an array with integers between 1 and 1,000,000 one value is in the array twice. How do you determine which one?

# Build a movie collection app
We need to prototype an application which makes use of The Movie DB's API. You do not need to build out an entire registration/login feature, the information saved to the database can be a predefined user.

You can use any libraries, frameworks, languages, and technologies that are freely available. Use your best judgement keeping in mind that other Developers may be expanding on your code.

If you have any questions feel free to contact us.

Requirements
When you have completed and submitted your code it should meet the following requirements.

Have proper setup guide so that another developer can follow and run the app in their local environment.
Successfully retrieve movie information from the movie database API.
User can mark/unmark that they own the movie that was searched for.
The search result page should display: movie title, release date, and overview. This should be for all movies found in a list, but you only need to display the first 10 results at most.
The bottom of the page should return the total number of search results. However, you do not need to paginate the results - displaying only 10 results will be fine.