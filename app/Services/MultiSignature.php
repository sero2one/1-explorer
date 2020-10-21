<?php

declare(strict_types=1);

namespace App\Services;

use App\Facades\Network;
use Symfony\Component\Process\Process;

final class MultiSignature
{
    public static function address(int $min, array $publicKeys): string
    {
        $command = sprintf(
            "node %s %s '%s'",
            base_path('musig.js'),
            Network::alias(),
            json_encode(['min' => $min, 'publicKeys' => $publicKeys])
        );

        $process = Process::fromShellCommandline($command);
        $process->run();

        return trim($process->getOutput());
    }
}