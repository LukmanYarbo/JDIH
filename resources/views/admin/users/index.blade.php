@extends('layouts.admin')

@section('title', 'Manajemen User - JDIH DPRD Bolmut')
@section('page_title', 'Manajemen User')

@section('content')
    <div class="card border-0 shadow-sm p-4 bg-white">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h5 class="fw-bold text-dark m-0"><i class="bi bi-people me-1"></i> Pengguna Terdaftar</h5>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary rounded-pill px-4">
                <i class="bi bi-person-plus me-1"></i> Tambah User
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr class="text-muted fs-7">
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Terdaftar</th>
                        <th class="text-end" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr class="fs-7.5">
                            <td class="fw-bold text-dark fs-6">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @foreach($user->roles as $role)
                                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1.5 fw-semibold fs-8">
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                            </td>
                            <td class="text-muted">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-light border" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')" class="m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger text-white border" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
