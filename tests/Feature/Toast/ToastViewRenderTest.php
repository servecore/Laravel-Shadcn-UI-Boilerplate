<?php

namespace Tests\Feature\Toast;

use Tests\TestCase;

class ToastViewRenderTest extends TestCase
{
    public function test_toaster_component_uses_valid_alpine_event_binding(): void
    {
        $html = view('components.toast.toaster', [
            'duration' => 4000,
            'positionClasses' => 'top-0 right-0',
            'initialToasts' => [],
        ])->render();

        $this->assertStringContainsString('x-data=', $html);
        $this->assertStringContainsString('x-on:notify.window', $html);
        $this->assertStringContainsString('x-on:toast-close.window', $html);
        $this->assertStringContainsString('this.$dispatch("toast-close"', $html);
        $this->assertStringNotContainsString('@notify.window', $html);
    }
}
