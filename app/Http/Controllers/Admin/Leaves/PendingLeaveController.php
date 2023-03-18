<?php

namespace App\Http\Controllers\Admin\Leaves;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use App\Models\LeaveApproved;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PendingLeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $leaves = Leave::with('user', 'leaveApproveds.user')->isInProgress()->latest()->paginate(10);

        return view('admin.pages.leave.pending.index', compact('leaves'));
    }

    public function status(Leave $leave, $status)
    {
        $amount = Leave::where('user_id', $leave->user_id)->where('status', Leave::STATUS_APPROVED)->sum('total_day');

        if (Leave::isInMaxLeave($amount)) {
            return redirect(route('admin.leaves.request.pending.index'))->with('error', "Sisa cuti pegawai tersebut sudah habis");
        }

        DB::transaction(function () use ($leave, $status, $amount) {
            LeaveApproved::updateOrCreate([
                "leave_id" => $leave->id,
                "user_id" => auth()->id(),
            ], [
                "status" => $status,
            ]);

            if ($leave->isInProgressWithAllLeader()) {
                $leave->update(['status' => Leave::STATUS_IN_PROGRESS]);
            } elseif ($leave->isApprovedWithByLeader()) {
                $leave->update(['status' => Leave::STATUS_APPROVED]);
            } elseif ($leave->isRejectedByAllLeader()) {
                $leave->update(['status' => Leave::STATUS_REJECTED]);
            }
        });

        // if approved, we notify user
        if ($leave->isApproved()) {
            UserNotification::notifyDescription($leave->user_id, "<div class='alert alert-success alert-dismissible show fade'><div class='alert-body'><button class='close' data-dismiss='alert'><span>×</span></button>Permohonan <b class='text text-dark'>Cuti</b> anda dari tanggal {$leave->start_date->format('d F Y')} sampai {$leave->end_date->format('d F Y')} telah <b class='text text-dark'>diterima</b></div></div>");
            UserNotification::notifyLeaveAmountToUser($leave->user_id, $amount + $leave->total_day);
        } elseif ($leave->isRejected()) {
            UserNotification::notifyDescription($leave->user_id, "<div class='alert alert-danger alert-dismissible show fade'><div class='alert-body'><button class='close' data-dismiss='alert'><span>×</span></button>Permohonan <b class='text text-dark'>Cuti</b> anda dari tanggal {$leave->start_date->format('d F Y')} sampai {$leave->end_date->format('d F Y')} telah <b class='text text-dark'>ditolak</b></div></div>");
        }

        return redirect(route('admin.leaves.request.pending.index'))->with('success', "Ubah status: {$status} berhasil");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
