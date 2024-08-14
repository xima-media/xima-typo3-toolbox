<?php

declare(strict_types=1);

namespace Xima\XimaTypo3Toolbox\ViewHelpers;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Exception;
use Xima\XimaTypo3Toolbox\Utility\SvgUtility;

/*
 * Usage example:
 *
 * <html xmlns:xt3="http://typo3.org/ns/Xima/XimaTypo3Toolbox/ViewHelpers" [...]
 *
 * <xt3:inlineSvg
        src="{pathToSource}"
        aria-hidden="true"
        class="myclass"
        width="600"
        height="300"
    />
 */
class InlineSvgViewHelper extends AbstractViewHelper
{
    /**
     * Initialize arguments.
     *
     * @throws Exception
     */
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('src', 'string', 'A path to a file', true);
        $this->registerArgument('id', 'string', 'Id to set in the svg');
        $this->registerArgument('class', 'string', 'Css class(es) for the svg');
        $this->registerArgument('width', 'string', 'Width of the svg.');
        $this->registerArgument('height', 'string', 'Height of the svg.');
        $this->registerArgument('viewBox', 'string', 'Specifies the view box for the svg');
        $this->registerArgument('aria-hidden', 'string', 'Sets the visibility of the svg for screen readers');
        $this->registerArgument('title', 'string', 'Title of the svg');
        $this->registerArgument('data', 'array', 'Array of data-attributes');
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function render(): string
    {
        if ((string)$this->arguments['src'] === '') {
            throw new \Exception('You must specify a string src.', 1630054037);
        }

        $fullPath = GeneralUtility::getFileAbsFileName((string)$this->arguments['src']);

        if (!file_exists($fullPath)) {
            return '';
        }

        if (pathinfo($fullPath, PATHINFO_EXTENSION) !== 'svg') {
            throw new \Exception('You must provide a svg file.', 1630401474);
        }

        $svgContent = file_get_contents($fullPath);
        if (!$svgContent) {
            throw new \Exception('The svg file must not be empty.', 1630401503);
        }

        $attributes = [
            'id' => $this->arguments['id'],
            'class' => $this->arguments['class'],
            'width' => $this->arguments['width'],
            'height' => $this->arguments['height'],
            'viewBox' => $this->arguments['viewBox'],
            'ariaHidden' => $this->arguments['aria-hidden'],
            'title' => $this->arguments['title'],
            'data' => $this->arguments['data'],
        ];

        /** @var SvgUtility $svgUtility */
        $svgUtility = GeneralUtility::makeInstance(SvgUtility::class);
        return $svgUtility->getInlineSvg($svgContent, $attributes);
    }
}
