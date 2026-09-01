<?php

namespace Tests\Feature\Toast;

use Tests\TestCase;

class ReusableToastTest extends TestCase
{
    public function test_toast_helper_can_store_a_success_notification_in_session(): void
    {
        toast()->success('Profile updated successfully.', 'Profile saved');

        $this->assertNotEmpty(session('toast'));
        $this->assertSame('success', session('toast')[0]['variant']);
        $this->assertSame('Profile saved', session('toast')[0]['title']);
        $this->assertSame('Profile updated successfully.', session('toast')[0]['description']);
    }
}
