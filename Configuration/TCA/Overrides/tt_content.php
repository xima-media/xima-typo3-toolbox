<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use Xima\XimaTypo3Toolbox\Configuration;

defined('TYPO3') || die('Access denied.');

ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'label' => 'LLL:EXT:' . Configuration::EXT_KEY . '/Resources/Private/Language/locallang.xlf:contentelement.technical_headline.label',
        'value' => 'ximatypo3toolbox_technicalheadline',
        'icon' => 'content-info',
        'group' => 'default',
        'description' => 'LLL:EXT:my_extension/Resources/Private/Language/locallang.xlf:contentelement.technical_headline.description',
    ],
    'textmedia',
    'after',
);

$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes']['ximatypo3toolbox_technicalheadline'] = 'content-info';

$GLOBALS['TCA']['tt_content']['types']['ximatypo3toolbox_technicalheadline'] = [
    'showitem' => '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                    --palette--;;general,
                    --palette--;;header,subheader,bodytext,
                --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
                    --palette--;;frames,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                    --palette--;;language,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                    --palette--;;hidden,
                    --palette--;;access,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,
                    categories,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,
                    rowDescription,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,',
    'columnsOverrides' => [
        'bodytext' => [
            'config' => [
                'enableRichtext' => true,
                'richtextConfiguration' => 'default',
            ],
        ],
    ],
];
