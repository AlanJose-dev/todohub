<?php declare(strict_types=1);

namespace Tests\Unit\Application;

use App\Facades\Support\DB;
use PHPUnit\Framework\TestCase;

final class DatabaseTest extends TestCase
{
    public function testDatabaseCanConnectSuccessfully(): void
    {
        $this->assertInstanceOf(\PDO::class, DB::connection());
    }
}
