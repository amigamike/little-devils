<?php

/**
 * People model.
 *
 * @package     MikeWelsh\LittleDevils\Models\People
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Models;

use MikeWelsh\LittleDevils\Models\Model;

class People extends Model
{
    /**
     * The name of the table.
     * @var string $table
     */
    protected $table = 'people';

    public $id = 0;
    public $type = '';
    public $first_name = '';
    public $last_name = '';
    public $dob = '';
    public $address_line_1 = '';
    public $address_line_2 = '';
    public $city = '';
    public $county = '';
    public $postcode = '';
    public $phone_no = '';
    public $email = '';
    public $status = 'active';
}
