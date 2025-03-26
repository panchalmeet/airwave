<?php
/**
 * Service for set graphql response
 *
 * PHP version 8.1
 *
 * @category Response
 * @package  App\Http\Services
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */

namespace App\Http\Services;

use App\Exceptions\CustomException;

/**
 * Service for set suceess and error response
 *
 * PHP version 8.1
 *
 * @category Response
 * @package  App\Http\Services
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */

class GraphqlResService
{
    /**
     * Purpose Response - Success
     *
     * @param string $message    Custom success message
     * @param array  $pagination Pagination
     * @param array  $data       Response array
     * @param int    $code       Response status code
     *
     * @author meet.panchal
     *
     * @return JsonResponse
     */
    public function success($message = 'SUCCESS', $pagination = null, $data = null, $code = 200)
    {
        $meta = [
            'status' => true,
            'message' => trans('message.'.$message),
            'message_code' => $message,
            'status_code' => $code
        ];
        if (!empty($pagination)) {
            return ['meta' => $meta,'data'=>$data, 'pagination' => $pagination];
        }
        return ['meta' => $meta,'data'=>$data];
    }
    
    /**
     * Purpose Response - Error
     *
     * @param string $message Custom success message
     * @param array  $data    Response array
     * @param int    $code    Response status code
     *
     * @author meet.panchal
     *
     * @return JsonResponse
     */
    public function error($message = 'ERROR', $data = null, $code = 500)
    {
        throw new CustomException(__('error.'.$message), $message, $code);
    }

    /**
     * Purpose for generate custom message
     *
     * @param string $message Custom message
     * @param array  $data    Response array
     * @param int    $code    Response status
     *
     * @author meet.panchal
     * @return JsonResponse
     */
    public function customMessage($message = 'ERROR', $data = null, $code = 500)
    {
        throw new CustomException($message, $message, $code);
    }
}
