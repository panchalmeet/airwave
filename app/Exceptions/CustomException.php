<?php
/**
 * Custom Exception
 *
 * PHP version 8.1
 *
 * @category CustomException
 * @package  App\Exceptions\
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */
namespace App\Exceptions;

use Exception;
use Nuwave\Lighthouse\Exceptions\RendersErrorsExtensions;

/**
 * Handling graphql custom exceptions
 *
 * PHP version 8.1
 *
 * @category CustomException
 * @package  App\Console\
 * @author   meet.panchal
 * @license  http://www.gnu.org/licenses GNU General Public License, version 3
 */
class CustomException extends Exception implements RendersErrorsExtensions
{
    protected $messageCode;
    protected $code;

    /**
     * Constructor
     *
     * @param string $message     exception message
     * @param string $messageCode exception code
     * @param int    $code        exception code
     *
     * @return never
     */
    public function __construct(string $message, string $messageCode, int $code)
    {
        parent::__construct($message);
        $this->messageCode = $messageCode;
        $this->code = $code;
    }

    /**
     * Returns true when exception message is safe to be displayed to a client.
     *
     * @return bool
     */
    public function isClientSafe(): bool
    {
        return true;
    }

    /**
     * Returns string describing a category of the error.
     *
     * Value "graphql" is for errors produced by query parsing, do not use it.
     *
     * @api
     * @return string
     */
    public function getCategory(): string
    {
        return 'Custom';
    }

    /**
     * Return the content that is put in the "extensions" part
     * of the returned error.
     *
     * @return array
     */
    public function extensionsContent(): array
    {
        $meta = [
            'status' => false,
            'message' => $this->message,
            'message_code' => $this->messageCode,
            'status_code' => $this->code
            ];
        return ['meta'=> $meta];
    }
}
