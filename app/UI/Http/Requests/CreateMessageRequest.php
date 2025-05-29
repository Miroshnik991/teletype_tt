<?php

namespace App\UI\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'external_message_id' => [
                'string',
                'size:16',
                'unique:messages,external_message_id'
            ],

            'external_client_id' => [
                'string',
                'size:16'
            ],

            'client_phone' => [
                'string',
                'regex:/^\+7\d{10}$/',
                function ($attribute, $value, $fail) {
                    if (strlen($value) !== 12) {
                        $fail('Номер телефона должен содержать 12 символов');
                    }
                }
            ],

            'message_text' => [
                'string',
                'max:4096'
            ],

            'send_at' => [
                'integer',
                function ($attribute, $value, $fail) {
                    if ($value < 0 || $value > 2147483647) {
                        $fail('Некорректное значение unixtime');
                    }

                    if ($value > time()) {
                        $fail('Дата отправки не может быть позже текущего времени!');
                    }
                }
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'external_message_id.size' => 'Идентификатор сообщения должен быть 16 байт',
            'client_phone.regex' => 'Номер телефона должен быть в формате +7XXXXXXXXXX',
            'send_at.integer' => 'Дата отправки должна быть в формате unixtime'
        ];
    }
}
