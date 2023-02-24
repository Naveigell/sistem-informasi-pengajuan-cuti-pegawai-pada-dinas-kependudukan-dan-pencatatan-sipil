<?php

namespace App\Exports;

use App\Models\Leave;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class EmployeeLeaveExport implements FromCollection, ShouldAutoSize
{
    private $query;

    /**
     * @param Leave $query
     */
    public function __construct($query)
    {
        $this->query = $query;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $leaves = $this->query->get();

        $collections = collect();

        $collections->add(["No", "Nama Pegawai", "Tanggal awal cuti", "Tanggal akhir cuti", "Total hari", "Disetujui oleh", "Status"]);

        foreach ($leaves as $index => $leave) {
            $users = [];

            foreach ($leave->leaveApproveds as $leaveApproved) {
                $users[] = $leaveApproved->user->name;
            }

            $collections->add([$index + 1, $leave->user->name, $leave->start_date->format('d F Y'), $leave->end_date->format('d F Y'), $leave->total_day, count($users) > 0 ? implode(', ', $users) : '-', $leave->status_formatted]);
        }

        return $collections;
    }
}
