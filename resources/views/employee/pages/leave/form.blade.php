@extends('layouts.employee.employee')

@section('content-title', 'Pengajuan Cuti')

@section('content-body')
    <div class="col-12 col-md-12 col-lg-12 no-padding-margin">
        <div class="card">
            <form action="{{ @$leave ? route('employee.leaves.update', $leave) : route('employee.leaves.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method(@$leave ? 'PUT' : 'POST')
                <div class="card-header">
                    <h4>Form Pengajuan Cuti</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Tipe Cuti</label>
                        <select name="leave_type" id="leave-type" class="form-control @error('leave_type') is-invalid @enderror">
                            <x-nothing-selected></x-nothing-selected>
                            @foreach(array_keys(\App\Models\Leave::getAllLeaveTypes()) as $leaveType)
                                <option @if(old('leave_type', @$leave ? $leave->leave_type : '') == $leaveType) selected @endif @if(in_array($leaveType, [\App\Models\Leave::LEAVE_TYPE_ANNUAL_LEAVE, \App\Models\Leave::LEAVE_TYPE_SICK_LEAVE])) data-need-date="true" @endif value="{{ $leaveType }}">{{ \App\Models\Leave::getLeaveType($leaveType) }} ({{ \App\Models\Leave::getLeaveAmountText($leaveType) }})</option>
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
                        <input type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" value="{{ old('start_date', @$leave ? $leave->start_date->format('Y-m-d') : '') }}">
                        @error('start_date')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div id="container-need-date">
                        <div class="form-group">
                            <label>Sampai Tanggal</label>
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{ old('end_date', @$leave ? $leave->end_date->format('Y-m-d') : '') }}">
                            @error('end_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Alasan Cuti</label>
                        <textarea name="reason" id="reason" cols="30" rows="10" class="form-control @error('reason') is-invalid @enderror" style="min-height: 300px; resize: none;">{{ old('reason', @$leave ? $leave->reason : '') }}</textarea>
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
    @if(in_array(old('leave_type', @$leave ? $leave->leave_type : ''), [\App\Models\Leave::LEAVE_TYPE_ANNUAL_LEAVE, \App\Models\Leave::LEAVE_TYPE_SICK_LEAVE]))
        <script>
            $('#container-need-date').show();
        </script>
    @endif
@endpush
