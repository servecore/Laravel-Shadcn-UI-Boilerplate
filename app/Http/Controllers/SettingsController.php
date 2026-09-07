<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SettingsController extends Controller
{
    /**
     * Show the settings page.
     */
    public function index(): View
    {
        return view('pages.settings.index', [
            'preferences' => Auth::user()->preferences ?? [],
        ]);
    }

    /**
     * Update the user's notification preferences.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'comm_emails' => ['boolean'],
            'marketing_emails' => ['boolean'],
            'social_emails' => ['boolean'],
        ]);

        // Persist on the user record instead of the session so preferences
        // survive logout/login (and multiple devices).
        Auth::user()->update([
            'preferences' => [
                'comm_emails' => $request->boolean('comm_emails'),
                'marketing_emails' => $request->boolean('marketing_emails'),
                'social_emails' => $request->boolean('social_emails'),
                'security_emails' => true,
            ],
        ]);

        return back()->with('status', 'Notification preferences saved.');
    }
}
