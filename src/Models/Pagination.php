<?php

/**
 * Pagination model.
 *
 * @package     MikeWelsh\LittleDevils\Models\Pagination
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Models;

class Pagination
{
    public int $current_page = 0;
    public int $per_page = 25;
    public int $pages = 0;
    public int $total = 0;
    public int $start = 1;
    public int $end = 1;

    public function __construct($current_page = 1, $per_page = 25)
    {
        $this->current_page = $current_page;
        $this->per_page = $per_page;
    }

    public function calPages()
    {
        $pages = intval(($this->total / $this->per_page));
        if (($pages * $this->per_page) < $this->total) {
            $pages++;
        }
        $this->pages = $pages;
    }

    public function calRange()
    {
        $this->start = 1;
        $this->end = $this->pages;
    }

    public function update()
    {
        $this->calPages();
        $this->calRange();
    }
}
