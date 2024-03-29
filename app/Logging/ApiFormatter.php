<?php

namespace App\Logging;

use Monolog\Formatter\LineFormatter;

class ApiFormatter
{
    public $dateFormat = 'Y F d H:i:s';

    public function __invoke($logger)
    {
        foreach($logger->getHandlers() as $handler) {
            $handler->setFormatter(
                new LineFormatter('[%datetime%] %channel%.%level_name%: %message% %context% []
', $this->dateFormat, true
                )
            );
        }
    }
}
