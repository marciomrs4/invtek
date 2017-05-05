<?php

namespace MRS\InventarioBundle\Tests\Controller;

use MRS\InventarioBundle\Tests\Controller\UsuarioControllerTest;

class DefaultControllerTest extends UsuarioControllerTest
{
    public function testIndex()
    {
        $this->logIn();

        $crawler = $this->client->request('GET', '/home');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

    }

    public function testAccessHomeIsSuccess()
    {
        $this->logIn();

        $crawler = $this->client->request('GET', '/home');
        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }
}
