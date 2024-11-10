<?php declare(strict_types=1);

namespace Tests\Unit;

use App\Application;
use App\ServiceContainer;
use PHPUnit\Framework\TestCase;

final class ApplicationTest extends TestCase
{
    public function testApplicationCanRegisterServiceContainer()
    {
        $this->assertInstanceOf(
            ServiceContainer::class,
            Application::getServiceContainer()
        );
    }
}