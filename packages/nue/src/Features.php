<?php

namespace Novay\Nue;

class Features
{
    /**
     * Determine if the given feature is enabled.
     *
     * @param  string  $feature
     * @return bool
     */
    public static function enabled(string $feature)
    {
        return in_array($feature, config('nue.features', []));
    }

    /**
     * Determine if the feature is enabled and has a given option enabled.
     *
     * @param  string  $feature
     * @param  string  $option
     * @return bool
     */
    public static function optionEnabled(string $feature, string $option)
    {
        return static::enabled($feature) &&
               config("nue-options.{$feature}.{$option}") === true;
    }

    /**
     * Determine if the application is allowing profile photo uploads.
     *
     * @return bool
     */
    public static function managesProfilePhotos()
    {
        return static::enabled(static::profilePhoto());
    }

    /**
     * Enable the registration feature.
     *
     * @return string
     */
    public static function registration()
    {
        return 'registration';
    }

    /**
     * Enable the password reset feature.
     *
     * @return string
     */
    public static function resetPasswords()
    {
        return 'reset-passwords';
    }

    /**
     * Enable the email verification feature.
     *
     * @return string
     */
    public static function emailVerification()
    {
        return 'email-verification';
    }

    /**
     * Enable the update profile information feature.
     *
     * @return string
     */
    public static function updateProfile()
    {
        return 'update-profile';
    }

    /**
     * Enable the update email feature.
     *
     * @return string
     */
    public static function updateEmail()
    {
        return 'update-email';
    }

    /**
     * Enable the update password feature.
     *
     * @return string
     */
    public static function updatePassword()
    {
        return 'update-password';
    }

    /**
     * Enable the profile photo upload feature.
     *
     * @return string
     */
    public static function profilePhoto()
    {
        return 'profile-photo';
    }

    /**
     * Enable the account deletion feature.
     *
     * @return string
     */
    public static function terminateAccount()
    {
        return 'terminate-account';
    }
}
