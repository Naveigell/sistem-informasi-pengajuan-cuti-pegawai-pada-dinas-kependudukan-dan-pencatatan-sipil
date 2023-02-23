@extends('layouts.employee.employee')

@section('content-title', 'Pegawai')

@section('content-body')
    @if ($message = session()->get('success'))
        <x-alert.success :message="$message"></x-alert.success>
    @endif
    <div class="col-lg-12 col-md-12 col-12 col-sm-12 no-padding-margin">
        <div class="card">
            <div class="card-header">
                <h4>Cuti Pegawai - Total {{ $leaves->count() }}</h4>
                <div class="card-header-action">
                    <a href="{{ route('employee.leaves.create') }}" class="btn btn-primary"><i class="fa fa-envelope"></i> Ajukan Cuti</a>
                </div>
            </div>
            <div class="card-body p-0">
                <form class="row p-4" action="{{ route('employee.leaves.index') }}">
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
                    <div class="col-12 mt-3">
                        <button class="btn btn-primary">Filter</button>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th class="col-1">No</th>
                            <th class="col-2">File Pengajuan Cuti</th>
                            <th class="col-3">Dari Tanggal</th>
                            <th class="col-3">Sampai Tanggal</th>
                            <th class="col-2">Total Hari</th>
                            <th class="col-3">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($leaves as $leave)
                            <tr>
                                <td>
                                    <x-iterate :pagination="$leaves" :loop="$loop"></x-iterate>
                                </td>
                                <td><a href="{{ asset('storage/employees/leaves/' . $leave->filename) }}" class="">Download</a></td>
                                <td>{{ $leave->start_date->format('d F Y') }}</td>
                                <td>{{ $leave->end_date->format('d F Y') }}</td>
                                <td>{{ $leave->total_day }}</td>
                                <td>
                                    <span class="badge {{ $leave->status_class_formatted }}">{{ $leave->status_formatted }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center;">Data Empty</td>
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

@section('content-modal')
    <x-modal.delete :name="'Pegawai'"></x-modal.delete>
@endsection
