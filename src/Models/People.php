<?php

/**
 * People model.
 *
 * @package     MikeWelsh\LittleDevils\Models\People
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Models;

use MikeWelsh\LittleDevils\Controllers\DatabaseController;
use MikeWelsh\LittleDevils\Models\Invoice;
use MikeWelsh\LittleDevils\Models\Model;
use MikeWelsh\LittleDevils\Models\Log;

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
    public $gender = '';
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
    public $biter = 0;
    public $toilet_trained = 0;
    public $status = 'present';

    /**
     * Return all the entries.
     *
     * @return array $return
     */
    public function all(string $query = ''): array
    {
        return parent::all(
            'SELECT
                p.*,
                CONCAT(first_name, " ", last_name) AS full_name,
                DATE_FORMAT(dob, "%d/%m/%Y") AS dob,
                rooms.name AS room_name 
            FROM ' . $this->table . ' p ' .
            'LEFT JOIN rooms ON rooms.id = p.room_id AND rooms.deleted_at IS NULL ' .
            'WHERE p.deleted_at IS NULL'
        );
    }

    public function getById($id)
    {
        $data = $this->select(
            'SELECT 
                *,
                CONCAT(first_name, " ", last_name) AS full_name,
                DATE_FORMAT(dob, "%d/%m/%Y") AS dob
            FROM ' . $this->table . ' 
            WHERE id=:id',
            [
                ':id' => $id
            ]
        );

        if (empty($data)) {
            return $data;
        }

        $data->room = $this->select(
            'SELECT 
                *
            FROM rooms
            WHERE id=:id',
            [
                ':id' => $data->room_id
            ]
        );

        $data->parents = $this->selectArray(
            'SELECT 
                people.*,
                CONCAT(first_name, " ", last_name) AS full_name,
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
                people.title,
                people.first_name,
                people.last_name,
                CONCAT(first_name, " ", last_name) AS full_name,
                people.phone_no,
                people.email,
                people.relationship,
                people.created_at
            FROM contacts 
            JOIN ' . $this->table . ' people ON people.id = contacts.person_id AND people.deleted_at IS NULL 
            WHERE contacts.deleted_at IS NULL AND child_id=:id',
            [
                ':id' => $id
            ]
        );

        $data->logs = (new Log())->selectArray(
            'SELECT 
                logs.*,
                CONCAT(users.first_name, " ", users.last_name) AS full_name,
                groups.name AS group_name
            FROM logs 
            JOIN users ON users.id = logs.user_id AND users.deleted_at IS NULL 
            JOIN groups ON groups.id = users.group_id AND groups.deleted_at IS NULL 
            WHERE logs.deleted_at IS NULL AND person_id=:id',
            [
                ':id' => $id
            ]
        );

        $data->invoices = (new Invoice())->selectArray(
            'SELECT 
                invoices.*,
                CONCAT(users.first_name, " ", users.last_name) AS full_name
            FROM invoices 
            JOIN ' . $this->table . ' people ON people.id = invoices.person_id AND people.deleted_at IS NULL 
            JOIN users ON users.id = invoices.user_id AND users.deleted_at IS NULL 
            WHERE invoices.deleted_at IS NULL AND invoices.person_id=:id',
            [
                ':id' => $id
            ]
        );

        return $data;
    }
}
