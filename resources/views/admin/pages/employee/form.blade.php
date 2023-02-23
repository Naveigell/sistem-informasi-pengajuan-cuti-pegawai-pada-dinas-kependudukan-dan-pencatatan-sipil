@extends('layouts.admin.admin')

@section('content-title', 'Pegawai')

@section('content-body')
    <div class="col-12 col-md-12 col-lg-12 no-padding-margin">
        <div class="card">
            <form action="{{ @$employee ? route('admin.employees.update', $employee) : route('admin.employees.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method(@$employee ? 'PUT' : 'POST')
                <div class="card-header">
                    <h4>Form Pegawai</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', @$employee ? $employee->name : '') }}">
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username', @$employee ? $employee->username : '') }}">
                        @error('username')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', @$employee ? $employee->email : '') }}">
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>No Telp</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', @$employee ? $employee->biodata->phone : '') }}">
                        @error('phone')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="address" id="" cols="30" rows="10" style="min-height: 200px; resize: none;" class="form-control @error('address') is-invalid @enderror">{{ old('address', @$employee ? $employee->biodata->address : '') }}</textarea>
                        @error('address')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>

                    @if(!@$employee)
                        <div class="mt-2">
                            <small class="text-muted text">* Note: Password akan otomatis berisi 123456, mohon untuk mengganti password secara mandiri.</small>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection
