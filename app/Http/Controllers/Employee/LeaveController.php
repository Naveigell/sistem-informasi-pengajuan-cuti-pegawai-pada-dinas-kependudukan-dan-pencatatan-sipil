<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\LeaveRequest;
use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $leaves = Leave::where('user_id', auth()->id())->latest();

        if (\request('status')) {
            $leaves->where('status', \request('status'));
        } else {
            $leaves->orderByStatus();
        }

        $leaves = $leaves->paginate(10);

        return view('employee.pages.leave.index', compact('leaves'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('employee.pages.leave.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param LeaveRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(LeaveRequest $request)
    {
        $validated = array_merge(
            $request->validated(), $request->only('end_date'), [
                "user_id" => auth()->id(),
                "status" => Leave::STATUS_IN_PROGRESS,
                "total_day" => $request->getLeaveTotalDays(),
                "name" => auth()->user()->name,
                "nip"  => auth()->user()->biodata->nip,
            ]
        );

        $leave = new Leave($validated);
        $leave->generateLeavePdf($validated);
        $leave->save();

        return redirect(route('employee.leaves.index'))->with('success', 'Berhasil mengajukan cuti');
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
     * @param Leave $leave
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Leave $leave)
    {
        return view('employee.pages.leave.form', compact('leave'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param LeaveRequest $request
     * @param Leave $leave
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(LeaveRequest $request, Leave $leave)
    {
        $leave->generateLeavePdf(array_merge($leave->attributesToArray(), $request->validated(), [
            "name" => $leave->user->name,
            "nip"  => $leave->user->biodata->nip,
            "leave" => $leave,
            "total_day" => $request->getLeaveTotalDays(),
        ]));
        $leave->fill(array_merge($request->validated(), $request->only('end_date'), [
            "leave_type" => $request->leave_type,
            "total_day" => $request->getLeaveTotalDays(),
        ]));
        $leave->save();

        return redirect(route('employee.leaves.index'))->with('success', 'Berhasil merevisi cuti');
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
