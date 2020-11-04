<?php

/**
 * View controller.
 *
 * @package     MikeWelsh\LittleDevils\Controllers\ViewController
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Controllers;

use MikeWelsh\LittleDevils\Models\PageData;
use MikeWelsh\LittleDevils\Exceptions\NotFoundException;
use MikeWelsh\LittleDevils\Exceptions\TemplateException;
use MikeWelsh\LittleDevils\Helpers\PathHelper;

class ViewController
{
    /**
     * Define the template's data.
     * @var mixed $data
     */
    private $data = null;

    /**
     * Define the template file.
     * @var string $template
     */
    private $template = '';

    public function __construct(string $template = '', $data = null)
    {
        $this->data = new PageData();

        if ($data) {
            foreach ($data as $key => $item) {
                $this->data->$key = $item;
            }
        }

        if ($template) {
            $this->setTemplate($template);
        }
    }

     /**
     * Redirect to a URL.
     *
     * @param string $url
     * @return void;
     */
    public static function redirect(string $url)
    {
        /*
         * Redirect the user.
         */
        if (!headers_sent()) {
            header('Location: ' . $url);
            exit;
        }

        /*
         * Can't redirect by PHP as header already sent so use javascript instead.
         */
        echo '<script type="text/javascript">redirect("' . $url . '");</script>';
        return;
    }


    /**
     * Render the template, returning it's content.
     *
     * @param string $template
     * @param mixed $data Data made available to the view.
     * @return string The rendered template.
     */
    public function render(string $template = '', $data = null)
    {
        if ($data) {
            if (is_array($data)) {
                foreach ($data as $key => $item) {
                    $this->data->$key = $item;
                }
            } else {
                $this->data = $data;
            }
        }

        if ($template) {
            $this->setTemplate($template);
        }

        ob_start();
        $data = $this->data;
        try {
            include($this->template);
        } catch (Exception $err) {
            throw new TemplateException($err->getMessage());
        }
        $content = ob_get_contents();
        ob_end_clean();
        print $content;
    }

    /**
     * Set the view's template to render.
     *
     * @param string $template
     */
    private function setTemplate($template)
    {
        /*
         * Build the full path for the template.
         */
        $this->template = getenv('TEMPLATES_ROOT') . str_replace('.php', '', $template) . '.php';

        /*
         * Check to see if the template exists.
         */
        if (file_exists($this->template)) {
            return $this->template;
        }

        /*
         * Template is not found, throw an error.
         */
        throw new NotFoundException(
            'Template ' . $template . ' not found',
            [
                'template' => $this->template
            ]
        );
    }

    /**
     * Check to see if the template exists.
     *
     * @param string $template
     * @return bool
     */
    public function templateExists($template): bool
    {
        $this->setTemplate($template);

        return file_exists($this->template);
    }
}
