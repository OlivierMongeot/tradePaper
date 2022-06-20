<?php


namespace App\Twig;

use Twig\TwigFilter;
use Twig\Extension\AbstractExtension;


class AmountExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('amount', [$this, 'amount']),
        ];
    }

    public function amount($amount)
    {   
        $amount = $amount / 100;
        return number_format($amount, 2, '.', ' ') . ' $';
    }

}