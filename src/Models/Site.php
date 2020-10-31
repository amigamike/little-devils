<?php

/**
 * Site model.
 *
 * @package     MikeWelsh\LittleDevils\Models\Site
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Models;

use MikeWelsh\LittleDevils\Models\Model;

class Site extends Model
{
    /**
     * The name of the table.
     * @var string $table
     */
    protected $table = 'sites';

    public $id = 0;
    public $name = '';
    public $address = '';

    public function getByAddress()
    {
        var_dump($_SERVER['SERVER_NAME']);
        $data = $this->select(
            'SELECT * FROM ' . $this->table . ' WHERE address=:address',
            [
                ':address' => $_SERVER['SERVER_NAME']
            ]
        );

        if (empty($data)) {
            return null;
        }

        foreach ($data as $col => $value) {
            $this->$col = $value;
        }

        return $this;
    }
}
