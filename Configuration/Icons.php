<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;
use Xima\XimaTypo3Toolbox\Configuration;

return [
    'content-widget-overview' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:' . Configuration::EXT_KEY . '/Resources/Public/Icons/content-widget-overview.svg',
    ],
];
