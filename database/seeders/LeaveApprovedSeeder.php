<?php

namespace Database\Seeders;

use App\Models\Leave;
use App\Models\LeaveApproved;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class LeaveApprovedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $leaves = Leave::all();
        $roles  = [User::ROLE_HEAD_OF_FIELD, User::ROLE_HEAD_OF_DEPARTMENT];
        $users  = User::whereIn('role', $roles)->get();

        $statuses = [Leave::STATUS_REJECTED, Leave::STATUS_APPROVED, Leave::STATUS_IN_PROGRESS];

        foreach ($leaves as $leave) {
            foreach (range(1, 2) as $item) {
                LeaveApproved::updateOrCreate([
                    "leave_id" => $leave->id,
                    "user_id" => $users->where('role', Arr::random($roles))->random()->id,
                ], [
                    "status" => Arr::random($statuses),
                ]);
            }
        }
    }
}
