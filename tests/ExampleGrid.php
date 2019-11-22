<?php

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverKeys;

class GitHubTest extends PHPUnit_Framework_TestCase {

   protected $url = 'https://github.com/qajoinville';

   /**
    * @var \RemoteWebDriver
   */
   protected $webDriver;

   public function setUp()
   {
      $this->webDriver = RemoteWebDriver::create('http://172.17.0.3:5555/wd/hub', DesiredCapabilities::chrome());
   }

   public function tearDown()
   {
      $this->webDriver->close();
   }

   public function testGitHubHome()
   {
      $this->webDriver->get($this->url);
      
      // checking that page title contains word 'GitHub'
      $this->assertContains('QA JOINVILLE', $this->webDriver->getTitle());
   }

   public function testSearch()
   {
      $this->webDriver->get($this->url);

      // find search field by its id
      $search = $this->webDriver->findElement(
         WebDriverBy::xpath('/html/body/div[1]/header/div/div[2]/div[2]/div/div/div/form/label/input[1]')
      );
      
      $search->click();

      // typing into field
      $search->sendKeys('user:qajoinville qajoinville10_2019');
      $search->sendKeys(WebDriverKeys::ENTER);


      $firstResult = $this->webDriver->findElement(
         // some CSS selectors can be very long:
         WebDriverBy::xpath('//*[@id="js-pjax-container"]/div/div[3]/div/ul/li/div[1]/h3/a')
      );

      // we expect that facebook/php-webdriver was the first result
      $firstResult->click();

      $this->assertContains("qajoinville10_2019",$this->webDriver->getTitle());
      $this->assertEquals('https://github.com/qajoinville/qajoinville10_2019', $this->webDriver->getCurrentURL());
   }
}