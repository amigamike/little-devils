<?php

/**
 * Invoice model.
 *
 * @package     MikeWelsh\LittleDevils\Models\Invoice
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Models;

use MikeWelsh\LittleDevils\Models\Model;

class Invoice extends Model
{
    /**
     * The name of the table.
     * @var string $table
     */
    protected $table = 'invoices';

    public $id = 0;
    public $user_id = 0;
    public $person_id = 0;
    public $type = '';
    public $amount = 0.00;
    public $note = '';
    public $status = 'outstanding';
}
