<?php

/**
 * People controller.
 *
 * @package     MikeWelsh\LittleDevils\Controllers\PeopleController
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Controllers;

use MikeWelsh\LittleDevils\Controllers\AuthenticationController;
use MikeWelsh\LittleDevils\Exceptions\NotFoundException;
use MikeWelsh\LittleDevils\Exceptions\PersonException;
use MikeWelsh\LittleDevils\Helpers\RequestHelper;
use MikeWelsh\LittleDevils\Models\Contact;
use MikeWelsh\LittleDevils\Models\Parents;
use MikeWelsh\LittleDevils\Models\People;
use MikeWelsh\LittleDevils\Models\Room;
use MikeWelsh\LittleDevils\Responses\JsonResponse;

class PeopleController
{
    private $address_lines = [
        'Side St',
        'Walker Ave',
        'Town Walk',
        'Eagle Hill',
        'Castle Rd',
        'Station Way'
    ];

    private $cities = [
        'Newway',
        'Broadcity',
        'Yorkville',
        'Folksville',
        'Poles'
    ];

    private $counties = [
        'County Cook',
        'North Walk',
        'Eastland'
    ];

    private $titles_male = ['Mr', 'Dr'];
    private $titles_female = ['Ms', 'Mrs', 'Dr'];

    private $domains = ['vagrant-do.com', 'mashmonkwhit.org', 'strongarmwashmate.co.uk', 'myemailishere.com'];
    private $postcodes = ['A', 'C', 'X', 'D'];

    /**
     * Add a person.
     *
     * @param array $params
     * @return JsonResponse
     */
    public static function add(array $params)
    {
        /*
         * Validate the api key.
         */
        (new AuthenticationController())->validApi();

        $data = new People();

        self::required($params);

        $data = self::set($params, $data);

        $data->save();

        self::setParent($params, $data);

        return new JsonResponse(
            'Person added',
            $data
        );
    }

    /**
     * Get a person.
     *
     * @param array $params
     * @return JsonResponse
     */
    public static function get(array $params)
    {
        /*
         * Validate the api key.
         */
        (new AuthenticationController())->validApi();

        $data = (new People())->getById($params['id']);

        if (empty($data)) {
            throw new NotFoundException('Person not found');
        }

        return new JsonResponse(
            'Found the person',
            $data
        );
    }

    /**
     * Get the people stats.
     *
     * @param array $params
     * @return JsonResponse
     */
    public static function list(array $params)
    {
        /*
         * Validate the api key.
         */
        (new AuthenticationController())->validApi();

        $model = new People();

        if (!empty($params['type'])) {
            $model->filter('type', $params['type']);
        }

        if (!empty($params['sort'])) {
            $direction = 'ASC';
            if (!empty($params['sd'])) {
                $direction = strtoupper($params['sd']);
            }
            $model->order($params['sort'], $direction);
        }

        if (!empty($params['query'])) {
            $model->likeOr(
                [
                    'first_name',
                    'last_name'
                ],
                $params['query']
            );
        }

        $data = $model
            ->paginate(
                (!empty($params['page']) ? intval($params['page']) : 1),
                (!empty($params['per_page']) ? intval($params['per_page']) : 25)
            )
            ->all();

        return new JsonResponse(
            'People list',
            $data,
            'success',
            200,
            $model->pagination
        );
    }

    /**
     * Build extra settings for a person.
     *
     * @param People $model
     * @return People $model
     */
    private function peopleExtra($model)
    {
        $model->phone_no = '0123 ';
        for ($iLoop = 0; $iLoop < 6; $iLoop++) {
            $model->phone_no .= rand(1, 9);
        }
    
        $model->email = strtolower($model->first_name) .
            '.' .
            strtolower($model->last_name) .
            '@' .
            $this->domains[rand(0, count($this->domains) - 1)];

        $model->address_line_1 = rand(1, 89) . ' ' . $this->address_lines[rand(0, count($this->address_lines) - 1)];
        $model->city = $this->cities[rand(0, count($this->cities) - 1)];
        $model->county = $this->counties[rand(0, count($this->counties) - 1)];
        $model->postcode = strtoupper(substr($model->county, 0, 2)) .
            rand(10, 40) .
            ' ' .
            rand(1, 9) .
            $this->postcodes[rand(0, count($this->postcodes) - 1)] .
            $this->postcodes[rand(0, count($this->postcodes) - 1)];

        return $model;
    }

    /**
     * Check the required params
     */
    private static function required($params)
    {
        $required = [
            "first_name",
            "last_name",
            "dob",
            "address_line_1",
            "city",
            "county",
            "postcode",
            "type"
        ];

        $missing = [];
        foreach ($required as $key) {
            if (empty($params[$key])) {
                $missing[] = $key;
            }
        }

        if ($missing) {
            throw new PersonException('Missing required data', $missing);
        }
    }

    /**
     * Save a person.
     *
     * @param array $params
     * @return JsonResponse
     */
    public static function save(array $params)
    {
        /*
         * Validate the api key.
         */
        (new AuthenticationController())->validApi();

        self::update($params);

        return new JsonResponse(
            'Person updated',
            $data
        );
    }

    /**
     * Update a person.
     *
     * @param array $params
     * @return bool
     */
    public static function update(array $params)
    {
        $data = (new People())->getById($params['id']);

        if (empty($data)) {
            throw new NotFoundException('Person not found');
        }

        self::required($params);

        $data = self::set($params, $data);

        $data->update();

        self::setParent($params, $data);

        return true;
    }

    /**
     * Generate seed data for the people table.
     */
    public function seedPeople()
    {
        /*
         * Define the console conntroller.
         */
        $console = new ConsoleController();

        /*
         * Inform the user of the creation.
         */
        $console->info('Creating a some people');

        /*
         * Define a first names array.
         */
        $females = [
            'Jane',
            'Kayleigh',
            'Rachel',
            'Lauren',
            'Laura',
            'Helen',
            'Zoey',
            'Jenny',
            'Kira',
            'Joan',
            'Mary',
            'Lisa',
            'Kelly',
            'May',
            'Emma',
            'Sarah'
        ];

        $males = [
            'Michael',
            'John',
            'Tom',
            'Thomas',
            'Gavin',
            'Paul',
            'Luke',
            'Mathew',
            'Zack',
            'David',
            'Leonard',
            'Mark',
            'Keith',
            'Joe',
            'Stewart',
            'Aidan',
        ];

        /*
         * Define a last names array.
         */
        $last_names = explode("\n", file_get_contents(getenv('ROOT') . 'last_names.txt'));

        $fathers = [];

        /*
         * Generate parents.
         */
        $count = 1;
        while ($count != 50) {
            $father = new People();
            $father->first_name = $males[rand(0, count($males) - 1)];
            $father->last_name = $last_names[rand(0, count($last_names) - 1)];
            $father->type = 'parent';
            $father->relationship = 'Father';
            $father->sex = 'male';
            $father = $this->peopleExtra($father);

            $check = (new People())
                ->filter('first_name', $father->first_name)
                ->filter('last_name', $father->last_name)
                ->get();

            if (!$check) {
                $father->save();

                $fathers[] = $father;
                $count++;
            }
        }

        $rooms = (new Room())->all();

        $statuses = ['present', 'absent', 'left'];

        foreach ($fathers as $key => $father) {
            $mother = new People();
            $mother->first_name = $females[rand(0, count($females) - 1)];
            $mother->last_name = $father->last_name;
            $mother->type = 'parent';
            $mother->relationship = 'Mother';
            $mother->sex = 'female';
            $mother = $this->peopleExtra($mother);

            if (intval($key % 10) != 0) {
                $mother->address_line_1 = $father->address_line_1;
                $mother->city = $father->city;
                $mother->county = $father->county;
                $mother->postcode = $father->postcode;
            }

            $mother->save();

            $model = new People();
            $female = rand(0, 1);
            if ($female == 0) {
                $model->first_name = $females[rand(0, count($females) - 1)];
                $model->relationship = 'Daughter';
                $model->sex = 'female';
            } else {
                $model->first_name = $males[rand(0, count($males) - 1)];
                $model->relationship = 'Son';
                $model->sex = 'male';
            }
            $model->last_name = $father->last_name;

            $model->type = 'child';

            $room = ($rooms[rand(0, count($rooms) - 1)]);
            $model->room_id = $room->id;

            if (strpos(strtolower($room->name), 'baby')) {
                $model->dob = (intval(date('Y')) - 2) . '-' . rand(1, 12) . '-' . rand(1, 28);
            } else {
                $model->dob = (intval(date('Y')) - 4) . '-' . rand(1, 12) . '-' . rand(1, 28);
            }

            $model->address_line_1 = $father->address_line_1;
            $model->city = $father->city;
            $model->county = $father->county;
            $model->postcode = $father->postcode;
            if (intval($key % 5) == 0) {
                $model->status = $statuses[rand(1, count($statuses) - 1)];
            }

            $check = true;
            while ($check) {
                $check = (new People())
                    ->filter('first_name', $model->first_name)
                    ->filter('last_name', $model->last_name)
                    ->get();
                if ($female == 0) {
                    $model->first_name = $females[rand(0, count($females) - 1)];
                } else {
                    $model->first_name = $males[rand(0, count($males) - 1)];
                }
            }

            $model->save();

            $parent = new Parents();
            $parent->parent_id = $father->id;
            $parent->child_id = $model->id;
            $parent->save();

            $parent = new Parents();
            $parent->parent_id = $mother->id;
            $parent->child_id = $model->id;
            $parent->save();
        }
    }

    private static function set($params, $data)
    {
        foreach ($data as $key => $value) {
            if (isset($params[$key])) {
                $data->$key = $params[$key];
            }
        }

        if ($data->dob) {
            $data->dob = date('Y-m-d', strtotime($data->dob));
        }

        return $data;
    }

    private static function setParent($params, $data)
    {
        if ($data->type == 'parent' && !empty($params['child_id'])) {
            $parent = (new Parents())->getByIds($data->id, $params['child_id']);
            if (empty($parent)) {
                $parent = new Parents();
                $parent->parent_id = $data->id;
                $parent->child_id = $params['child_id'];
                $parent->save();
            } else {
                $parent->deleted_at = null;
                $parent->update();
            }

            $contact = (new Contact())->getByIds($data->id, $params['child_id']);
            if (empty($contact)) {
                $contact = new Contact();
                $contact->person_id = $data->id;
                $contact->child_id = $params['child_id'];
                $contact->save();
            } else {
                $contact->deleted_at = null;
                $contact->update();
            }
        }
    }

    /**
     * Get the people stats
     *
     * @param array $params
     * @return JsonResponse
     */
    public static function stats(array $params)
    {
        $model = new People();

        $queryEnd = ' AND deleted_at IS NULL AND `type` = "child"';
        if (!empty($params['query'])) {
            $model->likeOr(
                [
                    'first_name',
                    'last_name'
                ],
                $params['query']
            );
            $queryEnd .= ' AND (first_name LIKE :first_name OR last_name LIKE :last_name) ';
        }

        $stats = $model->select('SELECT 
            (SELECT count(id) FROM people WHERE status="present"' . $queryEnd . ') AS `present`,
            (SELECT count(id) FROM people WHERE status="absent"' . $queryEnd . ') AS `absent`,
            (SELECT count(id) FROM people WHERE status="left"' . $queryEnd . ') AS `left`
            FROM people WHERE deleted_at IS NULL AND `type` = "child"');
        
        $return = new \stdClass();
        $return->present = $stats->present;
        $return->absent = $stats->absent;
        $return->left = $stats->left;

        return new JsonResponse(
            'People stats',
            $return
        );
    }
}
