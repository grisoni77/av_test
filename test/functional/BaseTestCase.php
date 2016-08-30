<?php
/**
 * Sandro Keil (https://sandro-keil.de)
 *
 * @link      http://github.com/sandrokeil/docker-selenium-grid-phpunit for the canonical source repository
 * @copyright Copyright (c) 2016 Sandro Keil
 * @license   http://github.com/sandrokeil/docker-selenium-grid-phpunit/blob/master/LICENSE.md New BSD License
 */

namespace SakeTest\Functional;

use Behat\Mink\Driver\Selenium2Driver;
use Behat\Mink\Session;
use PHPUnit_Framework_TestCase as TestCase;

class BaseTestCase extends TestCase
{
    /**
     * @return Session
     */
    protected static function setupSeleniumSession($browser)
    {
        // selenium version is important
        // selenium grid
//        $driver = new Selenium2Driver(
//            $browser,
//            ['selenium-version' => '2.53.0'],
//            'http://hub:4444/wd/hub'
//        );
        // selenium grid con dockerized phunit
        $driver = new Selenium2Driver(
            $browser,
            ['selenium-version' => '2.53.0'],
            'http://172.17.0.1:4444/wd/hub'
        );
        // selenium standalone server
//        $driver = new Selenium2Driver(
//            $browser,
//            ['selenium-version' => '2.53.0'],
//            'http://192.168.56.104:32786/wd/hub'
//        );
        // selenium standalone server su aws
//        $driver = new Selenium2Driver(
//            'firefox',
//            [
//                'selenium-version' => '2.53.0',
//                'firefox' => [
//                    'profile' => ' UEsDBBQAAAAIAHIAGknIXCQfTwAAAGUAAAAHAAAAdXNlci5qc1XLwQmAMAwF0LtTSE8KNgs4jET6K4WQ1qQFx/covvsbDjuaIS/BwAlGjc0Rq0apnAjKpyCFbc4sjnWfxjeeVtQ7i5CXS7kPg5PhHsV+5QVQSwECFAMUAAAACAByABpJyFwkH08AAABlAAAABwAAAAAAAAAAAAAAtoEAAAAAdXNlci5qc1BLBQYAAAAAAQABADUAAAB0AAAAAAA='
//                ],
//            ],
//            'http://52.59.148.153:4444/wd/hub'
//        );
        // selenium on browserstack
//        $driver = new Selenium2Driver(
//            $browser,
//            ["platform"=>"WINDOWS", "browserName"=>"firefox"],
//            "https://cris129:Gz45hAxFyUZJ5kMqY3Jb@hub-cloud.browserstack.com/wd/hub"
//        );
        $minkSession = new Session($driver);
        $minkSession->start();
        return $minkSession;
    }

    /**
     * @return Session
     */
    protected function setupGoutteSession() 
    {
        $driver = new \Behat\Mink\Driver\GoutteDriver();
        $minkSession = new \Behat\Mink\Session($driver);
        $minkSession->start();
        return $minkSession;
    }

    /**
     * Test search widget
     *
     * @param Session $minkSession
     */
    public function assertSearchForPhp(Session $minkSession)
    {
        $content = SearchWidget::searchFor('PHP', $minkSession);

        self::assertContains('PHP: Hypertext Preprocessor', $content);
    }

}
