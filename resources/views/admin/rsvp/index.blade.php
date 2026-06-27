@extends('admin.layouts.app')
@section('title', 'RSVP Tamu')

@section('content')
<h2 class="font-semibold mb-4">Daftar RSVP Tamu</h2>
<div class="bg-white rounded shadow overflow-hidden">
<table class="w-full text-sm">
    <thead class="bg-gray-50"><tr class="text-left"><th class="p-3">Nama</th><th>Kehadiran</th><th>Jumlah Tamu</th><th>Pesan</th><th>Tanggal Isi</th><th class="text-right p-3">Aksi</th></tr></thead>
    <tbody>
        @forelse ($rsvps as $rsvp)
        <tr class="border-t">
            <td class="p-3">{{ $rsvp->guest_name }}</td>
            <td>
                @if($rsvp->attendance == 'hadir')
                    <span class="text-green-600">Hadir</span>
                @elseif($rsvp->attendance == 'tidak_hadir')
                    <span class="text-red-600">Tidak Hadir</span>
                @else
                    <span class="text-yellow-600">Masih Ragu</span>
                @endif
            </td>
            <td>{{ $rsvp->total_guest }}</td>
            <td>{{ $rsvp->message }}</td>
            <td>{{ $rsvp->created_at->format('d M Y H:i') }}</td>
            <td class="p-3 text-right">
                @can('delete-rsvp')
                <form action="{{ route('admin.rsvp.destroy', $rsvp) }}" method="POST" onsubmit="return confirm('Hapus?')">
                    @csrf @method('DELETE')
                    <button class="text-red-600">Hapus</button>
                </form>
                @endcan
            </td>
        </tr>
        @empty
        <tr><td colspan="6" class="p-4 text-center text-gray-400">Belum ada RSVP</td></tr>
        @endforelse
    </tbody>
</table>
</div>
{{ $rsvps->links() }}
@endsection
