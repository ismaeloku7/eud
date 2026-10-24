<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Compiled assets are not committed, so views must not depend on the Vite manifest in tests.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }
}
