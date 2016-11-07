<?php

namespace MRS\InventarioBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class EquipamentoControllerTest extends WebTestCase
{

    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    /**
     * @group Class
     */
    public function testIfControllerEquipamentoExist()
    {
        $this->assertTrue(class_exists('MRS\InventarioBundle\Controller\EquipamentoController'));
    }

    public function testRouteAcessCode()
    {
        $this->logIn();

        $crawler = $this->client->request('GET', '/cadastro/equipamento/');

        $this->assertEquals(200,$this->client->getResponse()->getStatusCode());
    }


    public function testRouteAcessIsSuccessful()
    {
        $this->logIn();

        $crawler = $this->client->request('GET', '/cadastro/equipamento/');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    public function testCreateIsAccessToPost()
    {
        $this->logIn();

        $crawler = $this->client->request('POST', '/cadastro/equipamento/new');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    public function testShowIsAccessSuccessFull()
    {
        $this->logIn();

        $crawler = $this->client->request('GET', '/cadastro/equipamento/1');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    public function testEditIsAccessSuccessFull()
    {
        $this->logIn();

        $crawler = $this->client->request('GET', '/cadastro/equipamento/1/edit');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    public function testEditPostIsAccessSuccessFull()
    {
        $this->logIn();

        $crawler = $this->client->request('POST', '/cadastro/equipamento/1/edit');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    private function logIn()
    {
        $session = $this->client->getContainer()->get('session');

        // the firewall context (defaults to the firewall name)
        $firewall = 'secured_area';

        $token = new UsernamePasswordToken('admin', 'admin', $firewall, array('ROLE_ADMIN'));
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }

    /*
    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/cadastro/equipamento/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /cadastro/equipamento/");
        $crawler = $client->click($crawler->selectLink('Create a new entry')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'mrs_inventariobundle_equipamento[field_name]'  => 'Test',
            // ... other fields to fill
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('td:contains("Test")')->count(), 'Missing element td:contains("Test")');

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Update')->form(array(
            'mrs_inventariobundle_equipamento[field_name]'  => 'Foo',
            // ... other fields to fill
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan(0, $crawler->filter('[value="Foo"]')->count(), 'Missing element [value="Foo"]');

        // Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/Foo/', $client->getResponse()->getContent());
    }

    */
}
