<?php

namespace App\Http\Controllers\Admin\Leaves;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use App\Models\LeaveApproved;
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

        return view('admin.pages.leave.index', compact('leaves'));
    }

    public function status(Leave $leave, $status)
    {
        DB::transaction(function () use ($leave, $status) {
            LeaveApproved::updateOrCreate([
                "leave_id" => $leave->id,
                "user_id" => auth()->id(),
            ], [
                "status" => $status,
            ]);

            if ($leave->isInProgressWithAllLeader()) {
                $leave->update(['status' => Leave::STATUS_IN_PROGRESS]);
            } elseif ($leave->isApprovedWithAllLeader()) {
                $leave->update(['status' => Leave::STATUS_APPROVED]);
            } else {
                $leave->update(['status' => Leave::STATUS_REJECTED]);
            }
        });

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
