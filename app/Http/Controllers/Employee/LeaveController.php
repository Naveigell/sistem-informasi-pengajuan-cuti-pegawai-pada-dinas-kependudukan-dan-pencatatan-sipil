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
//        if ($request->leave_type == Leave::LEAVE_TYPE_ANNUAL_LEAVE) {
//            Leave::create(array_merge(
//                $request->validated(), [
//                    "user_id" => auth()->id(),
//                    "status" => Leave::STATUS_IN_PROGRESS,
//                    "total_day" => $request->getLeaveTotalDays(),
//                ]
//            ));
//        }

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
