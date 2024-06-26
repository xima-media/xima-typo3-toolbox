<?php

declare(strict_types=1);

namespace Xima\XimaTypo3Toolbox\EventListener;

use TYPO3\CMS\Backend\Backend\Event\SystemInformationToolbarCollectorEvent;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Xima\XimaTypo3Toolbox\Configuration;

class LastDeploymentEventListener
{
    public function __invoke(SystemInformationToolbarCollectorEvent $systemInformation): void
    {
        if ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['systemInformationToolbar']['disable']) {
            return;
        }
        $path = GeneralUtility::getFileAbsFileName($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['systemInformationToolbar']['fileToCheck']);
        $lastModified = $this->getLastModifiedTime($path);
        if (class_exists(\IntlDateFormatter::class)) {
            $formatter = new \IntlDateFormatter(
                'de-DE',
                \IntlDateFormatter::FULL,
                \IntlDateFormatter::FULL,
                $GLOBALS['TYPO3_CONF_VARS']['SYS']['phpTimeZone'] ?: date_default_timezone_get() ?: 'Europe/Berlin',
                \IntlDateFormatter::GREGORIAN
            );
            $humanFormatDateTime = $formatter->format($lastModified);
        } else {
            $humanFormatDateTime = strftime('%a, %x %H:%M', $lastModified);
        }

        $systemInformation->getToolbarItem()->addSystemInformation(
            $this->getLanguageService()->sL('LLL:EXT:' . Configuration::EXT_KEY . '/Resources/Private/Language/locallang.xlf:usages.toolbar-label'),
            $humanFormatDateTime,
            'actions-refresh',
        );
    }

    private function getLastModifiedTime(string $path): int
    {
        $lastModifiedTime = 0;

        if (is_dir($path)) {
            $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
            foreach ($iterator as $fileinfo) {
                if ($fileinfo->isFile() && $fileinfo->getMTime() > $lastModifiedTime) {
                    $lastModifiedTime = $fileinfo->getMTime();
                }
            }
        } elseif (is_file($path)) {
            $lastModifiedTime = filemtime($path);
        }

        return $lastModifiedTime;
    }

    private function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }
}
