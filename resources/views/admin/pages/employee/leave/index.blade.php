@extends('layouts.admin.admin')

@section('content-title', 'Cuti')

@section('content-body')
    @if ($message = session()->get('success'))
        <x-alert.success :message="$message"></x-alert.success>
    @endif
    <div class="col-lg-12 col-md-12 col-12 col-sm-12 no-padding-margin">
        <div class="card">
            <div class="card-header">
                <h4>Cuti Pegawai</h4>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th class="col-1">No</th>
                            <th class="col-4">File Pengajuan Cuti</th>
                            <th class="col-3">Dari Tanggal</th>
                            <th class="col-3">Sampai Tanggal</th>
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
                                <td>
                                    <span class="badge {{ $leave->status_class_formatted }}">{{ $leave->status_formatted }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center;">Data Empty</td>
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
