@extends('layouts.admin.admin')

@section('content-title', 'Pending Cuti')

@section('content-body')
    @if ($message = session()->get('success'))
        <x-alert.success :message="$message"></x-alert.success>
    @endif
    @if($message = session()->get('error'))
        <x-alert.danger :message="$message"></x-alert.danger>
    @endif
    <div class="col-lg-12 col-md-12 col-12 col-sm-12 no-padding-margin">
        <div class="card">
            <div class="card-header">
                <h4>Cuti</h4>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th class="col-1">No</th>
                            <th class="col-1">Nama Pegawai</th>
                            <th class="col-1">File Pengajuan Cuti</th>
                            <th class="col-2">Dari Tanggal</th>
                            <th class="col-2">Sampai Tanggal</th>
                            <th class="col-2">Total Hari</th>
                            <th class="col-1">Disetujui Oleh</th>
                            <th class="col-1">Tidak Disetujui Oleh</th>
                            <th class="col-1">Status</th>
                            <th class="col-3">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($leaves as $leave)
                            <tr>
                                <td>
                                    <x-iterate :pagination="$leaves" :loop="$loop"></x-iterate>
                                </td>
                                <td>{{ $leave->user->name }}</td>
                                <td><a href="{{ asset('storage/employees/leaves/' . $leave->filename) }}" class="">Download</a></td>
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
                                <td>
                                    <button data-route="{{ route('admin.leaves.request.pending.status.update', [$leave, \App\Models\Leave::STATUS_APPROVED]) }}" data-title="Terima" data-body="Yakin ingin <span class='text text-success'>menerima</span>?" class="btn btn-success trigger--modal-aggrement" data-toggle="modal" data-target="#modal-aggrement"><i class="fa fa-check"></i></button>
                                    <button data-route="{{ route('admin.leaves.request.pending.status.update', [$leave, \App\Models\Leave::STATUS_REJECTED]) }}" data-title="Tolak" data-body="Yakin ingin <span class='text text-danger'>menolak</span>?" class="btn btn-danger trigger--modal-aggrement" data-toggle="modal" data-target="#modal-aggrement"><i class="fa fa-times"></i></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" style="text-align: center;">Data Empty</td>
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

@push('stack-script')
    <script>
        $('.trigger--modal-aggrement').on('click', function () {
            $('#modal-aggrement .modal-title').html($(this).data('title'));
            $('#modal-aggrement .modal-body').html($(this).data('body'));
            $('#modal-aggrement form').attr('action', $(this).data('route'));
        })
    </script>
@endpush

@section('content-modal')
    <x-modal.aggrement></x-modal.aggrement>
@endsection
