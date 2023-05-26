<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EmployeeRequest;
use App\Models\Biodata;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $employees = User::with('biodata')->employee()->latest()->paginate(10);

        return view('admin.pages.employee.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.pages.employee.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EmployeeRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(EmployeeRequest $request)
    {
        DB::transaction(function () use ($request) {
            $user = User::create(
                array_merge(['password' => 123456], $request->validated())
            );
            $user->biodata()->create($request->validated());
        });

        return redirect(route('admin.employees.index'))->with('success', 'Tambah data pegawai berhasil');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $employee
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(User $employee)
    {
        $employee->load('biodata');

        return view('admin.pages.employee.form', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EmployeeRequest $request
     * @param User $employee
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(EmployeeRequest $request, User $employee)
    {
        DB::transaction(function () use ($request, $employee) {
            $employee->update($request->validated());
            $employee->biodata->update($request->validated());
        });

        return redirect(route('admin.employees.index'))->with('success', 'Ubah data pegawai berhasil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(User $employee)
    {
        $employee->delete();

        return redirect(route('admin.employees.index'))->with('success', 'Hapus data pegawai berhasil');
    }
}
