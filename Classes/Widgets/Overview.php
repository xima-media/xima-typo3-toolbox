<?php

declare(strict_types=1);

namespace Xima\XimaTypo3Toolbox\Widgets;

use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Dashboard\Widgets\WidgetConfigurationInterface;
use TYPO3\CMS\Dashboard\Widgets\WidgetInterface;
use TYPO3\CMS\Fluid\View\StandaloneView;
use Xima\XimaTypo3Toolbox\Configuration;

class Overview implements WidgetInterface
{
    public function __construct(
        protected readonly WidgetConfigurationInterface $configuration,
        protected array $options = []
    ) {
    }

    public function renderWidgetContent(): string
    {
        $template = GeneralUtility::getFileAbsFileName('EXT:' . Configuration::EXT_KEY . '/Resources/Private/Templates/Widgets/Overview.html');

        $view = GeneralUtility::makeInstance(StandaloneView::class);
        $view->setFormat('html');
        $view->setTemplateRootPaths(['EXT:' . Configuration::EXT_KEY . '/Resources/Private/Templates/Widgets/']);
        $view->setTemplatePathAndFilename($template);

        $view->assignMultiple([
            'configuration' => $this->configuration,
            'options' => $this->validateOptions(),
        ]);
        return $view->render();
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    private function validateOptions(): array
    {
        $preparedOptions = $this->validateAndSetDefaults($this->options, [
            'title' => $this->createGreeting(array_key_exists('greetingPrefix', $this->options) ? $this->options['greetingPrefix'] : '👋'),
            'description' => $this->getLanguageService()->sL('LLL:EXT:' . Configuration::EXT_KEY . '/Resources/Private/Language/locallang_be.xlf:widgets.overview.default.description'),
            'logo' => [
                'path' => 'EXT:xima_typo3_toolbox/Resources/Public/Icons/Extension.svg',
                'width' => 100,
                'alt' => 'Widget default logo',
            ],
        ]);

        if (array_key_exists('cards', $preparedOptions)) {
            $preparedOptions['cards'] = $this->validateCards($preparedOptions['cards']);
        }

        return $preparedOptions;
    }

    private function validateCards(array $cards): array
    {
        foreach ($cards as &$card) {
            if (!array_key_exists('title', $card) || !array_key_exists('description', $card)) {
                throw new \InvalidArgumentException('Each overview widget card must have a title and a description');
            }

            $card = $this->validateAndSetDefaults($card, [
                'title' => 'Default title',
                'description' => 'Default description',
                'icon' => 'install-manage-settings',
                'links' => $this->validateLinks($card['links']),
            ]);
        }

        return $cards;
    }

    private function validateLinks(array $links): array
    {
        foreach ($links as &$link) {
            $link = $this->validateAndSetDefaults($link, [
                'label' => 'Missing label',
                'url' => '#',
                'target' => '_self',
                'type' => 'default',
            ]);
        }

        return $links;
    }

    private function validateAndSetDefaults(array $input, array $structure): array
    {
        foreach ($structure as $key => $defaultValue) {
            if (!array_key_exists($key, $input)) {
                $input[$key] = $defaultValue;
            } elseif (is_array($defaultValue) && is_array($input[$key])) {
                $input[$key] = $this->validateAndSetDefaults($input[$key], $defaultValue);
            }
        }
        return $input;
    }

    private function createGreeting(string $defaultGreetingPrefix = '👋'): string
    {
        $currentTime = (int)date('H');
        if ($currentTime < 11) {
            $greeting = $this->getLanguageService()->sL('LLL:EXT:' . Configuration::EXT_KEY . '/Resources/Private/Language/locallang_be.xlf:widgets.overview.default.greeting.morning') . ', ';
        } elseif ($currentTime < 17) {
            $greeting = $this->getLanguageService()->sL('LLL:EXT:' . Configuration::EXT_KEY . '/Resources/Private/Language/locallang_be.xlf:widgets.overview.default.greeting.afternoon') . ', ';
        } elseif ($currentTime < 22) {
            $greeting = $this->getLanguageService()->sL('LLL:EXT:' . Configuration::EXT_KEY . '/Resources/Private/Language/locallang_be.xlf:widgets.overview.default.greeting.evening') . ', ';
        } else {
            $greeting = $this->getLanguageService()->sL('LLL:EXT:' . Configuration::EXT_KEY . '/Resources/Private/Language/locallang_be.xlf:widgets.overview.default.greeting.night') . ', ';
        }

        return $defaultGreetingPrefix . ' ' . $greeting . $GLOBALS['BE_USER']->user['username'];
    }

    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }
}
