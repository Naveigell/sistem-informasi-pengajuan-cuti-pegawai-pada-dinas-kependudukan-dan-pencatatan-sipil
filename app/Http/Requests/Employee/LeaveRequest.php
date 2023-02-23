<?php

namespace App\Http\Requests\Employee;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

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

        return [
            "filename" => "required|file|mimes:pdf,docx,png,jpg,jpeg",
            "start_date" => "required|date|after:{$moreThan4Days}",
            "end_date" => "required|date|after:start_date",
        ];
    }

    public function getLeaveTotalDays()
    {
        // we need to add 1 days because it must calculate from now day, example
        // 02 - 03 - 2023 until 04 - 03 - 2023 is 3 days, not 2 days
        return Carbon::parse($this->start_date)->diffInDays($this->end_date) + 1;
    }
}
