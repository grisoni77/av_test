<?php
/**
 * Created by PhpStorm.
 * User: cris77
 * Date: 03/08/2016
 * Time: 16:23
 */

namespace SakeTest\Functional;


use Behat\Mink\Session;

class AltervistaWidget
{
    const user = 'prvdevav890';
    const pass = 'safmegocfu62';

    /**
     * @param Session $minkSession
     * @param string $user
     * @param string $pass
     * @return Session
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public static function doLogin(Session $minkSession, $user = null, $pass = null)
    {
        $user = $user ? $user : self::user;
        $pass = $pass ? $pass : self::pass;

        $baseUrl = 'https://aa.altervista.org/index.php?client_id=altervista&response_type=code&lang=it&redirect_uri=http%3A%2F%2Fit.altervista.org%2Fcplogin.php';

        $minkSession->visit($baseUrl);

        $page = $minkSession->getPage();

        $page->fillField('username', $user);
        $page->fillField('password', $pass);

        sleep(2);

        $button = $page->findButton('');
        $button->press();

//        return $minkSession->getPage()->getContent();
        return $minkSession;
    }


    /**
     * @param Session $minkSession
     * @param string $title
     * @param string $content
     * @param string $user
     * @return Session
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public static function doCreatePost(Session $minkSession, $title, $content, $user = null)
    {
        $user = $user ? $user : self::user;
        $baseUrl = 'http://'.$user.'.altervista.org/';
        $newPostPage = $baseUrl.'wp-admin/post-new.php';

        $minkSession->visit($newPostPage);

        $page = $minkSession->getPage();

        $page->fillField('title', $title);
// apri tab solo testo
        $page->pressButton('content-html');
        sleep(2);
        $page->fillField('content', $content);
        sleep(2);
        $page->pressButton('publish');
        sleep(5);

        return $minkSession;
    }

    /**
     * @param Session $minkSession
     * @param string $user
     * @return Session
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public static function doUploadFile(Session $minkSession, $user = null)
    {
        $user = $user ? $user : self::user;
        $baseUrl = 'http://'.$user.'.altervista.org/';
        $newMediaPage = $baseUrl.'wp-admin/media-new.php?browser-uploader';

        $minkSession->visit($newMediaPage);

        $page = $minkSession->getPage();

        $page->attachFileToField('async-upload', SERVER_RESOURCE_PATH.'leopardi.jpg');
        sleep(2);
        $page->pressButton('html-upload');
        sleep(5);

        return $minkSession;
    }

    public static function deleteImage(Session $minkSession, $user = null)
    {
        $user = $user ? $user : self::user;
        $baseUrl = 'http://'.$user.'.altervista.org/';
        $mediaPage = $baseUrl.'wp-admin/upload.php?mode=list';
        $minkSession->visit($mediaPage);
        sleep(2);
//        $page = $minkSession->getPage();
//        $page->clickLink('view-switch-list');
//        sleep(2);
        $page = $minkSession->getPage();
        $page->checkField('cb-select-all-1');
        $page->selectFieldOption('bulk-action-selector-top', 'delete');
        $page->pressButton('doaction');

        return $minkSession;
    }

    public static function goToImagePage(Session $minkSession, $user = null)
    {
        $user = $user ? $user : self::user;
        $baseUrl = 'http://'.$user.'.altervista.org/';
        $imgPageUrl = $baseUrl.'leopardi';

        $minkSession->visit($imgPageUrl);

        return $minkSession;
    }

    public static function doLogout(Session $minkSession, $user = null)
    {
        $user = $user ? $user : self::user;
        $baseUrl = 'http://'.$user.'.altervista.org/';
        $logoutUrl = $baseUrl.'wp-login.php?action=logout&_wpnonce=154c43839b';

        $minkSession->visit($logoutUrl);

        return $minkSession;
    }


    public static function goToBlogHome(Session $minkSession, $user = null)
    {
        $user = $user ? $user : self::user;
        $homeUrl = 'http://'.$user.'.altervista.org/';

        $minkSession->visit($homeUrl);

        return $minkSession;
    }
}