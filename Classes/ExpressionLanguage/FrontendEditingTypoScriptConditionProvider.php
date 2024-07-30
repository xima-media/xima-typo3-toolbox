<?php

declare(strict_types=1);

namespace Xima\XimaTypo3Toolbox\ExpressionLanguage;

use TYPO3\CMS\Core\ExpressionLanguage\AbstractProvider;
use Xima\XimaTypo3Toolbox\TypoScript\FrontendEditingConditionFunctionsProvider;

class FrontendEditingTypoScriptConditionProvider extends AbstractProvider
{
    public function __construct()
    {
        $this->expressionLanguageProviders = [
            FrontendEditingConditionFunctionsProvider::class,
        ];
    }
}
