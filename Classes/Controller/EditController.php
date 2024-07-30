<?php

declare(strict_types=1);

namespace Xima\XimaTypo3Toolbox\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Core\Http\RedirectResponse;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class EditController
{
    public function editContentElement(ServerRequestInterface $request): ResponseInterface
    {
        $routing = $request->getAttribute('routing');
        $id = $routing['identifier'];

        $returnUrl = urldecode($request->getQueryParams()['returnUrl']);
        $uriBuilder = GeneralUtility::makeInstance(UriBuilder::class);
        $uri = $uriBuilder->buildUriFromRoute(
            'record_edit',
            [
                'edit' => [
                    'tt_content' => [
                        $id => 'edit',
                    ],
                ],
                'returnUrl' => $returnUrl,
            ],
        );
        return new RedirectResponse($uri);
    }
    public function editPage(ServerRequestInterface $request): ResponseInterface
    {
        $routing = $request->getAttribute('routing');
        $id = $routing['identifier'];
        $returnUrl = urldecode($request->getQueryParams()['returnUrl']);

        $queryBuilder = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\ConnectionPool::class)->getQueryBuilderForTable('tt_content');
        $contentElement = $queryBuilder
            ->select('*')
            ->from('tt_content')
            ->where(
                $queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter($id, \TYPO3\CMS\Core\Database\Connection::PARAM_INT))
            )
            ->executeQuery()->fetchAssociative();

        $pid = (int)$contentElement['pid'];

        $uriBuilder = GeneralUtility::makeInstance(UriBuilder::class);
        $uri = $uriBuilder->buildUriFromRoute(
            'web_layout',
            [
                'id' => $pid,
                'returnUrl' => $returnUrl,
            ],
        );
        return new RedirectResponse($uri);
    }
}