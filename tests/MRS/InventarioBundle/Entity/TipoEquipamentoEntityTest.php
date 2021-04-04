<?php

/**
 * Created by PhpStorm.
 * User: marcio
 * Date: 23/08/16
 * Time: 12:40
 */

namespace MRS\InventarioBundle\Tests\Entity;

use MRS\InventarioBundle\Entity\Tipoequipamento;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class TipoEquipamentoEntityTest extends TestCase
{

    public function dataProvider()
    {
        $tipoEquipamento = new Tipoequipamento();

        $tipoEquipamento->setDescricao('description');

        return array(
            array($tipoEquipamento)
        );
    }

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

    /**
     * @dataProvider dataProvider
     */
    public function testIsObject($tipoEquipamento)
    {

        $this->assertEquals('object',gettype($tipoEquipamento));

        $this->assertTrue($tipoEquipamento->getId());
    }

//    public function testIsString()
//    {
//
//        $tipoequipamento = new Tipoequipamento();
//        $tipoequipamento->setDescricao('string');
//
//        $this->assertEquals('string',sprintf("%s",$tipoequipamento));
//    }

}