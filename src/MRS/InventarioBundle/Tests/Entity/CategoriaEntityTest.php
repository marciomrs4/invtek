<?php

/**
 * Created by PhpStorm.
 * User: marcio
 * Date: 23/08/16
 * Time: 12:40
 */

namespace MRS\InventarioBundle\Tests\Entity;

use MRS\InventarioBundle\Entity\Tipoequipamento;



class TipoEquipamentoEntityTest extends \PHPUnit_Framework_TestCase
{


    public function testNumberCaracter()
    {
        $equipamento = new Tipoequipamento();

        $equipamento->setDescricao('computadores');

        $this->assertEquals('computadores',$equipamento->getDescricao());

    }

    public function testSetIconDescription()
    {
        $equipamento = new Tipoequipamento();

        $equipamento->setIcone('fa fa-edit');

        $this->assertEquals('fa fa-edit',$equipamento->getIcone());

    }

}