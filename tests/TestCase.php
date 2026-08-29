<?php

namespace Tests;

use App\Http\Middleware\RedirectIfNotSetup;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(PreventRequestForgery::class);
        $this->withoutMiddleware(RedirectIfNotSetup::class);

        // Force array session driver to avoid database session issues in tests
        config(['session.driver' => 'array']);
    }
}
