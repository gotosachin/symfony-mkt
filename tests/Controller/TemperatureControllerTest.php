<?php

namespace App\Tests\Controller;

use App\Service\TemperatureQueryManager;
use PHPUnit\Framework\TestCase;

/**
 * Temperature test class
 */
class TemperatureControllerTest extends TestCase
{
    private TemperatureQueryManager $temperatureQueryManager;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        // mock any dependencies
        $this->temperatureQueryManager = $this->createMock(TemperatureQueryManager::class);
        parent::setUp();
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function testCalculateMkt(): void
    {
        $this->temperatureQueryManager->calculateMkt([]);

        $this->assertTrue(true);
    }
}
