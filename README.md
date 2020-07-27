## TDD Venom

<p>Test driven development is the kinda new way to do safe development, cause you wanna always keep track of whether you are breaking some functionality in the system, by adding new code, or updating the existing.</p>
<p>Also using the laravel new test artisan command is pretty cool, test it please. I love it</p>


## Laravel Unit Test stub caveats

<p>Am just a beginner to TDD, and I got an error that took me around 2 - 3 hours debugging, but it turns out the fault was not mine at, I would claim so</p>

By default artisan command for generating a unit test, imports <br>

** PHPUnit\Framework\TestCase **

which fails the unit test case is you try testing the models like

Author::create(['name' => 'J.K, Rowling'])

![Error, Screenshot](https://github.com/AzengaKevin/library-tdd-with-tutor/blob/master/public/img/screenshots/unittest-error.png)

Incase it occurs just change the imported class to

** Tests\TestCase ** <br>
And now

![Success, Screenshot](https://github.com/AzengaKevin/library-tdd-with-tutor/blob/master/public/img/screenshots/unittest-success.png)
