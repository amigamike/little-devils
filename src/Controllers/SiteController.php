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
        $console->output('Creating a site');

        /*
         * Define the Api key model.
         */
        $site = new Site();

        /*
         * Ask the user for the site's name.
         */
        $console->input('Please enter a name for the site:');
        
        /*
         * Read their input.
         */
        $site->name = readline();

        /*
         * Ask the user for the address.
         */
        $console->input('Please enter the address for the site, i.e. test.com or 192.168.1.1:');
        
        /*
         * Read their input.
         */
        $site->address = readline();

        /*
         * Save the site.
         */
        $site->save();

        /*
         * Output to the console for the user.
         */
        $console->output('Site has been added to the system');
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
