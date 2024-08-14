<?php

declare(strict_types=1);

namespace Xima\XimaTypo3Toolbox\Utility;

class SvgUtility
{
    /**
     * @param string $svgContent
     * @param array $tags
     * @return string
     * @throws \DOMException
     */
    public function getInlineSvg(
        string $svgContent,
        array $tags = []
    ): string {
        $svgElement = simplexml_load_string($svgContent);
        if (!$svgElement instanceof \SimpleXMLElement) {
            return '';
        }

        $domXml = dom_import_simplexml($svgElement);
        $ownerDocument = $domXml->ownerDocument;
        if (!$ownerDocument instanceof \DOMDocument) {
            return '';
        }

        if ($tags['title']) {
            $titleElement = $ownerDocument->createElement('title', htmlspecialchars((string)$tags['title']));
            if (!$titleElement instanceof \DOMElement) {
                return '';
            }
            $domXml->prepend($titleElement);
        }

        $tags['id'] = htmlspecialchars(trim((string)$tags['id']));
        if ($tags['id'] !== '') {
            $domXml->setAttribute('id', $tags['id']);
        }

        $tags['class'] = htmlspecialchars(trim((string)$tags['class']));
        if ($tags['class'] !== '') {
            $domXml->setAttribute('class', $tags['class']);
        }

        if ((int)$tags['height'] > 0) {
            $domXml->setAttribute('height', (string)$tags['height']);
        }

        if ((int)$tags['width'] > 0) {
            $domXml->setAttribute('width', (string)$tags['width']);
        }

        if ($tags['ariaHidden']) {
            $domXml->setAttribute('aria-hidden', $tags['ariaHidden']);
        }

        $tags['viewBox'] = htmlspecialchars(trim((string)$tags['viewBox']));
        if ($tags['viewBox'] !== '') {
            $domXml->setAttribute('viewBox', $tags['viewBox']);
        }

        if (is_array($tags['data'])) {
            foreach ($tags['data'] as $dataAttributeKey => $dataAttributeValue) {
                $dataAttributeKey = htmlspecialchars(trim((string)$dataAttributeKey));
                $dataAttributeValue = htmlspecialchars(trim((string)$dataAttributeValue));
                if ($dataAttributeKey !== '' && $dataAttributeValue !== '') {
                    $domXml->setAttribute('data-' . $dataAttributeKey, $dataAttributeValue);
                }
            }
        }

        return (string)$ownerDocument->saveXML($ownerDocument->documentElement);
    }
}
