<?php

namespace Tests\Feature;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Facebook\WebDriver\Cookie;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
//    public function test_test () {
//        $response = $this->get('/');
//        $response->assertStatus(200);
//    }

    public function test_users_can_authenticate_using_the_login_screen()
    {
        $user = User::find(1);
        $credentials = [
            'email' => $user->email,
            'password' => 'password'
        ];
        $response = $this->post('/login', $credentials);
        $response->assertJson(function (AssertableJson $json) {
            $json->has('access_token');
            $json->has('token_type');
            $json->has('expires_in');
        });
    }

    public function test_users_can_authenticate_using_the_login_screen1()
    {
        $user = User::find(2);
        $credentials = [
            'email' => $user->email,
            'password' => 'password'
        ];
        $response = $this->post('/login', $credentials);
        $response->assertJson(function (AssertableJson $json) {
            $json->has('access_token');
            $json->has('token_type');
            $json->has('expires_in');
        });
    }

    public function test_users_can_authenticate_using_the_login_screen2()
    {
        $user = User::find(3);
        $credentials = [
            'email' => $user->email,
            'password' => 'password'
        ];
        $response = $this->post('/login', $credentials);
        $response->assertJson(function (AssertableJson $json) {
            $json->has('access_token');
            $json->has('token_type');
            $json->has('expires_in');
        });
    }



    /*public function test_selenium () {
        $host = 'http://localhost:4444';

        $capabilities = DesiredCapabilities::chrome();

        $driver = RemoteWebDriver::create($host, $capabilities);

// navigate to Selenium page on Wikipedia
        $driver->get('https://en.wikipedia.org/wiki/Selenium_(software)');

// write 'PHP' in the search box
        $driver->findElement(WebDriverBy::id('searchInput')) // find search input element
        ->sendKeys('PHP') // fill the search box
        ->submit(); // submit the whole form

// wait until 'PHP' is shown in the page heading element
        $driver->wait()->until(
            WebDriverExpectedCondition::elementTextContains(WebDriverBy::id('firstHeading'), 'PHP')
        );

// print title of the current page to output
        echo "The title is '" . $driver->getTitle() . "'\n";

// print URL of current page to output
        echo "The current URL is '" . $driver->getCurrentURL() . "'\n";

// find element of 'History' item in menu
        $historyButton = $driver->findElement(
            WebDriverBy::cssSelector('#ca-history a')
        );

// read text of the element and print it to output
        echo "About to click to button with text: '" . $historyButton->getText() . "'\n";

// click the element to navigate to revision history page
        $historyButton->click();

// wait until the target page is loaded
        $driver->wait()->until(
            WebDriverExpectedCondition::titleContains('Revision history')
        );

// print the title of the current page
        echo "The title is '" . $driver->getTitle() . "'\n";

// print the URI of the current page

        echo "The current URI is '" . $driver->getCurrentURL() . "'\n";

// delete all cookies
        $driver->manage()->deleteAllCookies();

// add new cookie
        $cookie = new Cookie('cookie_set_by_selenium', 'cookie_value');
        $driver->manage()->addCookie($cookie);

// dump current cookies to output
        $cookies = $driver->manage()->getCookies();
        print_r($cookies);

// terminate the session and close the browser
        $driver->quit();
    }*/
/*
    public function test_users_can_authenticate_using_the_login_screen()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_users_can_not_authenticate_with_invalid_password()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }
*/
}
