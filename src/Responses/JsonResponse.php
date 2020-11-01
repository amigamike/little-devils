<?php

/**
 * Json response.
 *
 * @package     MikeWelsh\LittleDevils\Responses\JsonResponse
 * @author      Mike Welsh (mike@amigamike.com)
 * @copyright   2020 Mike Welsh
 */

namespace MikeWelsh\LittleDevils\Responses;

class JsonResponse
{
    /**
     * Output the data to the end user as an JSON object.
     *
     * @param mixed $data
     * @param string $version
     * @param string $status
     * @param int $code
     * @return null
     */
    public function __construct(string $message, $data, string $status = 'success', int $code = 200)
    {
        /**
         * Set the header content type to that of JSON.
         */
        header('Content-Type: application/json');

        /**
         * Define the output.
         */
        $output = [
            'application' => 'Little Devil\'s',
            'version' => '0.0.1',
            'copyright' => 'Mike Welsh (c)' . date('Y'),
            'link' => 'https://amigamike.com',
            'path' => $_SERVER['REQUEST_URI'],
            'status' => $status,
            'code' => $code,
            'message' => $message,
            'data' => $data
        ];

        /**
         * If the data is an Exception, get various params from it.
         */
        if ($data instanceof \Exception) {
            $output['code'] = $data->code;
            $output['status'] = $data->status;
            $output['message'] = $data->message;
            $output['data'] = !empty($data->data) ?
                $data->data :
                (!empty($data->xdebug_message) ? $data->xdebug_message : null);
        }

        /**
         * Echo the output for the end user.
         */
        echo json_encode($output);

        return null;
    }
}
