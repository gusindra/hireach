<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Auth\Access\Gate;

class ListGates extends Command
{
    protected $signature = 'gate:list';
    protected $description = 'List all defined gates in Laravel';

    protected $gate;

    public function __construct(Gate $gate)
    {
        parent::__construct();
        $this->gate = $gate;
    }

    protected function getClosureContents(\Closure $closure)
    {
        $reflection = new \ReflectionFunction($closure);
        $closureCode = file($reflection->getFileName());

        $startLine = $reflection->getStartLine();
        $endLine = $reflection->getEndLine();

        $contents = array_slice($closureCode, $startLine - 1, $endLine - $startLine + 1);

        return implode('', $contents);
    }

    public function handle()
    {
        $gates = $this->gate->abilities();
        $self = $this;

        $tableData = array_reduce(array_keys($gates), function ($carry, $key) use ($gates, $self) {
            $value = $gates[$key];

            $carry[] = [
                'Gate Name' => $key,

            ];

            return $carry;
        }, []);

        $this->table(['Gate Name', 'Closure Contents'], $tableData);
    }
}
