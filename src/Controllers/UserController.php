<?php

/**
 * User controller.
 *
 * @package     MikeWelsh\LittleDevils\Controllers\UserController
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Controllers;

use MikeWelsh\LittleDevils\Controllers\ConsoleController;
use MikeWelsh\LittleDevils\Exceptions\UserException;
use MikeWelsh\LittleDevils\Helpers\SecurityHelper;
use MikeWelsh\LittleDevils\Helpers\StringHelper;
use MikeWelsh\LittleDevils\Models\Group;
use MikeWelsh\LittleDevils\Models\Site;
use MikeWelsh\LittleDevils\Models\User;

class UserController
{
    public function createUser()
    {
        /*
         * Define the console conntroller.
         */
        $console = new ConsoleController();

        /*
         * Inform the user of the creation.
         */
        $console->info('Creating a user');

        /*
         * Define the user model.
         */
        $user = new User();

        $inputs = [
            'first_name' => 'Please enter the user\'s first name:',
            'last_name' => 'Please enter the user\'s last name:',
            'email' => 'Please enter the user\'s email:'
        ];

        foreach ($inputs as $var => $message) {
            /*
             * Read their input.
             */
            while (empty($user->$var)) {
                /*
                 * Ask the user for input.
                 */
                $console->input($message);
                $user->$var = readline();
                if (empty($user->$var)) {
                    $console->error('You must input some data');
                }
            }
        }

        /*
         * Ask the user for input.
         */
        $console->output('Available sites');
        while (empty($user->site_id)) {
            foreach ((new Site())->all() as $site) {
                $console->info($site->id . ' | ' . $site->name . ' | ' . $site->address);
            }
            $console->input('Please set the user\'s site Id from the list above:');

            /*
             * Read their input.
             */
            $user->site_id = intval(readline());

            if (empty($user->site_id)) {
                $console->error('You must input some data');
            }
        }

        /*
         * Ask the user for input.
         */
        $console->output('Available groups');
        while (empty($user->group_id)) {
            foreach ((new Groups())->all() as $group) {
                $console->info($group->id . ' | ' . $group->name);
            }
            $console->input('Please set the user\'s group Id from the list above:');

            /*
             * Read their input.
             */
            $user->group_id = intval(readline());

            if (empty($user->group_id)) {
                $console->error('You must input some data');
            }
        }

        /*
         * Ask the user for input.
         */
        $console->input('Would you like to enter a password (y) or randomly generate a one (n)? (y/N)');
        
        /*
         * Read their input.
         */
        $option = strtolower(readline());
        if ($option == 'y') {
            /*
             * Ask the user for input.
             */
            $console->input('Please enter a password:');
            
            /*
             * Read their input.
             */
            $user->password = SecurityHelper::encrypt(readline());
        } else {
            /*
             * Notify the user.
             */
            $console->info('Generating random password:');

            /*
             * Generate a random string.
             */
            $password = StringHelper::random(16);

            /*
             * Notify the user.
             */
            $console->output($password);
            
            /*
             * Save password.
             */
            $user->password = SecurityHelper::encrypt($password);
        }

        /*
         * Notify the user.
         */
        $console->info('Generating API key:');

        /*
         * Generate a random string.
         */
        $user->api_key = StringHelper::random();

        /*
         * Notify the user.
         */
        $console->output($user->api_key);
        
        /*
         * Save the user.
         */
        $user->save();

        /*
         * Output to the console for the user.
         */
        $console->done('User has been added to the system');
    }
}
