<?php

use Xima\XimaTypo3Toolbox\Backend\ToolbarItems\ProjectStatusItem;
use Xima\XimaTypo3Toolbox\Configuration;

// Generell
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['contextColors'] = [
    'Production' => 'transparent',
    'Production/Standby' => '#2f9c91',
    'Staging' => '#f39c12',
    'Testing' => '#f39c12',
    'Testing/Stage' => '#f39c12',
    'Development' => '#bd593a',
    'Development/DDEV' => '#bd593a',
];

// Custom toolbar item
$GLOBALS['TYPO3_CONF_VARS']['BE']['toolbarItems'][1719406254] = ProjectStatusItem::class;

// Technical Context
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['technicalContext']['disable'] = false;
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['technicalContext']['hideForContexts'] = [
    'Production',
    'Production/Standby',
];

// System Information Toolbar Entry
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['systemInformationToolbar']['disable'] = false;
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['systemInformationToolbar']['fileToCheck'] = 'index.php';

// Toolbar Item
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['toolbarItem']['disable'] = false;
