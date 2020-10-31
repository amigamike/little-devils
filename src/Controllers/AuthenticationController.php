<?php

/**
 * Authentication controller.
 *
 * @package     MikeWelsh\LittleDevils\Controllers\AuthenticationController
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Controllers;

use MikeWelsh\LittleDevils\Controllers\SessionController;
use MikeWelsh\LittleDevils\Controllers\SiteController;
use MikeWelsh\LittleDevils\Exceptions\AuthenticationException;
use MikeWelsh\LittleDevils\Exceptions\SessionException;
use MikeWelsh\LittleDevils\Helpers\PathHelper;
use MikeWelsh\LittleDevils\Helpers\SecurityHelper;
use MikeWelsh\LittleDevils\Models\Site;
use MikeWelsh\LittleDevils\Models\User;

class AuthenticationController
{
    /**
     * The name of the session.
     * @var string $session
     */
    private const SESSION_NAME = 'little_devils_auth';

    /**
     * Get the auth session.
     *
     * @param string $var
     * @return array|null
     */
    public function get(string $var = '')
    {
        /*
         * Get the session.
         */
        $session = (new SessionController())->get(self::SESSION_NAME);

        /*
         * If the var is set, grab that one from the session.
         */
        if ($var) {
            return !empty($session->$var) ? $session->$var : null;
        }

        /*
         * Return the full auth session.
         */
        return $session;
    }

    public static function getSessionName()
    {
        return self::SESSION_NAME;
    }

    /**
     * Validate using the api key.
     *
     * @param string $key
     */
    public function validApi(string $key)
    {
        /*
         * Get the user.
         */
        $user = (new User())->getByApiKey($key);
            
        /*
         * If the user's details are invalid, throw an error.
         */
        if (empty($user)) {
            throw new AuthenticationException('Invalid API Key');
        }

        /*
         * If the user is disabled, throw an error.
         */
        if ($user->status == 'disabled') {
            throw new AuthenticationException('Your account has been disabled');
        }

        $user->site = (new Site())->getById($user->site_id);

        if ($_SERVER['SERVER_NAME'] != $user->site->address) {
            throw new AuthenticationException('Invalid site');
        }

        $_REQUEST[self::SESSION_NAME] = $user;
    }

    /**
     * Trigger a login.
     *
     * @param array $data
     * @return void
     */
    public function login(array $data)
    {
        /*
         * Make sure the css key is valid.
         */
        if (!SecurityHelper::cssKeyValid($data['css_key'])) {
            throw new AuthenticationException('Invalid cross-site scripting security key');
        }

        /*
         * Clear the css key.
         */
        (new SessionController())->clear('css_key');

        /*
         * Get the current site.
         */
        $site = (new SiteController())->getSite();

        var_dump($site);
        die();

        /*
         * Get the user.
         */
        $user = (new User())->login(
            $site,
            $data['email'],
            Security::encrypt($data['password'])
        );

        /*
         * If the user's details are invalid, throw an error.
         */
        if (empty($user)) {
            throw new AuthenticationException('Invalid login details');
        }

        /*
         * If the user is disabled, throw an error.
         */
        if ($user->status == 'disabled') {
            throw new AuthenticationException('Your account has been disabled');
        }

        /*
         * All good, save the user to the session.
         */
        (new SessionController())->set(self::SESSION_NAME, $user);
    }

    /**
     * Trigger a logout.
     *
     * @return void
     */
    public function logout()
    {
        /*
         * Clear the session.
         */
        (new SessionController())->clear();
    }

    /**
     * Check to see that the user is authenticated and logged in.
     *
     * @return bool
     */
    public function valid(): bool
    {
        /*
         * Get the session.
         */
        try {
            $session = $this->get();
        } catch (SessionException $err) {
            return false;
        }

        /*
         * If the session is found, return true, its valid.
         */
        if (!empty($session)) {
            return true;
        }

        /*
         * The session is not valid, return false.
         */
        return false;
    }
}
