@extends('layouts.admin')

@section('title', 'Tinjau Pengajuan ' . $order->school_name)
@section('page-title', 'Tinjau Permohonan #' . $order->order_number)

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Permohonan: {{ $order->school_name }}</h1>
        <p class="page-subtitle">Verifikasi ketersediaan jadwal edukator dan kapasitas wahana untuk rombongan ini.</p>
    </div>
    <a href="{{ route('admin.school.index') }}" class="btn btn-secondary btn-sm">Kembali ke Antrean</a>
</div>

<div class="grid-2">
    <!-- Identitas Sekolah & PIC -->
    <div>
        <div class="card" style="margin-bottom: 1.5rem;">
            <div class="card-header">
                <div class="card-title">Profil Institusi & Penanggung Jawab</div>
                @if($order->status === 'pending_approval')
                    <span class="badge badge-warning">Menunggu Persetujuan</span>
                @elseif($order->status === 'approved')
                    <span class="badge badge-approved">Telah Disetujui</span>
                @elseif($order->status === 'rejected')
                    <span class="badge badge-danger">Ditolak</span>
                @elseif($order->status === 'paid')
                    <span class="badge badge-paid">Lunas</span>
                @endif
            </div>
            <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem;">
                <tr style="border-bottom: 1px solid var(--admin-border);">
                    <td style="padding: 0.6rem 0; color: var(--admin-muted);">Nama Sekolah</td>
                    <td style="padding: 0.6rem 0; text-align: right; font-weight: 700; color: #ffffff;">{{ $order->school_name }}</td>
                </tr>
                <tr style="border-bottom: 1px solid var(--admin-border);">
                    <td style="padding: 0.6rem 0; color: var(--admin-muted);">Alamat Sekolah</td>
                    <td style="padding: 0.6rem 0; text-align: right; color: #ffffff;">{{ $order->school_address }}</td>
                </tr>
                <tr style="border-bottom: 1px solid var(--admin-border);">
                    <td style="padding: 0.6rem 0; color: var(--admin-muted);">Nama PIC / Guru</td>
                    <td style="padding: 0.6rem 0; text-align: right; color: #ffffff;">{{ $order->pic_name }}</td>
                </tr>
                <tr style="border-bottom: 1px solid var(--admin-border);">
                    <td style="padding: 0.6rem 0; color: var(--admin-muted);">Jabatan PIC</td>
                    <td style="padding: 0.6rem 0; text-align: right; color: #ffffff;">{{ $order->pic_position }}</td>
                </tr>
                <tr style="border-bottom: 1px solid var(--admin-border);">
                    <td style="padding: 0.6rem 0; color: var(--admin-muted);">WhatsApp PIC</td>
                    <td style="padding: 0.6rem 0; text-align: right; color: #ffffff;">{{ $order->pic_phone }}</td>
                </tr>
                <tr>
                    <td style="padding: 0.6rem 0; color: var(--admin-muted);">Email Sekolah</td>
                    <td style="padding: 0.6rem 0; text-align: right; color: #ffffff;">{{ $order->pic_email }}</td>
                </tr>
            </table>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="card-title">Catatan dari Sekolah</div>
            </div>
            <p style="font-size: 0.85rem; color: var(--admin-muted); line-height: 1.7;">
                {{ $order->notes ?: 'Tidak ada catatan tambahan.' }}
            </p>
        </div>
    </div>

    <!-- Rincian Kegiatan & Formulir Persetujuan/Penolakan -->
    <div>
        <div class="card" style="margin-bottom: 1.5rem;">
            <div class="card-header">
                <div class="card-title">Rencana Kunjungan & Biaya</div>
            </div>
            <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem; margin-bottom: 1.25rem;">
                <tr style="border-bottom: 1px solid var(--admin-border);">
                    <td style="padding: 0.6rem 0; color: var(--admin-muted);">Paket Dipilih</td>
                    <td style="padding: 0.6rem 0; text-align: right; color: #ffffff; font-weight: 600;">
                        {{ $order->package->name ?? 'Paket Sekolah' }}
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid var(--admin-border);">
                    <td style="padding: 0.6rem 0; color: var(--admin-muted);">Tanggal Diajukan</td>
                    <td style="padding: 0.6rem 0; text-align: right; color: var(--admin-primary); font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700;">
                        {{ \Carbon\Carbon::parse($order->visit_date)->isoFormat('dddd, D MMMM Y') }}
                    </td>
                </tr>
                <tr style="border-bottom: 1px solid var(--admin-border);">
                    <td style="padding: 0.6rem 0; color: var(--admin-muted);">Jumlah Peserta</td>
                    <td style="padding: 0.6rem 0; text-align: right; color: #ffffff;">{{ $order->quantity }} Siswa</td>
                </tr>
                <tr style="border-bottom: 1px solid var(--admin-border);">
                    <td style="padding: 0.6rem 0; color: var(--admin-muted);">Tarif per Siswa</td>
                    <td style="padding: 0.6rem 0; text-align: right; color: #ffffff;">IDR {{ number_format($order->unit_price, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td style="padding: 0.8rem 0; font-weight: 700; color: #ffffff;">Total Biaya (Server)</td>
                    <td style="padding: 0.8rem 0; text-align: right; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.25rem; font-weight: 800; color: var(--admin-primary);">
                        IDR {{ number_format($order->total_price, 0, ',', '.') }}
                    </td>
                </tr>
            </table>

            @if($order->admin_notes)
                <div style="background-color: #0c0f17; border: 1px solid var(--admin-border); padding: 0.85rem 1rem; border-radius: 4px; font-size: 0.8rem;">
                    <div style="color: var(--admin-muted); font-weight: 600; margin-bottom: 0.25rem;">Catatan Pengelola Terkini:</div>
                    <div style="color: #ffffff;">{{ $order->admin_notes }}</div>
                </div>
            @endif
        </div>

        <!-- FORM TINDAKAN ADMIN (SETUJUI / TOLAK) -->
        <div class="card" style="border-color: var(--admin-border); background-color: #141c2e;">
            <div class="card-header">
                <div class="card-title">Keputusan Administrator</div>
            </div>

            <form action="{{ route('admin.school.status', $order->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="admin_notes">Catatan Administrator untuk Pemesan (Opsional)</label>
                    <textarea id="admin_notes" name="admin_notes" class="form-control" placeholder="Contoh: Jadwal telah dikonfirmasi. Kuota edukator tersedia. Silakan lakukan pembayaran tagihan.">{{ old('admin_notes', $order->admin_notes) }}</textarea>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                    <!-- Tombol Setujui -->
                    <button type="submit" name="action" value="approve" class="btn btn-success btn-block" style="flex: 2;">
                        Setujui Permohonan Sekolah
                    </button>

                    <!-- Tombol Tolak -->
                    <button type="submit" name="action" value="reject" class="btn btn-danger btn-block" style="flex: 1;" onclick="return confirm('Tolak permohonan kunjungan sekolah ini?')">
                        Tolak
                    </button>
                </div>
            </form>

            <div style="font-size: 0.75rem; color: var(--admin-sub); margin-top: 1rem; line-height: 1.6;">
                Setelah disetujui, tombol pelunasan pembayaran tagihan melalui Midtrans akan otomatis aktif pada akun pemesan.
            </div>
        </div>
    </div>
</div>
@endsection
