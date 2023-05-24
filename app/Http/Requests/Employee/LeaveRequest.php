<?php

namespace App\Http\Requests\Employee;

use App\Models\Leave;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property Carbon $start_date
 * @property Carbon $end_date
 */
class LeaveRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $moreThan4Days = now()->addDays(4)->format('d-m-Y');

        $rules = [
            "leave_type" => "required|string|in:" . join(',', array_keys(Leave::getAllLeaveTypes())),
            "start_date" => "required|date|after:{$moreThan4Days}",
            "reason" => "required|string|max:15000",
        ];

        if (in_array($this->leave_type, [Leave::LEAVE_TYPE_ANNUAL_LEAVE, Leave::LEAVE_TYPE_SICK_LEAVE])) {
            $rules["end_date"] = "required|date|after_or_equal:start_date";
        }

        return $rules;
    }

    protected function prepareForValidation()
    {
        // if the leave type is not annual leave or sick leave, we add end date by 30 * 3 (3 months) programmatically
        // why we must reduce days by 1, it because we have beed add it by 1 in getLeaveTotalDays() function
        // we don't need the total day become 91 days
        if (!in_array($this->leave_type, [Leave::LEAVE_TYPE_ANNUAL_LEAVE, Leave::LEAVE_TYPE_SICK_LEAVE])) {
            $endDate = Carbon::parse($this->start_date);

            $endDate = $endDate->addDays((30 * 3) - 1);

            $this->merge([
                "end_date" => $endDate->format('Y-m-d'),
            ]);
        }
    }

    public function getLeaveTotalDays()
    {
        // we need to add 1 days because it must calculate from now day, example
        // 02 - 03 - 2023 until 04 - 03 - 2023 is 3 days, not 2 days
        return Carbon::parse($this->start_date)->diffInDays($this->end_date) + 1;
    }
}
