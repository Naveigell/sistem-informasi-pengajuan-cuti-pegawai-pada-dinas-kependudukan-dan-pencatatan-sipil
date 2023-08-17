@extends('layouts.admin.admin')

@section('content-title', 'Kepala')

@section('content-body')
    <div class="col-12 col-md-12 col-lg-12 no-padding-margin">
        <div class="card">
            <form action="{{ @$leader ? route('admin.leaders.update', $leader) : route('admin.leaders.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method(@$leader ? 'PUT' : 'POST')
                <div class="card-header">
                    <h4>Form Kepala</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', @$leader ? $leader->name : '') }}">
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Jabatan</label>
                        <select name="role" id="" class="form-control @error('role') is-invalid @enderror">
                            <x-nothing-selected></x-nothing-selected>
                            @foreach([
                                    \App\Models\User::ROLE_HEAD_OF_FIELD => \App\Models\User::ROLE_HEAD_OF_FIELD,
                                    \App\Models\User::ROLE_HEAD_OF_DEPARTMENT => \App\Models\User::ROLE_HEAD_OF_DEPARTMENT,
                                ] as $key => $role)
                                <option @if (old('role', @$leader ? $leader->role : '') == $key) selected @endif value="{{ $key }}">{{ \App\Models\User::getRoleTranslated()[$role] }}</option>
                            @endforeach
                        </select>
                        @error('role')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username', @$leader ? $leader->username : '') }}">
                        @error('username')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', @$leader ? $leader->email : '') }}">
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>

                    @if(!@$leader)
                        <div class="mt-2">
                            <small class="text-muted text">* Note: Password akan otomatis berisi 123456, mohon untuk mengganti password secara mandiri.</small>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection
