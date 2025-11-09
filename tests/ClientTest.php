<?php

namespace Tests;

use App\Models\Client;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function testExistsReturnsTrueForValidClientId(): void
    {
        $this->assertTrue(Client::exists(123));
    }

    public function testExistsReturnsFalseForInvalidClientId(): void
    {
        $this->assertFalse(Client::exists(999999));
    }

    public function testExistsReturnsFalseForNonPositiveId(): void
    {
        $this->assertFalse(Client::exists(0));
        $this->assertFalse(Client::exists(-1));
    }
}