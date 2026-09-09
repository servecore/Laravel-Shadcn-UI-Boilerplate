<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
    ) {}

    /**
     * Display a listing of users.
     */
    public function index(Request $request): View
    {
        $users = $this->userService->paginateFiltered(
            filters: $request->only(['search', 'status']),
            perPage: 10,
        );

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
    public function store(StoreUserRequest $request): JsonResponse|RedirectResponse
    {
        $user = $this->userService->create($request->validated());

        if (isset($request->validated()['role'])) {
            $this->userService->assignRole($user, $request->validated()['role']);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'User created successfully.',
                'user' => $user,
            ], 201);
        }

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Return user data as JSON for the edit modal.
     */
    public function show(Request $request, User $user): JsonResponse
    {
        return response()->json([
            'user' => $user->only(['id', 'name', 'username', 'email', 'is_active']) + [
                'role' => $user->getRoleNames()->first() ?? 'user',
            ],
        ]);
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(Request $request, User $user): JsonResponse|View
    {
        if ($request->expectsJson()) {
            return $this->show($request, $user);
        }

        return view('pages.users.form', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified user.
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse|RedirectResponse
    {
        $validated = $request->validated();

        $this->userService->update($user->getKey(), $validated);

        if (isset($validated['role'])) {
            $this->userService->syncRoles($user->refresh(), [$validated['role']]);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'User updated successfully.',
                'user' => $user->refresh(),
            ]);
        }

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(Request $request, User $user): JsonResponse|RedirectResponse
    {
        if ($user->is(Auth::user())) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'You cannot delete your own account.',
                ], 422);
            }

            return back()->withErrors([
                'user' => 'You cannot delete your own account.',
            ]);
        }

        $this->userService->delete($user->getKey());

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'User deleted successfully.',
            ]);
        }

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }
}
