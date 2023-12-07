<?php

namespace App\Http\Requests\Api\V1\Membership;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class FamilyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'broker_id' => 'required|integer',
            // For princal
            'scheme_option_id' => 'required|integer',
            'scheme_type_id' => 'nullable|sometimes|integer',
            'title' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'dob' => 'required|date',
            'gender' => 'required|string|in:Male,Female',
            'nrc_or_passport_no' => 'required|string',
            'occupation' => 'required|string',
            'email' => ['required', 'string', Rule::unique('members')->ignore($this->member, 'member_id')],
            'mobile_number' => 'required|string',
            // End of principal

            // Family Details
            'group_type_id' => 'required|integer',
            'subscription_period_id' => 'required|integer',
            'physical_address' => 'required|string',
            'status' => 'required|string',
            'has_funeral_cash_benefit' => 'required|boolean',
            'has_sports_loading' => 'required|boolean',
            // End of family details

            // Dependent Details
            'dependents' => 'array',
            'dependents.*.title' => 'nullable|sometimes|string',
            'dependents.*.first_name' => 'required|string',
            'dependents.*.last_name' => 'required|string',
            'dependents.*.dob' => 'required|date',
            'dependents.*.id_type' => 'nullable|sometimes|string|in:nrc,passport',
            'dependents.*.email' => ['nullable', 'sometimes', Rule::unique('members')->ignore($this->member, 'member_id')],
            'dependents.*.gender' => 'required|string|in:Male,Female',
            'dependents.*.has_sports_loading' => 'required|boolean',
            'dependents.*.sports_loading_start_date' => 'nullable|sometimes|date',
            'dependents.*.sports_loading_end_date' => 'nullable|sometimes|date',
            'dependents.*.sporting_activity' => 'nullable|sometimes|string',
        ];
    }
}
