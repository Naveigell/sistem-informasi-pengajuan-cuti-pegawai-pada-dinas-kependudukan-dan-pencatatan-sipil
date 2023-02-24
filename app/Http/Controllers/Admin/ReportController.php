<?php

namespace App\Http\Controllers\Admin;

use App\Exports\EmployeeLeaveExport;
use App\Http\Controllers\Controller;
use App\Models\Leave;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index()
    {
        $leaves = $this->query()->paginate(10)->withQueryString();

        return view('admin.pages.report.index', compact('leaves'));
    }

    public function create()
    {
        return Excel::download(new EmployeeLeaveExport($this->query()), 'laporan.xlsx');
    }

    private function query()
    {
        $leaves = Leave::with('user', 'leaveApproveds.user')->latest();

        if (\request('start_date')) {
            $leaves->whereDate('start_date', '>=', \request('start_date'));
        }

        if (\request('end_date')) {
            $leaves->whereDate('end_date', '<=', \request('end_date'));
        }

        if (\request('status')) {
            $leaves->where('status', \request('status'));
        }

        return $leaves;
    }
}
