<?php
/**
 * Created by PhpStorm.
 * User: cris77
 * Date: 23/08/2016
 * Time: 10:18
 */

namespace SakeTest\Functional;

use Behat\Mink\Session;
use SakeTest\Functional\BaseTestCase as TestCase;
use WebDriver\Exception;

class AltervistaFirefoxTest extends TestCase
{
    /** @var Session */
    protected static $session = null;


    public static function setUpBeforeClass()
    {
        self::$session = self::setupSeleniumSession('firefox');
    }


    /**
     * Fa login su altervista blog
     */
    public function testAltervistaLogin()
    {
        self::$session = AltervistaWidget::doLogin(self::$session);
        $content = self::$session->getPage()->getContent();
        self::assertContains('Bacheca', $content);
    }


    /**
     * Crea un nuovo post
     * @depends testAltervistaLogin
     */
    public function testCreateBlogPost()
    {
        $title = 'nuovo post '.time();
        self::$session = AltervistaWidget::doCreatePost(self::$session, $title, 'contenuto del nuovo post');
        self::$session = AltervistaWidget::goToBlogHome(self::$session);
        $content = self::$session->getPage()->getContent();
        self::assertContains($title, $content);
    }

    /**
     * Upload di un file nella libreria
     * @depends testAltervistaLogin
     */
    public function testUploadFile()
    {
        self::$session = AltervistaWidget::doUploadFile(self::$session);
        self::$session = AltervistaWidget::goToImagePage(self::$session);
        $title = self::$session->getPage()->find('css', 'title')->getHtml();
        self::assertContains('leopardi', $title);

        self::$session = AltervistaWidget::deleteImage(self::$session);
        self::$session = AltervistaWidget::goToImagePage(self::$session);
        $title = self::$session->getPage()->find('css', 'title')->getHtml();
        self::assertNotContains('leopardi', $title);
    }

    /**
     * Logout
     * @depends testAltervistaLogin
     */
    public function testLogout()
    {
        self::$session = AltervistaWidget::doLogout(self::$session);
        $content = self::$session->getPage()->getContent();
        self::assertContains('Accedi con il tuo account Altervista', $content);
    }
}