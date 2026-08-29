<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

class VerifyEmailController extends Controller
{
    /**
     * Show the email verification notice.
     */
    public function showVerificationForm(): View
    {
        return view('auth.verify-email');
    }

    /**
     * Mark the authenticated user's email address as verified.
     */
    public function verify(Request $request): RedirectResponse
    {
        if (! hash_equals(
            (string) $request->route('id'),
            (string) Auth::id()
        )) {
            abort(403);
        }

        if (! URL::hasValidSignature($request)) {
            abort(403);
        }

        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('demo.dashboard'));
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->intended(route('demo.dashboard'));
    }

    /**
     * Send a new email verification notification.
     */
    public function sendVerification(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('demo.dashboard'));
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
