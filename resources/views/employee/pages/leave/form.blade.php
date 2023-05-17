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
                        <label>Tipe Cuti</label>
                        <select name="leave_type" id="leave-type" class="form-control @error('leave_type') is-invalid @enderror">
                            <x-nothing-selected></x-nothing-selected>
                            @foreach(array_keys(\App\Models\Leave::getAllLeaveTypes()) as $leaveType)
                                <option @if(old('leave_type') == $leaveType) selected @endif @if($leaveType == \App\Models\Leave::LEAVE_TYPE_ANNUAL_LEAVE) data-need-date="true" @endif value="{{ $leaveType }}">{{ \App\Models\Leave::getLeaveType($leaveType) }} ({{ \App\Models\Leave::getLeaveAmountText($leaveType) }})</option>
                            @endforeach
                        </select>
                        @error('leave_type')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Tanggal Cuti</label>
                        <input type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" value="{{ old('start_date') }}">
                        @error('start_date')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div id="container-need-date">
                        <div class="form-group">
                            <label>Sampai Tanggal</label>
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{ old('end_date') }}">
                            @error('end_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Alasan Cuti</label>
                        <textarea name="reason" id="reason" cols="30" rows="10" class="form-control @error('reason') is-invalid @enderror" style="min-height: 300px; resize: none;">{{ old('reason') }}</textarea>
                        @error('reason')
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

@push('stack-script')
    <script>
        $('#container-need-date').hide();
        $('#leave-type').on('change', function () {
            var isNeedDate = $(this).find(':selected').data('need-date');

            if (isNeedDate) {
                $('#container-need-date').show();
            } else {
                $('#container-need-date').hide();
            }
        })
    </script>
    @if(old('leave_type') == \App\Models\Leave::LEAVE_TYPE_ANNUAL_LEAVE)
        <script>
            $('#container-need-date').show();
        </script>
    @endif
@endpush
