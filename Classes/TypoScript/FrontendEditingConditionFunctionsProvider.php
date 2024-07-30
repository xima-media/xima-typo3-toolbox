<?php

declare(strict_types=1);

namespace Xima\XimaTypo3Toolbox\TypoScript;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;
use Xima\XimaTypo3Toolbox\Configuration;

class FrontendEditingConditionFunctionsProvider implements ExpressionFunctionProviderInterface
{
    public function getFunctions(): array
    {
        return [
            $this->getWebserviceFunction(),
        ];
    }

    protected function getWebserviceFunction(): ExpressionFunction
    {
        return new ExpressionFunction(
            'enableFrontendEditing',
            static fn () => null,
            static function () {
                return $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS'][Configuration::EXT_KEY]['frontendEditing']['enable'] && $GLOBALS['BE_USER'];
            }
        );
    }
}
