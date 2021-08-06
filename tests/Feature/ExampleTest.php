<?php

namespace Tests\Feature;

use App\Models\Trip;
use App\Models\User;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
//    public function test_example()
//    {
//        $response = $this->get('/');
//
//        $response->assertStatus(200);
//    }

    public function test_eugenium () {
        $user = Trip::find(1);
        $host = 'http://localhost:4444';

        $capabilities = DesiredCapabilities::chrome();
        $driver = RemoteWebDriver::create($host, $capabilities);

        $driver->get('http://dummy.local');
        $driver->manage()->window()->fullscreen();

        $driver->wait()->until(WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::cssSelector("button.d-flex.btn.btn-outline-success")));
        $signInButton = $driver->findElement(WebDriverBy::cssSelector('button.d-flex.btn.btn-outline-success'));
        $signInButton->click();
        $driver->wait()->until(WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::id("floatingInput")));
        $driver->wait()->until(WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::id("floatingInput2")));
        $driver->wait()->until(WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::cssSelector(".modal-footer .btn.btn-primary")));
        $emailField = $driver->findElement(WebDriverBy::id('floatingInput'));
        $passwordField = $driver->findElement(WebDriverBy::id('floatingInput2'));
        $loginButton = $driver->findElement(WebDriverBy::cssSelector('.modal-footer .btn.btn-primary'));
        $emailField->sendKeys('bins.alejandrin@example.com');
        $passwordField->sendKeys('password');
        $loginButton->click();
        $driver->wait()->until(WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::cssSelector("a[href='/account']")));
        $driver->wait()->until(WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::cssSelector("button.d-flex.btn.btn-outline-warning")));
        try {
            $accountLink = $driver->findElement(WebDriverBy::cssSelector("a[href='/account']"));
            $logoutButton = $driver->findElement(WebDriverBy::cssSelector('button.d-flex.btn.btn-outline-warning'));
        } catch (\Exception $e) {
            $accountLink = false;
            $logoutButton = false;
        }
        $driver->quit();
        $this->assertTrue($logoutButton && $accountLink);
    }
}
