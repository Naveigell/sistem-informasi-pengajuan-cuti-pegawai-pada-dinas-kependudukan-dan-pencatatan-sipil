@extends('layouts.employee.employee')

@section('content-title', 'Pengajuan Cuti')

@section('content-body')
    <div class="col-12 col-md-12 col-lg-12 no-padding-margin">
        <div class="card">
            <form action="{{ route('employee.leaves.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-header">
                    <h4>Form Pengajuan Cuti</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>File Permohonan</label>
                        <input type="file" class="form-control @error('filename') is-invalid @enderror" accept="application/msword,application/pdf,image/jpeg,image/png,image/jpg" name="filename">
                        @error('filename')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Dari Tanggal</label>
                        <input type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" value="{{ old('start_date', @$employee ? $employee->start_date : '') }}">
                        @error('start_date')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Sampai Tanggal</label>
                        <input type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{ old('end_date', @$employee ? $employee->end_date : '') }}">
                        @error('end_date')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
