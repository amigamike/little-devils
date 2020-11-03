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
    public $room_id = 0;
    public $title = '';
    public $relationship = '';
    public $first_name = '';
    public $last_name = '';
    public $dob = null;
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
            WHERE parents.deleted_at IS NULL AND type="parent" AND child_id=:id',
            [
                ':id' => $id
            ]
        );

        $data->contacts = $this->selectArray(
            'SELECT 
                contacts.id,
                people.first_name,
                people.last_name,
                people.phone_no,
                people.created_at
            FROM contacts 
            JOIN ' . $this->table . ' people ON people.id = contacts.person_id AND people.deleted_at IS NULL 
            WHERE contacts.deleted_at IS NULL AND type="contact" AND child_id=:id',
            [
                ':id' => $id
            ]
        );

        return $data;
    }
}
