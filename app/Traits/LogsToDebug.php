<?php
/**
 * Trait used to handle data logging
 */

namespace App\Traits;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

trait LogsToDebug
{

    /**
     * Log data to debug channel
     *
     * @param Exception $e
     * @param Request $request
     * @param int $status
     * @return void
     */
    public function logToDebug($e, $request, $status)
    {
        $logData = [
            'path' => $request->path(),
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'userAction' => $request->wantsJson(),
            'status' => $status,
        ];

        if (!empty($e)) $logData['exception'] = $this->handleExceptionData($e);

        Log::channel('debug')->info($logData);
    }

    /**
     * Build exception details to add to log
     *
     * @param Exception $e
     * @return array
     */
    private function handleExceptionData($e): array
    {
        $exceptionClass = get_class($e);

        $exception = [
            'message' => $e->getMessage(),
            'class' => $exceptionClass,
        ];

        switch ($exceptionClass) {
            case 'Illuminate\\Validation\\ValidationException':
                $exception['errors'] = $e->errors();
                break;

            default:
                break;
        }

        return $exception;
    }

}
