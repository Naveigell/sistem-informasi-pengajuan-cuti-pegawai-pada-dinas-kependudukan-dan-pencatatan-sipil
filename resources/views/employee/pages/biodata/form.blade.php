@extends('layouts.employee.employee')

@section('content-title', 'Biodata')

@section('content-body')
    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-header">
                    <h4>Form Data Diri</h4>
                </div>
                <div class="card-body">
                    @if ($message = session()->get('biodata-success'))
                        <x-alert.success :message="$message"></x-alert.success>
                    @endif
                    <form action="{{ route('employee.biodatas.store') }}" method="post" class="">
                        @csrf
                        <div class="form-group">
                            <label>Nip</label>
                            <input disabled type="text" class="form-control @error('nip') is-invalid @enderror" name="nip" value="{{ old('nip', @$user ? $user->biodata->nip : '') }}">
                            @error('nip')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Golongan</label>
                            <input disabled type="text" class="form-control @error('group') is-invalid @enderror" name="group" value="{{ old('group', @$user ? $groups->get($user->group) : '') }}">
                            @error('group')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', @$user ? $user->name : '') }}">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username', @$user ? $user->username : '') }}">
                            @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', @$user ? $user->email : '') }}">
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>No Telp</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', @$user ? $user->biodata->phone : '') }}">
                            @error('phone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="address" id="" cols="30" rows="10" class="form-control @error('address') is-invalid @enderror" style="min-height: 250px; resize: none;">{{ old('address', @$user ? $user->biodata->address : '') }}</textarea>
                            @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    <h4>Form Ubah Password</h4>
                </div>
                <div class="card-body">
                    @if ($message = session()->get('password-success'))
                        <x-alert.success :message="$message"></x-alert.success>
                    @endif
                    <form action="{{ route('employee.biodatas.password') }}" method="post" class="">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label>Password Lama</label>
                            <input type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password">
                            @error('old_password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Password Baru</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Ulangi Password Baru</label>
                            <input type="password" class="form-control @error('repeat_password') is-invalid @enderror" name="repeat_password">
                            @error('repeat_password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
