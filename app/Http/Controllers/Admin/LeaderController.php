<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LeaderRequest;
use App\Models\User;
use Illuminate\Http\Request;

class LeaderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $leaders = User::whereIn('role', [User::ROLE_HEAD_OF_DEPARTMENT, User::ROLE_HEAD_OF_FIELD])->latest()->paginate(10);

        return view('admin.pages.leader.index', compact('leaders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.pages.leader.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param LeaderRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(LeaderRequest $request)
    {
        User::create(array_merge($request->validated(), [
            "password" => 123456,
        ]));

        return redirect(route('admin.leaders.index'))->with('success', 'Kepala berhasil di tambah');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $leader
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(User $leader)
    {
        return view('admin.pages.leader.form', compact('leader'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param LeaderRequest $request
     * @param User $leader
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(LeaderRequest $request, User $leader)
    {
        $leader->update($request->validated());

        return redirect(route('admin.leaders.index'))->with('success', 'Kepala berhasil di ubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $leader
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(User $leader)
    {
        $leader->delete();

        return redirect(route('admin.leaders.index'))->with('success', 'Kepala berhasil di hapus');
    }
}
