@extends('layouts.admin.admin')

@section('content-title', 'Laporan')

@section('content-body')
    @if ($message = session()->get('success'))
        <x-alert.success :message="$message"></x-alert.success>
    @endif
    <div class="col-lg-12 col-md-12 col-12 col-sm-12 no-padding-margin">
        <div class="card">
            <div class="card-header">
                <h4>Cuti</h4>
            </div>
            <div class="card-body p-0">
                <form class="row p-4" action="{{ route('admin.reports.index') }}">
                    <div class="col-3">
                        <label for="">Status</label>
                        <select name="status" id="" class="form-control">
                            <x-nothing-selected></x-nothing-selected>
                            @foreach([
                                \App\Models\Leave::STATUS_IN_PROGRESS,
                                \App\Models\Leave::STATUS_APPROVED,
                                \App\Models\Leave::STATUS_REJECTED
                            ] as $status)
                                <option @if (request('status') == $status) selected @endif value="{{ $status }}">{{ ucwords(str_replace('_', ' ', \App\Models\Leave::getStatusFormattedStatic($status))) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-3">
                        <label for="">Tanggal Mulai</label>
                        <input type="date" class="form-control" name="start_date" value="{{ request('start_date') ? date('Y-m-d', strtotime(request('start_date'))) : '' }}">
                    </div>
                    <div class="col-3">
                        <label for="">Tanggal Selesai</label>
                        <input type="date" class="form-control" name="end_date" value="{{ request('end_date') ? date('Y-m-d', strtotime(request('end_date'))) : '' }}">
                    </div>
                    <div class="col-12 mt-3">
                        <button class="btn btn-primary">Filter</button>
                        <a href="{{ route('admin.reports.create', request()->query()) }}" class="btn btn-success">Cetak</a>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th class="col-1">No</th>
                            <th class="col-2">Nama Pegawai</th>
                            <th class="col-2">Tanggal Mulai Cuti</th>
                            <th class="col-2">Tanggal Akhir Cuti</th>
                            <th class="col-1">Jumlah Hari</th>
                            <th class="col-2">Disetujui Oleh</th>
                            <th class="col-2">Tidak Disetujui Oleh</th>
                            <th class="col-2">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                            @forelse($leaves as $leave)
                                <tr>
                                    <td>
                                        <x-iterate :pagination="$leaves" :loop="$loop"></x-iterate>
                                    </td>
                                    <td>{{ $leave->user->name }}</td>
                                    <td>{{ $leave->start_date->format('d F Y') }}</td>
                                    <td>{{ $leave->end_date->format('d F Y') }}</td>
                                    <td>{{ $leave->total_day }}</td>
                                    <td>
                                        @forelse($leave->leaveApproveds->where('status', \App\Models\Leave::STATUS_APPROVED) as $approved)
                                            <span class="badge badge-success d-inline-block mb-1 mt-1">{{ $approved->user->name }}</span>
                                        @empty
                                            -
                                        @endforelse
                                    </td>
                                    <td>
                                        @forelse($leave->leaveApproveds->where('status', \App\Models\Leave::STATUS_REJECTED) as $approved)
                                            <span class="badge badge-danger d-inline-block mb-1 mt-1">{{ $approved->user->name }}</span>
                                        @empty
                                            -
                                        @endforelse
                                    </td>
                                    <td>
                                        <span class="badge {{ $leave->status_class_formatted }}">{{ $leave->status_formatted }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" style="text-align: center;">Data Empty</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $leaves->links() }}
            </div>
        </div>
    </div>
@endsection
