<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * The root URL redirects authenticated users to the dashboard;
     * guests bounce to /login via the dashboard's auth middleware.
     */
    public function test_the_application_root_redirects_to_dashboard(): void
    {
        $this->get('/')
            ->assertRedirect(route('dashboard'));
    }
}
