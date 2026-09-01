<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(): View
    {
        $users = User::latest()->paginate(10);

        return view('pages.users.index', [
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new user.
     */
    public function create(): View
    {
        return view('pages.users.form', [
            'user' => null,
        ]);
    }

    /**
     * Store a newly created user.
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user): View
    {
        return view('pages.users.form', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,'.$user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
        ]);

        // Only change the password when a non-blank value was provided.
        if (! empty($validated['password'])) {
            $user->update(['password' => $validated['password']]);
        }

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user): RedirectResponse
    {
        // Prevent an admin from deleting their own account.
        if ($user->is(auth()->user())) {
            return back()->withErrors([
                'user' => 'You cannot delete your own account.',
            ]);
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }
}
