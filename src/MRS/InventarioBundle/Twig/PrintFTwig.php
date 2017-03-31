<?php
/**
 * Created by PhpStorm.
 * User: marcio
 * Date: 31/03/17
 * Time: 14:49
 */

namespace MRS\InventarioBundle\Twig;


class PrintFTwig extends \Twig_Extension
{

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('print',array($this,'printR'))
        );
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        // TODO: Implement getName() method.
    }

    public function printR($var)
    {
        return var_export($var,true);
    }
}