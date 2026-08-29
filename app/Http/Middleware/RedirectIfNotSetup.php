<?php

namespace App\Http\Middleware;

use App\Http\Controllers\SetupWizardController;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotSetup
{
    /**
     * Handle an incoming request.
     *
     * If setup is not complete, redirect to the setup wizard.
     * Allow access to the /setup routes even without setup.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! SetupWizardController::isSetup() && ! $request->routeIs('setup.*')) {
            return redirect()->route('setup.step1');
        }

        if (SetupWizardController::isSetup() && $request->routeIs('setup.*')) {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
