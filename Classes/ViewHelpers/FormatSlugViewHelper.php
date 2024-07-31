<?php

namespace Xima\XimaTypo3Toolbox\ViewHelpers;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;

/**
 * Format Slug ViewHelper
 *
 * This ViewHelper format a string to a slug.
 *
 * Usages:
 * ::
 *     <xt3:formatSlug>XYZ</xt3:formatSlug>
 */
class FormatSlugViewHelper extends AbstractViewHelper
{
    use CompileWithContentArgumentAndRenderStatic;
    public function initializeArguments(): void
    {
        $this->registerArgument('value', 'string', 'String to format');
    }

    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext): string
    {
        $value = $renderChildrenClosure();
        if (!is_string($value) && !(is_object($value) && method_exists($value, '__toString'))) {
            /** @phpstan-ignore-next-line */
            return $value;
        }
        return self::generateSlug(((string)$value));
    }

    public function resolveContentArgumentName(): string
    {
        return 'value';
    }

    public static function generateSlug(string $string, string $fallback = null, int $maxLength = 128): string
    {
        $string = trim(strtolower($string));

        $string = str_replace(['ä', 'ö', 'ü', 'ß'], ['ae', 'oe', 'ue', 'ss'], $string);

        // use transliterate for cyrillic and hebrew characters
        // https://www.php.net/manual/en/transliterator.transliterate.php
        $string = transliterator_transliterate('Any-Latin; Latin-ASCII', $string);

        $string = preg_replace('/[^a-z0-9]/', '-', $string);

        while (str_contains((string)$string, '--')) {
            $string = str_replace('--', substr('--', 0, 1), (string)$string);
        }

        if (strlen((string)$string) > $maxLength) {
            $string = substr((string)$string, 0, $maxLength);
        }

        if (empty($string)) {
            return $fallback;
        }

        return $string;
    }
}
