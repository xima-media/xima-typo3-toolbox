<?php

declare(strict_types=1);

namespace Xima\XimaTypo3Toolbox\TypoScript;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;
use TYPO3\CMS\Core\Core\Environment;
use Xima\XimaTypo3Toolbox\Configuration;

class TechnicalContextConditionFunctionsProvider implements ExpressionFunctionProviderInterface
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
            'enableTechnicalContext',
            static fn () => null,
            static function () {
                return $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS'][Configuration::EXT_KEY]['technicalContext']['enable'] &&
                    !in_array(Environment::getContext()->__toString(), $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS'][Configuration::EXT_KEY]['technicalContext']['hideForContexts']);
            }
        );
    }
}
