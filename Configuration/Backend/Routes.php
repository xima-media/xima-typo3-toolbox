<?php

return [
    'edit_content_element_redirect' => [
        'path' => '/edit-content-element-redirect/{identifier}',
        'access' => 'public',
        'target' => \Xima\XimaTypo3Toolbox\Controller\EditController::class . '::editContentElement',
    ],
    'edit_page_redirect' => [
        'path' => '/edit-page-redirect/{identifier}',
        'access' => 'public',
        'target' => \Xima\XimaTypo3Toolbox\Controller\EditController::class . '::editPage',
    ],
];
