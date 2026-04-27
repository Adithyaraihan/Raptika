{{-- ============================================================ --}}
{{-- FILE: resources/views/smartjabar/joined-apps/index.blade.php --}}
{{-- ============================================================ --}}
@extends('layouts.app')

@section('title', 'Joined Apps — SmartJabar')

@section('content')
<div class="page-header">
    <div>
        <h1>Joined Apps</h1>
        <p>Data aplikasi yang bergabung dengan SmartJabar</p>
    </div>
    <a href="{{ route('smartjabar.joined-apps.create') }}" class="btn btn-primary">
        + Tambah Data
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Tahun</th>
                <th>Bulan</th>
                <th>Total Apps</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $item)
            <tr>
                <td><span style="color:var(--muted);font-family:var(--mono);font-size:.8rem">{{ $loop->iteration }}</span></td>
                <td><span class="badge">{{ $item->year }}</span></td>
                <td>{{ DateTime::createFromFormat('!m', $item->month)->format('F') }}</td>
                <td style="font-family:var(--mono)">{{ number_format($item->total_apps) }}</td>
                <td>
                    <div class="actions">
                        <a href="{{ route('smartjabar.joined-apps.edit', $item->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                        <form action="{{ route('smartjabar.joined-apps.destroy', $item->id) }}" method="POST"
                              onsubmit="return confirm('Hapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr class="empty-row">
                <td colspan="5">Belum ada data. <a href="{{ route('smartjabar.joined-apps.create') }}" style="color:var(--accent-2)">Tambah sekarang</a></td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection