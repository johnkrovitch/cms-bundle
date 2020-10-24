<?php

namespace JK\CmsBundle\Twig;

use Carbon\Carbon;
use DateTime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class DateExtension extends AbstractExtension
{
    /**
     * @var string
     */
    private $locale;

    public function __construct(string $locale = 'en')
    {
        $this->locale = $locale;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('cms_date_diff', [
                $this,
                'getDateDiff',
            ]),
        ];
    }

    public function getDateDiff(DateTime $date): string
    {
        return Carbon::now($date->getTimezone())
            ->locale($this->locale)
            ->subSeconds(time() - (int) $date->format('u'))
            ->diffForHumans()
        ;
    }
}
