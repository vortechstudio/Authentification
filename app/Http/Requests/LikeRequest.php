<?php

namespace App\Http\Requests;

use App\Contracts\Likeable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

class LikeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "likeable_type" => [
                "bail",
                "required",
                "string",
                function ($attribute, $value, $fail) {
                    if (! class_exists($value, true)) {
                        $fail($value . " is not an existing class");
                    }

                    if (! in_array(Model::class, class_parents($value))) {
                        $fail($value . " is not Illuminate\Database\Eloquent\Model");
                    }

                    if (! in_array(Likeable::class, class_implements($value))) {
                        $fail($value . " is not App\Contracts\Likeable");
                    }
                }
            ],
            "id" => [
                "required",
                function ($attribute, $value, $fail) {
                    $class = $this->input('likeable_type');

                    if (! $class::where('id', $value)->exists()) {
                        $fail($value . " does not exists in database");
                    }
                },
            ]
        ];
    }

    public function likeable(): Likeable
    {
        $class = $this->input('likeable_type');

        return $class::findOrFail($this->input('id'));
    }
}
