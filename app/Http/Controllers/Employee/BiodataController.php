<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\BiodataRequest;
use App\Http\Requests\Employee\PasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class BiodataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $user = auth()->user()->load('biodata');

        $groups = collect(User::GROUPS)->map(function ($group) {
            return collect($group)->keys();
        })->flatten()->combine(collect(User::GROUPS)->map(function ($group) {
            return collect($group)->values();
        })->flatten());

        return view('employee.pages.biodata.form', compact('user', 'groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BiodataRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(BiodataRequest $request)
    {
        DB::transaction(function () use ($request) {
            auth()->user()->update($request->validated());
            auth()->user()->biodata->update($request->validated());
        });

        return redirect(route('employee.biodatas.create'))->with('biodata-success', 'Biodata berhasil diubah');
    }

    public function password(PasswordRequest $request)
    {
        auth()->user()->update(["password" => $request->get('password')]);

        return redirect(route('employee.biodatas.create'))->with('password-success', 'Password berhasil diubah');
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
