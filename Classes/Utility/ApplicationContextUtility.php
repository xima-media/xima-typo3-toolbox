<?php

declare(strict_types=1);

namespace Xima\XimaTypo3Toolbox\Utility;

use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Xima\XimaTypo3Toolbox\Configuration;

class ApplicationContextUtility
{
    public function getContextTitle(): string
    {
        return Environment::getContext()->__toString();
    }

    public function getContextColor(): string
    {
        return $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS'][Configuration::EXT_KEY]['contextColors'][Environment::getContext()->__toString()] ?? 'transparent';
    }

    public function getWebsiteTitle(): string
    {
        $pid = $GLOBALS['TSFE']->id;
        $siteFinder = GeneralUtility::makeInstance(SiteFinder::class);
        $site = $siteFinder->getSiteByPageId($pid);
        return (string)$site->getConfiguration()['websiteTitle'];
    }
}
