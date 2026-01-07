@extends('admin.layouts.app')

@section('title', 'Laporan Penjualan')
@section('page_title', 'Laporan Penjualan')

@section('content')

{{-- ================= FILTER ================= --}}
<div class="card card-soft mb-4">
    <div class="card-body">
        <h4 class="mb-3">Export Laporan Penjualan</h4>

        <form action="{{ route('admin.reports.transactions') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Dari Tanggal</label>
                <input type="date" name="from" class="form-control" value="{{ request('from') }}">
            </div>

            <div class="col-md-4">
                <label class="form-label">Sampai Tanggal</label>
                <input type="date" name="to" class="form-control" value="{{ request('to') }}">
            </div>

            <div class="col-md-4 d-flex align-items-end">
                <div class="d-flex gap-2 w-100">
                    <a href="{{ route('admin.reports.transactions.export-excel', request()->query()) }}"
                       class="btn btn-primary flex-fill">
                        <i class="fas fa-file-excel me-1"></i> Export Excel
                    </a>

                    <a href="{{ route('admin.reports.transactions.export.pdf', request()->query()) }}"
                       class="btn btn-danger flex-fill"
                       target="_blank">
                        <i class="fas fa-file-pdf me-1"></i> Export PDF
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- ================= TABLE ================= --}}
<div class="card card-soft">
    <div class="card-body">

        <h5 class="mb-3">
            Hasil Laporan
            @if($dateFrom || $dateTo)
                <small class="text-muted">
                    (
                    @if($dateFrom)
                        {{ \Carbon\Carbon::parse($dateFrom)->format('d M Y') }}
                    @endif
                    @if($dateFrom && $dateTo)
                        s/d
                    @endif
                    @if($dateTo)
                        {{ \Carbon\Carbon::parse($dateTo)->format('d M Y') }}
                    @endif
                    )
                </small>
            @endif
        </h5>

        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead class="table-light">
                <tr>
                    <th width="60">No</th>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th width="80">Qty</th>
                    <th width="120">Harga</th>
                    <th width="120">Total</th>
                    <th>Catatan</th>
                </tr>
                </thead>

                <tbody>
                @forelse($transactions as $index => $trx)
                    <tr>
                        <td>{{ $index + 1 }}</td>

                        <td>
                            {{ \Carbon\Carbon::parse($trx->transaction_date)->format('d M Y H:i') }}
                        </td>

                        <td>{{ $trx->customer_name ?? '-' }}</td>

                        <td class="text-center">
                            {{ $trx->quantity ?? $trx->qty ?? 1 }}
                        </td>

                        <td>
                            Rp {{ number_format($trx->price ?? $trx->total, 0, ',', '.') }}
                        </td>

                        <td>
                            <strong>
                                Rp {{ number_format($trx->total, 0, ',', '.') }}
                            </strong>
                        </td>

                        <td>{{ $trx->note ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            Tidak ada transaksi pada periode ini.
                        </td>
                    </tr>
                @endforelse
                </tbody>

                @if($transactions->count())
                    <tfoot>
                    <tr>
                        <td colspan="5" class="text-end">
                            <strong>Total Pemasukan</strong>
                        </td>
                        <td colspan="2">
                            <strong>
                                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                            </strong>
                        </td>
                    </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>

@endsection
