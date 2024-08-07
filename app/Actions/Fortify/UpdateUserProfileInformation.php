<?php

namespace App\Actions\Fortify;

use App\Models\Attachment;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Illuminate\Support\Facades\Storage;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        // Sanitize and validate input
        $input = $this->sanitizeInput($input);

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'phone_no' => ['required'],
            'nick' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $path = 'images/profile/' . date('F');
            if ($user->photo) {
                $delFile = Storage::disk('s3')->delete($user->photo->file);
                if ($delFile) {
                    $file = Storage::disk('s3')->put($path, $input['photo']);
                    Attachment::find($user->photo->id)->update([
                        'file' => $file
                    ]);
                }
            } else {
                $file = Storage::disk('s3')->put($path, $input['photo']);
                Attachment::create([
                    'model' => 'user',
                    'model_id' => $user->id,
                    'uploaded_by' => auth()->user()->id,
                    'request_id' => null,
                    'file' => $file
                ]);
            }
        }

        if (
            $input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail
        ) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
                'nick' => $input['nick'],
                'phone_no' => $input['phone_no'],
            ])->save();
        }
    }

    /**
     * Sanitize input data.
     *
     * @param  array  $input
     * @return array
     */
    protected function sanitizeInput(array $input)
    {
        return [
            'name' => strip_tags(filterInput($input['name'])),
            'phone_no' => strip_tags(filterInput($input['phone_no'])),
            'nick' => strip_tags(filterInput($input['nick'])),
            'email' => strip_tags(filterInput($input['email'])),
            'photo' => isset($input['photo']) ? $input['photo'] : null,
        ];
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
