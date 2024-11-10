<?php declare(strict_types=1);

namespace Tests\Unit\Application;

use PHPUnit\Framework\TestCase;

final class EnvironmentTest extends TestCase
{
    public function testEnvironmentCanBeLoaded(): void
    {
        $this->assertNotEmpty($_ENV);
    }
}
