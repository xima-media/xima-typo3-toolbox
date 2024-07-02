<?php

declare(strict_types=1);

namespace Xima\XimaTypo3Toolbox\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ContextController extends ActionController
{
    public function getContextAction(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse([Environment::getContext()->__toString()]);
    }
}
