<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan Bulanan</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 6px; }
        th { background: #f3f4f6; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
    </style>
</head>
<body>

<h3>Laporan Penjualan</h3>
<p>Periode: {{ $dateFrom }} s/d {{ $dateTo }}</p>
<p>Dibuat: {{ $generatedAt }}</p>

<table>
    <thead>
        <tr>
            <th width="30">No</th>
            <th>Tanggal</th>
            <th>Nama</th>
            <th>Produk</th>
            <th class="text-center">Qty</th>
            <th class="text-right">Harga</th>
        </tr>
    </thead>

    <tbody>
@forelse($transactions as $orderId => $rows)
    @php
        $rows = collect($rows);
        $first = $rows->first();
    @endphp

    @foreach($rows as $i => $trx)
        <tr>
            {{-- HEADER ORDER --}}
            @if($i === 0)
                <td rowspan="{{ $rows->count() }}" class="text-center">
                    {{ $loop->parent->iteration }}
                </td>

                <td rowspan="{{ $rows->count() }}">
                    {{ \Carbon\Carbon::parse($first->transaction_date)->format('d M Y H:i') }}
                </td>

                <td rowspan="{{ $rows->count() }}">
                    {{ $first->customer_name ?? '-' }}
                </td>
            @endif

            {{-- PRODUK --}}
            <td>
                {{ $trx->product->name ?? 'Produk #' . $trx->product_id }}
            </td>

            <td class="text-center">
                {{ $trx->quantity }}
            </td>

            <td class="text-right">
                Rp {{ number_format($trx->price,0,',','.') }}
            </td>

            
        </tr>
    @endforeach

@empty
    <tr>
        <td colspan="8" class="text-center">
            Tidak ada transaksi
        </td>
    </tr>
@endforelse
    </tbody>

    
</table>

</body>
</html>
