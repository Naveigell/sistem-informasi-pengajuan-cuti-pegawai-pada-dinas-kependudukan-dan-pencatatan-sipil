@extends('layouts.admin.admin')

@section('content-title', 'Dashboard')

@section('content-body')
    <div class="row">
        <div class="col-3">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="fas fa-check"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Cuti Diterima</h4>
                    </div>
                    <div class="card-body">
                        {{ $totalLeavesApproved }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-times"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Cuti Ditolak</h4>
                    </div>
                    <div class="card-body">
                        {{ $totalLeavesRejected }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Cuti Pending</h4>
                    </div>
                    <div class="card-body">
                        {{ $totalLeavesPending }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                    <i class="fas fa-user"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Pegawai</h4>
                    </div>
                    <div class="card-body">
                        {{ $totalEmployee }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (auth()->user()->isLeader() || (!auth()->user()->isAdmin() && $leaveNotifications->isNotEmpty()))
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header"><h4>Pemberitahuan</h4></div>
                    <div class="card-body">
                        @foreach($leaveNotifications as $notification)
                            <div class="alert alert-info alert-dismissible show fade">
                                <div class="alert-body">
                                    <button class="close" data-dismiss="alert">
                                        <span>×</span>
                                    </button>
                                    {!! $notification->description !!}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('stack-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js" integrity="sha512-QSkVNOCYLtj73J4hbmVoOV6KVZuMluZlioC+trLpewV8qMjsWqlIQvkn1KGX2StWvPMdWGBqim1xlC8krl1EKQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

@endpush
