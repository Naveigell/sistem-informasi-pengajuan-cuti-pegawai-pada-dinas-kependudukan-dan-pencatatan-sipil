<?php

namespace Database\Seeders;

use App\Models\Leave;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LeaveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        $employees = User::employee()->get();
        $faker = Factory::create('id_ID');

        $leaves = [];

        $statuses = [Leave::STATUS_REJECTED, Leave::STATUS_APPROVED, Leave::STATUS_IN_PROGRESS];

        foreach ($employees as $employee) {

            foreach (range(1, rand(3, 7)) as $loop) {
                $startDate = now()->addDays(rand(3, 5));
                $endDate   = now()->addDays(rand(5, 8));

                $totaDays = $startDate->diffInDays($endDate) + 1;

                $filename = Str::random(50) . uniqid() . date('dmYHis') . '.pdf';

                $file = UploadedFile::fake()->create($filename);

                Storage::putFileAs('public/employees/leaves/', $file, $filename);

                $leaves[] = [
                    "user_id" => $employee->id,
                    "filename" => $filename,
                    "start_date" => $startDate->toDateTimeString(),
                    "end_date" => $endDate->toDateTimeString(),
                    "total_day" => $totaDays,
                    "status" => Arr::random($statuses),
                    "created_at" => now()->toDateTimeString(),
                    "updated_at" => now()->toDateTimeString(),
                ];
            }
        }

        Leave::insert($leaves);
    }
}
