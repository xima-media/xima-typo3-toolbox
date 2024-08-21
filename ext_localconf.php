<?php

use Xima\XimaTypo3Toolbox\Backend\ToolbarItems\ProjectStatusItem;
use Xima\XimaTypo3Toolbox\Configuration;
use Xima\XimaTypo3Toolbox\Controller\ContextController;

$GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['xt3'] = ['Xima\\XimaTypo3Toolbox\\ViewHelpers'];

// Generell
$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS'][Configuration::EXT_KEY]['contextColors'] = [
    'Production' => 'transparent',
    'Production/Standby' => '#2f9c91',
    'Production/Staging' => '#f39c12',
    'Development' => '#bd593a',
    'Development/DDEV' => '#bd593a',
];

// Custom toolbar item
$GLOBALS['TYPO3_CONF_VARS']['BE']['toolbarItems'][1719406254] = ProjectStatusItem::class;

// Technical Context
$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS'][Configuration::EXT_KEY]['technicalContext']['enable'] = true;
$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS'][Configuration::EXT_KEY]['technicalContext']['hideForContexts'] = [
    'Production',
    'Production/Standby',
];

// System Information Toolbar Entry
$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS'][Configuration::EXT_KEY]['systemInformationToolbar']['enable'] = true;
$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS'][Configuration::EXT_KEY]['systemInformationToolbar']['fileToCheck'] = 'index.php';

// Toolbar Item
$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS'][Configuration::EXT_KEY]['toolbarItem']['enable'] = true;

// Application Context Endpoint
$GLOBALS['TYPO3_CONF_VARS'][Configuration::EXT_KEY]['applicationContextEndpoint']['eID'] = 1719931549;
$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include'][$GLOBALS['TYPO3_CONF_VARS'][Configuration::EXT_KEY]['applicationContextEndpoint']['eID']] = ContextController::class . '::getContextAction';

// Axe Accessibility
$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS'][Configuration::EXT_KEY]['axeAccessibility']['enable'] = false;
$GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS'][Configuration::EXT_KEY]['axeAccessibility']['enableForContexts'] = [
    'Production/Staging',
    'Development/DDEV',
    'Development',
];
