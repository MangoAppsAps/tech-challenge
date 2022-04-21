<?php
/**
 * Trait used to handle api responses
 */

namespace App\Traits;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

trait RespondsWithHttpStatus
{

    use LogsToDebug;

    /**
     * Success response
     *
     * @param string $message
     * @param mixed $data
     * @param int $status
     * @return JsonResponse
     */
    public function success($message, $data = false, $status = 200): JsonResponse
    {
        $success = [
            'success' => true,
            'message' => !empty($message) ? $message : 'Action completed successfully.',
            'data' => $data,
        ];

        return response()->json($success, $status);
    }

    /**
     * Error response
     *
     * @param Exception $e
     * @param Request $request
     * @param string $message
     * @param int $status
     * @return JsonResponse
     */
    public function error($e, $request, $message = '', $status = false): JsonResponse
    {
        $error = [
            'error' => true,
            'message' => !empty($message) ? $message : $this->handleErrorMessages($e)
        ];

        if (!$status) $status = $this->handleStatusCode($e);
        if (method_exists($e, 'getStatusCode')) $status = $e->getStatusCode();
        if (method_exists($e, 'errors')) $error['errorDetails'] = $e->errors();

        $this->logToDebug($e, $request, $status);

        return response()->json($error, $status);
    }

    /**
     * Handle statues codes
     *
     * @param $e
     * @return int
     */
    private function handleStatusCode($e): int
    {
        return match (get_class($e)) {
            'Illuminate\\Auth\\AuthenticationException' => 401,
            default => 422,
        };
    }

    /**
     * Handle the messages shown to the user
     *
     * @param Exception $e
     * @return string
     */
    private function handleErrorMessages($e): string
    {
        $message = 'There was a problem with your request. Please contact support.';

        if (method_exists($e, 'getMessage')) {
            switch (get_class($e)) {
                case 'Illuminate\\Validation\\ValidationException':
                    $message = 'Validation failed.';
                    break;

                case 'Symfony\\Component\\HttpKernel\\Exception\\AccessDeniedHttpException':
                    $message = 'Action unauthorized';
                    break;

                case 'Illuminate\\Auth\\AuthenticationException':
                    $message = $e->getMessage();
                    break;
            }
        }

        return $message;
    }

}
