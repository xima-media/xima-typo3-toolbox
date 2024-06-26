<?php

namespace Xima\XimaTypo3Toolbox\Backend\ToolbarItems;

use TYPO3\CMS\Backend\Toolbar\ToolbarItemInterface;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Package\PackageManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;
use Xima\XimaTypo3Toolbox\Configuration;

class ProjectStatusItem implements ToolbarItemInterface
{
    /**
     * Checks whether the user has access to this toolbar item
     *
     * @return bool TRUE if user has access, FALSE if not
     */
    public function checkAccess(): bool
    {
        return true;
    }

    /**
     * Render "item" part of this toolbar
     *
     * @return string Toolbar item HTML
     */
    public function getItem(): string
    {
        if ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['toolbarItem']['disable']) {
            return '';
        }

        $view = GeneralUtility::makeInstance(StandaloneView::class);
        $view->setTemplatePathAndFilename(GeneralUtility::getFileAbsFileName('EXT:' . Configuration::EXT_KEY
            . '/Resources/Private/Templates/ToolbarItems/ProjectStatusItem.html'));
        return $view->assignMultiple([
            'version' => $this->getWebsiteVersion(),
            'context' => Environment::getContext(),
            'color' => $GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][Configuration::EXT_KEY]['contextColors'][Environment::getContext()->__toString()] ?? 'transparent',
        ])->render();
    }

    /**
     * Returns the version property from the project's composer.json
     */
    protected function getWebsiteVersion(): string
    {
        return GeneralUtility::makeInstance(PackageManager::class)->getComposerManifest(Environment::getProjectPath() . '/', true)->version;
    }

    /**
     * TRUE if this toolbar item has a collapsible drop down
     *
     * @return bool
     */
    public function hasDropDown(): bool
    {
        return false;
    }

    /**
     * Render "drop down" part of this toolbar
     *
     * @return string Drop down HTML
     */
    public function getDropDown(): string
    {
        return '';
    }

    /**
     * Returns an array with additional attributes added to containing <li> tag of the item.
     *
     * Typical usages are additional css classes and data-* attributes, classes may be merged
     * with other classes needed by the framework. Do NOT set an id attribute here.
     *
     * array(
     *     'class' => 'my-class',
     *     'data-foo' => '42',
     * )
     *
     * @return array List item HTML attributes
     */
    public function getAdditionalAttributes(): array
    {
        return [];
    }

    /**
     * Returns an integer between 0 and 100 to determine
     * the position of this item relative to others
     *
     * By default, extensions should return 50 to be sorted between main core
     * items and other items that should be on the very right.
     *
     * @return int 0 .. 100
     */
    public function getIndex(): int
    {
        return 0;
    }
}
