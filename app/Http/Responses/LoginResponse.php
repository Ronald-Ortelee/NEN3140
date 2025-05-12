<?php

namespace App\Http\Responses;

use Filament\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;

class LoginResponse implements LoginResponseContract
{
    /**
     * Build the response that should be sent after login.
     *
     * @param \Illuminate\Http\Request $request
     * @return RedirectResponse|Redirector
     */
    public function toResponse($request): RedirectResponse|Redirector
    {
        // Here you can decide where to send the user after login.
        // For a single-panel scenario, simply redirect to your panel's route.
        // Example: Redirect to a custom panel at "/panel" instead of "/dashboard".
        return redirect()->intended(url('/admin/duts'));
        
        // If you need to add conditional logic based on roles or the current panel,
        // you can use something like:
        //
        // $user = auth()->user();
        // if ($user->hasRole('admin')) {
        //     return redirect()->intended(route('admin.home'));
        // }
        // return redirect()->intended(route('user.home'));
    }
}
