<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CompleteRegistrationRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Mail\RegistrationInviteMail;
use App\Models\RegistrationInvite;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class RegisterController extends Controller
{
    /**
     * Show the registration form. Only an email address is required; the rest
     * of the account is completed through an emailed invitation link.
     */
    public function showRegistrationForm(): View
    {
        if ($errors = session('errors')) {
            $messages = $errors->all();

            if (! empty($messages)) {
                toast()->error($messages[0], 'Unable to continue');
            }
        }

        return view('auth.register', [
            'invitationSent' => session('invitation_email'),
        ]);
    }

    /**
     * Issue a one-time registration invitation to the given email and send a
     * link that lets the visitor finish setting up their account.
     */
    public function register(RegisterRequest $request): RedirectResponse
    {
        $invite = RegistrationInvite::issue($request->validated('email'));

        Mail::to($invite->email)->send(new RegistrationInviteMail($invite));

        toast()->success('We sent a registration link to '.$invite->email.'. Click it to finish setting up your account.', 'Check your email');

        return redirect()->route('register')
            ->with('invitation_email', $invite->email);
    }

    /**
     * Show the form to finish registration for a valid invitation token.
     */
    public function showCompletionForm(string $token): View|RedirectResponse
    {
        $invite = RegistrationInvite::findByToken($token);

        if (! $invite || $invite->isRedeemed()) {
            toast()->error('The registration link is invalid or has expired. Please request a new one.', 'Unable to continue');

            return redirect()->route('register');
        }

        return view('auth.register-complete', [
            'email' => $invite->email,
            'token' => $token,
        ]);
    }

    /**
     * Create the user account once the invitation token is redeemed.
     */
    public function complete(CompleteRegistrationRequest $request, string $token): RedirectResponse
    {
        $invite = RegistrationInvite::findByToken($token);

        if (! $invite || $invite->isRedeemed()) {
            toast()->error('The registration link is invalid or has expired. Please request a new one.', 'Unable to continue');

            return redirect()->route('register');
        }

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $invite->email,
            'password' => $request->password,
            'is_active' => true,
        ]);

        $user->markEmailAsVerified();
        $user->assignRole('user');

        $invite->delete();

        Auth::login($user);

        return redirect()->route('dashboard')
            ->with('success', 'Your account has been created. Welcome!');
    }
}
