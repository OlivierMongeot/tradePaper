<?php


namespace App\Twig;

use Twig\TwigFilter;
use Twig\Extension\AbstractExtension;
use Doctrine\ORM\EntityManagerInterface;


class ParseNumberExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('filtreNumber', [$this, 'filtreNumber']),
        ];
    }

    public function filtreNumber(string $value)
    {
       // if number < 0.0001 then display 0.00
        //  if ($value < 0.00001) {
        //       return '0.00';
        //  }
         return $value;
    }

}