<?php

/**
 * Site controller.
 *
 * @package     MikeWelsh\LittleDevils\Controllers\SiteController
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Controllers;

use MikeWelsh\LittleDevils\Controllers\ConsoleController;
use MikeWelsh\LittleDevils\Exceptions\SiteException;
use MikeWelsh\LittleDevils\Models\Site;

class SiteController
{
    public function createSite()
    {
        /*
         * Define the console conntroller.
         */
        $console = new ConsoleController();

        /*
         * Inform the user of the creation.
         */
        $console->info('Creating a site');

        /*
         * Define the site model.
         */
        $site = new Site();

        $inputs = [
            'name' => 'Please enter a name for the site:',
            'address' => 'Please enter the address for the site, i.e. test.com or 192.168.1.1:'
        ];

        foreach ($inputs as $var => $message) {
            /*
             * Read their input.
             */
            while (empty($site->$var)) {
                /*
                 * Ask the user for input.
                 */
                $console->input($message);
                $site->$var = readline();
                if (empty($site->$var)) {
                    $console->error('You must input some data');
                }
            }
        }

        /*
         * Save the site.
         */
        $site->save();

        /*
         * Output to the console for the user.
         */
        $console->done('Site has been added to the system');
    }

    /**
     * Get the current site the user is accessing
     * the system on.
     *
     * @return Site $site
     */
    public function getSite()
    {
        /*
         * Get the site by the address.
         */
        $site = (new Site())->getByAddress();

        /*
         * Throw an error if the site is not found.
         */
        if (empty($site)) {
            throw new SiteException('Site not found');
        }

        return $site;
    }
}
