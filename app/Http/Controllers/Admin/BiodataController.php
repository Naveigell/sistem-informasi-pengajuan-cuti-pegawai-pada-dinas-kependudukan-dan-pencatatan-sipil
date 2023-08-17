<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BiodataRequest;
use App\Http\Requests\Admin\PasswordRequest;
use Illuminate\Http\Request;

class BiodataController extends Controller
{
    public function create()
    {
        return view('admin.pages.biodata.form');
    }

    public function store(BiodataRequest $request)
    {
        auth()->user()->update($request->validated());

        return redirect(route('admin.biodatas.create'))->with('success', 'Biodata berhasil diubah');
    }

    public function password(PasswordRequest $request)
    {
        auth()->user()->update(["password" => $request->get('password')]);

        return redirect(route('admin.biodatas.create'))->with('success-password', 'Password berhasil diubah');
    }
}
