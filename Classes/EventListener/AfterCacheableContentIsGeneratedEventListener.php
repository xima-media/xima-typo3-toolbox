<?php

declare(strict_types=1);

namespace Xima\XimaTypo3Toolbox\EventListener;

use DOMDocument;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Event\AfterCacheableContentIsGeneratedEvent;
use Xima\XimaTypo3Toolbox\Configuration;

class AfterCacheableContentIsGeneratedEventListener
{
    public function __invoke(AfterCacheableContentIsGeneratedEvent $event): void
    {
        if ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['technicalContext']['disable'] ||
            in_array(Environment::getContext()->__toString(), $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['technicalContext']['hideForContexts'])) {
            return;
        }

        $html = $event->getController()->content;
        $dom = new DOMDocument();
        @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $this->createTechnicalContextNode($dom, $this->getSiteTitleByRequest($event->getRequest()));
        $event->getController()->content = $dom->saveHTML();
    }

    private function createTechnicalContextNode(DOMDocument &$dom, string $title): void
    {
        $technicalContextNode = $dom->createElement('div', $title);
        $technicalContextNode->setAttribute('class', 'technical-context');
        $technicalContextNode->setAttribute('style', 'background-color:' . $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['contextColors'][Environment::getContext()->__toString()] ?? 'transparent');
        $technicalContextNode->setAttribute('data-context', Environment::getContext()->__toString());
        $technicalContextNode->setAttribute('title', 'This is part of the feature branch deployment and shows the actual site name of the website. This hint will not be displayed in production context.');


        $technicalContextCloseNode = $dom->createElement('button');
        $technicalContextCloseNode->setAttribute('class', 'technical-context__close');
        $technicalContextCloseNode->setAttribute('type', 'button');
        $technicalContextCloseNode->setAttribute('onclick', 'this.parentElement.remove()');
        $technicalContextCloseNode->setAttribute('aria-label', 'Close');
        $technicalContextNode->appendChild($technicalContextCloseNode);

        $cssFilePath = GeneralUtility::getFileAbsFileName('EXT:' . Configuration::EXT_KEY . '/Resources/Public/Css/TechnicalContext.css');
        $cssContent = file_get_contents($cssFilePath);

        $styleNode = $dom->createElement('style', $cssContent);
        $technicalContextNode->appendChild($styleNode);

        $dom->documentElement->appendChild($technicalContextNode);
    }

    private function getSiteTitleByRequest(ServerRequestInterface $request): string|bool
    {
        $pageId = $request->getAttribute('routing', [])->getPageId();
        $siteFinder = GeneralUtility::makeInstance(SiteFinder::class);
        $site = $siteFinder->getSiteByPageId($pageId);
        if ($site === null) {
            return false;
        }
        return $site->getConfiguration()['websiteTitle'];
    }
}
