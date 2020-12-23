GeekBrains PHP 2 [Memcached]
====================================================

* ***Actions on the deployment of the project:***

- Making a new project memcached_aman4enkov.loc:
				
		sudo chmod -R 777 /var/www/Memcached/memcached_aman4enkov.loc

		//!!!! .conf
		sudo cp /etc/apache2/sites-available/test.loc.conf /etc/apache2/sites-available/memcached_aman4enkov.loc.conf
				
		sudo nano /etc/apache2/sites-available/memcached_aman4enkov.loc.conf

		sudo a2ensite memcached_aman4enkov.loc.conf

		sudo systemctl restart apache2

		sudo nano /etc/hosts
		
		cd /var/www/Memcached/memcached_aman4enkov.loc

Deploy project:

- Download the archieve with project files( Code -> Download ZIP ).

---

Артем Манченков

[GeekBrains PHP 2 [Memcached] (18:13)]( https://www.youtube.com/watch?v=5q4VoOOlwXw&ab_channel=%D0%90%D1%80%D1%82%D0%B5%D0%BC%D0%9C%D0%B0%D0%BD%D1%87%D0%B5%D0%BD%D0%BA%D0%BE%D0%B2 )

[(3:10)]( https://youtu.be/5q4VoOOlwXw?t=190 )
`memcache.php`:

[(7:17)]( https://youtu.be/5q4VoOOlwXw?t=437 )

![screenshot of sample]( https://github.com/mslobodyanyuk/memcached_aman4enkov/blob/master/public/images/1.png )

![screenshot of sample]( https://github.com/mslobodyanyuk/memcached_aman4enkov/blob/master/public/images/2.png )

![screenshot of sample]( https://github.com/mslobodyanyuk/memcached_aman4enkov/blob/master/public/images/3.png )

[(11:55)]( https://youtu.be/5q4VoOOlwXw?t=715 )
There are three more files for use in working with events:
`Storage.php` is a separate class for storing values ​​in memcache for different projects. - Before that, we wrote to memcache simply by the name of the key, BUT the problem is that
IF Create another such Record with the same key, it will be overwritten. Therefore, it is necessary for different projects to make a system of Recording by prefixes( DESIRABLE ).
The `Storage` class implements `Singleton`. By default, it has a cache size( `$cache` ) - this is `instance`. It has a static variable prefix( `$prefix` ) which prefixes
of each key the value `'project:'`. For example, you wanted to write `$users`, and he will interpret it as `'project: users'`, respectively, you protect yourself from the fact that someone already
will write such a variable. - And in a common project it will be a unique value. Though Memcache is one for the SERVER. 

[(13:15)]( https://youtu.be/5q4VoOOlwXw?t=795 )
Function `getInstance()` - EVERYTHING works the same as in `Singleton` plus Create a Memcached object, add a SERVER to which we will access, AND Write it to `instance`, and return.
Next comes the `set()` function in which we will also call the usual `set()` function of our memcache, BUT at the same time we will add a prefix to it. Our `getInstance()`, referring to Memcache
we call the `set()` function - where we pass the name(- prefix and key ) and value. Although in the `set()` function itself, we also still accept a key, a value.

![screenshot of sample]( https://github.com/mslobodyanyuk/memcached_aman4enkov/blob/master/public/images/4.png )

[(14:10)]( https://youtu.be/5q4VoOOlwXw?t=850 )
The function `delete()` is arranged in a similar way - that is, they accessed, deleted by prefix, key. And the same with `get()`: `->get()`, prefix, key.

![screenshot of sample]( https://github.com/mslobodyanyuk/memcached_aman4enkov/blob/master/public/images/5.png )

[(14:35)]( https://youtu.be/5q4VoOOlwXw?t=875 )
`admin.php` - the so-called blocking is used; connect our `Storage.php`, create a command OR a status that says `'user_locker'` - this will be our key. - Further we referring to our
`Storage::` we say "set" the value of the `'user_locker'` key to `true`, that is, we blocked users. Then we display the message - "We start blocking", then - the process "sleeps" for 10 seconds. AND,
after 10 seconds we "say" that the users are unlocked and delete "this"(- `$command` ) from memory.

![screenshot of sample]( https://github.com/mslobodyanyuk/memcached_aman4enkov/blob/master/public/images/6.png )

[(15:10)]( https://youtu.be/5q4VoOOlwXw?t=910 )
Accordingly, here instead of `sleep()...` it will be some kind of logic of our application, processing invoices, updating some data, OR something else. That is, at this point, something should be done in the application.
It can be a separate script launched via `CRON` OR via a `queue manager`, whatever. - Accordingly, after they are unlocked, something will become available for us.

[(15:40)]( https://youtu.be/5q4VoOOlwXw?t=940 )
And there is one more file which, roughly speaking, is user-defined.

![screenshot of sample]( https://github.com/mslobodyanyuk/memcached_aman4enkov/blob/master/public/images/7.png )

`user.php`: Here we can refer to this lock AND, IF it exists, then we will wait for the unlock, so to speak.

Example. Notification system when you order a bank statement, they say: "Your request is being processed, please come back later." BUT IF you go to your page in 10 seconds you will see
simply informing you that your data is still being processed. - Accordingly, this example is just the same in action. We refer to our status(- `'user_locker'` ). IF it is `true`, until
it is `true` - then we respectively will display the message `"The user is still locked"` And "sleep" for 1 second. - Accordingly, after it is unlocked, we display a message...
Well, and then it rushed, respectively, again, our application logic.

[(16:40)]( https://youtu.be/5q4VoOOlwXw?t=1000 )
We run both files in different terminals:
	
	php admin.php 
	php user.php
	
[(16:55)]( https://youtu.be/5q4VoOOlwXw?t=1015 )
I will run `user.php`.

[(17:00)]( https://youtu.be/5q4VoOOlwXw?t=1020 )
![screenshot of sample]( https://github.com/mslobodyanyuk/memcached_aman4enkov/blob/master/public/images/8.png )
We see what: `"OK. User can work."` - Why? - Because the `status` was NOT found.

[(17:05)]( https://youtu.be/5q4VoOOlwXw?t=1025 )
I "go" to `admin.php` - and we see that the blocking has started:

![screenshot of sample]( https://github.com/mslobodyanyuk/memcached_aman4enkov/blob/master/public/images/9.png )

[(17:10)]( https://youtu.be/5q4VoOOlwXw?t=1030 )
In another terminal, back, run `user.php` again.

![screenshot of sample]( https://github.com/mslobodyanyuk/memcached_aman4enkov/blob/master/public/images/10.png )
And, we see: `"User is still locked."` - Accordingly, It will happen for 10 seconds.

[(17:42)]( https://youtu.be/5q4VoOOlwXw?t=1062 )
Status !Necessary! overwrite because it has to be processed( - in a loop ).
	
```php	
$status = Storage::get('user_locker');
```	

![screenshot of sample]( https://github.com/mslobodyanyuk/memcached_aman4enkov/blob/master/public/images/11.png )
 
In one terminal, I run the administrator.

![screenshot of sample]( https://github.com/mslobodyanyuk/memcached_aman4enkov/blob/master/public/images/12.png )
In the other, we launch the user. - Accordingly, now, the blocking has gone. I am looking at the terminal running `admin.php` - waiting for a message here when it is unlocked.

![screenshot of sample]( https://github.com/mslobodyanyuk/memcached_aman4enkov/blob/master/public/images/13.png )
And, returning to the running `user.php` - I see: `"OK. User can work."`

![screenshot of sample]( https://github.com/mslobodyanyuk/memcached_aman4enkov/blob/master/public/images/14.png )

... Here is one example of using Memcached.

#### useful links:

<https://memcached.org/>

_Also can be useful information in:_

Traversy Media

[Intro To Memcached]( https://www.youtube.com/watch?v=7MLXuG83Fsw&ab_channel=TraversyMedia )

Quick Notepad Tutorial

[Example to use Memcached on PHP ( Memcached - Use it on PHP )]( https://www.youtube.com/watch?v=_wbuByP2HYs&ab_channel=QuickNotepadTutorial )