<?php

declare(strict_types=1);

namespace App\Infrastructure\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ValidateRequestCompleteness
{
    /**
     * Проверяет полноту данных в запросе
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $requiredFields = [
            'external_message_id',
            'external_client_id',
            'client_phone',
            'message_text',
            'send_at'
        ];

        $missingFields = [];
        $requestData = $request->all();

        foreach ($requiredFields as $field) {
            if (!array_key_exists($field, $requestData)) {
                $missingFields[] = $field;
            }
        }

        if (!empty($missingFields)) {
            $logData = [
                'request' => $requestData,
                'missing_fields' => $missingFields,
                'ip' => $request->ip(),
                'url' => $request->fullUrl(),
                'headers' => $request->headers->all()
            ];

            Log::warning('Incomplete request data', $logData);

            return response()->json([
                'status' => 'success',
                'message' => 'Request processed',
                'missing_fields' => $missingFields
            ]);
        }

        return $next($request);
    }
}
