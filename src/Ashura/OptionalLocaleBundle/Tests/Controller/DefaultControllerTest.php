<?php
/**
 * Created by PhpStorm.
 * User: Dominik Müller (Ashura)
 * Date: 25.12.15
 * Time: 08:04
 *
 * @link http://aimei.ch/developers/Ashura
 */

namespace Ashura\OptionalLocaleBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class DefaultControllerTest
 *
 * @package Ashura\OptionalLocaleBundle\Tests\Controller
 */
class DefaultControllerTest extends WebTestCase
{
    /**
     * Tests if the english translations are available.
     */
    public function testEnglischShowAction()
    {
        $client  = static::createClient();
        $crawler = $client->request('GET', '/en/ashura/optional_locale_test_route');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertTrue($crawler->filter('html:contains("Welcome to")')->count() === 1);
    }

    /**
     * Tests if the german translations are available.
     */
    public function testGermanShowAction()
    {
        $client  = static::createClient();
        $crawler = $client->request('GET', '/de/ashura/optional_locale_test_route');

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertTrue($crawler->filter('html:contains("Willkommen bei")')->count() === 1);
    }


    /**
     * Tests hidden english translations.
     */
    public function testOptionalEnglishShowAction()
    {
        $client  = static::createClient();
        $crawler = $client->request('GET', 'ashura/optional_locale_test_route', array(), array(),
            array('HTTP_ACCEPT_LANGUAGE' => 'en')
        );

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertTrue($crawler->filter('html:contains("Welcome to")')->count() === 1);

        $crawler = $client->request('GET', '/ashura/optional_locale_test_route', array(), array(),
            array('HTTP_ACCEPT_LANGUAGE' => 'en')
        );

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertTrue($crawler->filter('html:contains("Welcome to")')->count() === 1);
    }

    /**
     * Tests hidden german translations.
     */
    public function testOptionalGermanShowAction()
    {
        $client  = static::createClient();
        $crawler = $client->request('GET', 'ashura/optional_locale_test_route', array(), array(),
            array('HTTP_ACCEPT_LANGUAGE' => 'de')
        );

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertTrue($crawler->filter('html:contains("Willkommen bei")')->count() === 1);

        $crawler = $client->request('GET', '/ashura/optional_locale_test_route', array(), array(),
            array('HTTP_ACCEPT_LANGUAGE' => 'de')
        );

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertTrue($crawler->filter('html:contains("Willkommen bei")')->count() === 1);
    }

}