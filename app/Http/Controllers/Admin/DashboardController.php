<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use App\Models\LeaveNotification;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {

        $totalLeavesPending  = Leave::where('status', Leave::STATUS_IN_PROGRESS)->count();
        $totalLeavesApproved = Leave::where('status', Leave::STATUS_APPROVED)->count();
        $totalLeavesRejected = Leave::where('status', Leave::STATUS_REJECTED)->count();
        $totalEmployee = User::employee()->count();

        // don't take the notification if role is admin
        $leaveNotifications =
            auth()->user()->isAdmin()
                ? collect() : LeaveNotification::whereHas('leave', function ($query) {
                                $query->where('status', Leave::STATUS_IN_PROGRESS);
                            })->paginate(10);

        return view('admin.pages.dashboard.index', compact('totalLeavesPending', 'totalLeavesApproved', 'totalLeavesRejected', 'totalEmployee', 'leaveNotifications'));
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
