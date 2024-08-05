<?php

declare(strict_types=1);

namespace Xima\XimaTypo3Toolbox\Event;

class FrontendEditingDropdownModifyEvent
{
    final public const NAME = 'xima_typo3_toolbox.frontend_editing.dropdown.modify';

    public function __construct(
        protected array $dropdownData
    ) {
    }

    public function getDropdownData(): array
    {
        return $this->dropdownData;
    }

    public function setDropdownData(array $dropdownData): void
    {
        $this->dropdownData = $dropdownData;
    }
}
