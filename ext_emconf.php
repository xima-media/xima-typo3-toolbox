<?php

/** @var string $_EXTKEY */
$EM_CONF[$_EXTKEY] = [
    'title' => 'TYPO3 Toolbox',
    'description' => 'This extension provides several tools for TYPO3 integrators and developers.',
    'category' => 'module',
    'author' => 'Konrad Michalik',
    'author_email' => 'konrad.michalik@xima.de',
    'author_company' => 'XIMA MEDIA GmbH',
    'state' => 'stable',
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'php' => '8.1.0-8.99.99',
            'typo3' => '12.0.0-13.99.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
