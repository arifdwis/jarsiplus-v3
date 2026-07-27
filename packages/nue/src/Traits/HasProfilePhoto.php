<?php

namespace Novay\Nue\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Novay\Nue\Features;

trait HasProfilePhoto
{
    /**
     * Update the user's profile photo.
     *
     * @param  \Illuminate\Http\UploadedFile  $photo
     * @return void
     */
    public function updateProfilePhoto(UploadedFile $photo)
    {
        tap($this->photo, function ($previous) use ($photo) {
            $this->forceFill([
                'photo' => $photo->storePublicly(
                    'profile-photos', ['disk' => $this->profilePhotoDisk()]
                ),
            ])->save();

            if ($previous) {
                Storage::disk($this->profilePhotoDisk())->delete($previous);
            }
        });
    }

    /**
     * Delete the user's profile photo.
     *
     * @return void
     */
    public function deleteProfilePhoto()
    {
        if (! Features::managesProfilePhotos()) {
            return;
        }

        if (is_null($this->photo)) {
            return;
        }

        Storage::disk($this->profilePhotoDisk())->delete($this->photo);

        $this->forceFill([
            'photo' => null,
        ])->save();
    }

    /**
     * Get the URL to the user's profile photo.
     *
     * @return string
     */
    public function getPhotoUrlAttribute()
    {
        return $this->photo
                    ? Storage::disk($this->profilePhotoDisk())->url($this->photo)
                    : $this->defaultPhotoUrl();
    }

    /**
     * Get the default profile photo URL if no profile photo has been uploaded.
     *
     * @return string
     */
    protected function defaultPhotoUrl()
    {
        $name = trim(collect(explode(' ', $this->name))->map(function ($segment) {
            return mb_substr($segment, 0, 1);
        })->join(' '));

        return 'https://ui-avatars.com/api/?name='.urlencode($name).'&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Get the disk that profile photos should be stored on.
     *
     * @return string
     */
    protected function profilePhotoDisk()
    {
        return isset($_ENV['VAPOR_ARTIFACT_NAME']) ? 's3' : config('nue.profile_photo_disk', 'public');
    }
}
