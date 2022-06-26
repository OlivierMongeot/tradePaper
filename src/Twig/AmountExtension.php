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
            new TwigFilter('amount100', [$this, 'amount100']),
            new TwigFilter('parseQty', [$this, 'parseQty']),
        ];
    }

    public function amount($amount)
    {
        $amount = $amount / 100;
        return number_format($amount, 2, '.', ' ') . ' $';
    }

    public function amount100($amount)
    {
        if ($amount < 0.001) {
            return number_format($amount, 7, '.', ' ') . ' $';
        }
        if ($amount < 0.1) {
            return number_format($amount, 5, '.', ' ') . ' $';
        }

        return number_format($amount, 2, '.', ' ') . ' $';
    }

    public function parseQty($qty)
    {
        if ($qty < 0.001) {
            return number_format($qty, 7, '.', ' ') ;
        }
        if ($qty < 0.1) {
            return number_format($qty, 5, '.', ' ');
        }
        if ($qty > 1) {
            return number_format($qty, 2, '.', ' ');
        }

        return number_format($qty, 3, '.', ' ');
    }
}
