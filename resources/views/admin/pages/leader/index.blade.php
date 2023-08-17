@extends('layouts.admin.admin')

@section('content-title', 'Kepala')

@section('content-body')
    @if ($message = session()->get('success'))
        <x-alert.success :message="$message"></x-alert.success>
    @endif
    <div class="col-lg-12 col-md-12 col-12 col-sm-12 no-padding-margin">
        <div class="card">
            <div class="card-header">
                <h4>Kepala</h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.leaders.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Kepala</a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th class="col-1">No</th>
                            <th class="col-2">Nama Kepala</th>
                            <th class="col-2">Username</th>
                            <th class="col-2">Email</th>
                            <th class="col-2">Jabatan</th>
                            <th class="col-2">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($leaders as $leader)
                            <tr>
                                <td>
                                    <x-iterate :pagination="$leaders" :loop="$loop"></x-iterate>
                                </td>
                                <td>{{ $leader->name }}</td>
                                <td>{{ $leader->username }}</td>
                                <td>{{ $leader->email }}</td>
                                <td>
                                    @if($leader->role == \App\Models\User::ROLE_HEAD_OF_FIELD)
                                        <span class="badge badge-success">{{ $leader->role_translated }}</span>
                                    @else
                                        <span class="badge badge-primary">{{ $leader->role_translated }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.leaders.edit', $leader) }}" class="btn btn-warning"><i class="fa fa-eye"></i></a>
                                    <button class="btn btn-danger btn-action trigger--modal-delete cursor-pointer" data-url="{{ route('admin.leaders.destroy', $leader) }}"><i class="fas fa-trash"></i></button>
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

                {{ $leaders->links() }}
            </div>
        </div>
    </div>
@endsection

@section('content-modal')
    <x-modal.delete :name="'Kepala'"></x-modal.delete>
@endsection
