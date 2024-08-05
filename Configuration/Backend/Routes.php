<?php

return [
    'editable_content_elements' => [
        'path' => '/editable-content-elements',
        'access' => 'public',
        'target' => \Xima\XimaTypo3Toolbox\Controller\EditController::class . '::editableContentElementsByPage',
    ],
];
