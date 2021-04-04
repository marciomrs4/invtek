<?php

/**
 * Created by PhpStorm.
 * User: marcio
 * Date: 23/08/16
 * Time: 12:40
 */

namespace MRS\InventarioBundle\Tests\Entity;

use MRS\InventarioBundle\Entity\TipoAcessoIp;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;


class TipoAcessoIpEntityTest extends TestCase
{


    public function testSetDescription()
    {
        $tipoAcessoIp = new TipoAcessoIp();

        $tipoAcessoIp->setNome('meu ip');

        $this->assertEquals('meu ip',$tipoAcessoIp->getNome());

    }


}