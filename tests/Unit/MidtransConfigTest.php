<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class MidtransConfigTest extends TestCase
{
    public function test_midtrans_configuration_is_available():
    {
        $config = config('midtrans');

        $this->assertIsArray($config);
        $this->assertArrayHasKey('server_key', $config);
        $this->assertArrayHasKey('client_key', $config);
        $this->assertArrayHasKey('is_production', $config);
    }
}
