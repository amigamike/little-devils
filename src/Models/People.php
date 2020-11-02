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
    public $title = '';
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

    public function getById($id)
    {
        $data = $this->select(
            'SELECT 
                *,
                DATE_FORMAT(dob, "%d/%m/%Y") AS dob
            FROM ' . $this->table . ' 
            WHERE id=:id',
            [
                ':id' => $id
            ]
        );

        $data->parents = $this->selectArray(
            'SELECT 
                people.*,
                DATE_FORMAT(dob, "%d/%m/%Y") AS dob
            FROM parents 
            JOIN ' . $this->table . ' people ON people.id = parents.parent_id AND people.deleted_at IS NULL 
            WHERE parents.deleted_at IS NULL AND child_id=:id',
            [
                ':id' => $id
            ]
        );

        return $data;
    }
}
