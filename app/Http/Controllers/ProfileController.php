<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\Client\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $user = $request->user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update profile information
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            // email readonly in form, but validate if you allow edit:
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20', Rule::unique('users')->ignore($user->id)],
            'address' => ['nullable', 'string', 'max:1000'],
            'avatar' => ['nullable', 'image', 'max:2048'], // max 2MB
            'cccd' => [
                    'nullable',
                    'digits:12',
                    function ($attribute, $value, $fail) use ($user) {
                        $hash = hash('sha256', $value);

                        $exists = \App\Models\Client\User::where('cccd_hash', $hash)
                            ->where('id', '!=', $user->id)
                            ->exists();

                        if ($exists) {
                            $fail('CCCD đã tồn tại trong hệ thống.');
                        }
                    },
                ],
        ];

        $validated = $request->validate($rules);
        if (isset($validated['cccd']) && $validated['cccd'] !== $user->cccd) {
        $user->cccd_verified_at = null;
        }

        // If phone changed -> clear phone_verified_at (require reverify)
        if (isset($validated['phone']) && $validated['phone'] !== $user->phone) {
            $user->phone_verified_at = null;
            // Optionally trigger SMS verification here
        }

        // Avatar handling
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');

            // store on public disk: storage/app/public/avatars/...
            $path = $file->store('avatars', 'public');

            // delete old avatar if exists and is under storage
            if ($user->avatar_url) {
                // If avatar_url stored as Storage::url($path) (like '/storage/...'), attempt to remove old file
                $previousPath = str_replace('/storage/', '', parse_url($user->avatar_url, PHP_URL_PATH));
                if ($previousPath && Storage::disk('public')->exists($previousPath)) {
                    Storage::disk('public')->delete($previousPath);
                }
            }

            // Save public url
            $validated['avatar_url'] = Storage::url($path); // produces '/storage/avatars/xxx.ext'
        }

        // Update last_login_at not from profile update (server sets on login)
        // Remove restricted fields — we do not allow user to update role/is_active via this form
        unset($validated['email_verified_at'], $validated['activation_token'], $validated['activation_token_created_at'], $validated['role'], $validated['is_active']);
        unset($validated['cccd_verified_at']);
        // Update model
        $user->fill($validated);
        $user->save();

        return back()->with('status', 'profile-updated');
    }

}
