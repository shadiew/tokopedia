<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faktur Pembayaran</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Inter Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6; /* Light gray background */
        }
        /* Custom scrollbar for better aesthetics */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
</head>
<body class="flex justify-center items-center min-h-screen p-4">
    <div class="bg-white shadow-xl rounded-xl p-8 md:p-12 w-full max-w-4xl border border-gray-200">
        <!-- Header Faktur -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 pb-6 border-b border-gray-200">
            <div class="mb-4 md:mb-0">
                <h1 class="text-4xl font-bold text-gray-800 mb-2">FAKTUR</h1>
                <p class="text-sm text-gray-600">#{{ $order->order_number }}</p>
            </div>
        </div>

        <!-- Detail Perusahaan & Pelanggan -->
        <div class="flex flex-col md:flex-row justify-between mb-8">
            <div class="mb-6 md:mb-0">
                <h2 class="text-lg font-semibold text-gray-700 mb-3">Faktur Untuk:</h2>
                <p class="text-gray-800 font-medium">{{ $order->billing_name }}</p>
                @if($order->billing_address)
                    <p class="text-gray-600">{{ $order->billing_address }}</p>
                @endif
                @if($order->billing_phone)
                    <p class="text-gray-600">{{ $order->billing_phone }}</p>
                @endif
                <p class="text-gray-600">Email: {{ $order->billing_email }}</p>
            </div>
            <div class="text-left md:text-right">
                <h2 class="text-lg font-semibold text-gray-700 mb-3">Detail Faktur:</h2>
                <p class="text-gray-600 mb-1"><span class="font-medium text-gray-700">Tanggal Faktur:</span> {{ $order->created_at->format('d M Y') }}</p>
                <p class="text-gray-600 mb-1"><span class="font-medium text-gray-700">Jatuh Tempo:</span> {{ $order->created_at->addDays(7)->format('d M Y') }}</p>
                <p class="text-gray-600 mb-1"><span class="font-medium text-gray-700">Status:</span> <span class="px-3 py-1 @if($order->status=='pending') bg-yellow-100 text-yellow-800 @elseif($order->status=='paid') bg-green-100 text-green-800 @elseif($order->status=='completed') bg-blue-100 text-blue-800 @elseif($order->status=='cancelled') bg-red-100 text-red-800 @else bg-gray-100 text-gray-800 @endif text-xs font-semibold rounded-full">
                    @switch($order->status)
                        @case('pending') Belum Dibayar @break
                        @case('paid') Sudah Dibayar @break
                        @case('completed') Selesai @break
                        @case('cancelled') Dibatalkan @break
                        @default {{ ucfirst($order->status) }}
                    @endswitch
                </span></p>
            </div>
        </div>

        <!-- Tabel Item -->
        <div class="mb-8 overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tl-lg">Deskripsi Item</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kuantitas</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Satuan</th>
                        <th class="py-3 px-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tr-lg">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($order->orderItems as $item)
                    <tr>
                        <td class="py-3 px-4 whitespace-nowrap text-sm text-gray-800">{{ $item->product_name }}</td>
                        <td class="py-3 px-4 whitespace-nowrap text-sm text-gray-600">{{ $item->quantity }}</td>
                        <td class="py-3 px-4 whitespace-nowrap text-sm text-gray-600">Rp {{ number_format($item->price) }}</td>
                        <td class="py-3 px-4 whitespace-nowrap text-sm text-gray-800 text-right">Rp {{ number_format($item->subtotal) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Detail Pesanan -->
        <div class="mb-8 p-6 bg-gray-50 rounded-lg border border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800 mb-3">Detail Pesanan</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <div class="mb-1"><span class="font-medium text-gray-700">Nomor Pesanan:</span> {{ $order->order_number }}</div>
                    <div class="mb-1"><span class="font-medium text-gray-700">Tanggal Pesanan:</span> {{ $order->created_at->format('d M Y, H:i') }}</div>
                    <div class="mb-1"><span class="font-medium text-gray-700">Status:</span> 
                        <span class="px-2 py-1 rounded-full text-xs font-semibold @if($order->status=='pending') bg-yellow-100 text-yellow-800 @elseif($order->status=='paid') bg-green-100 text-green-800 @elseif($order->status=='completed') bg-blue-100 text-blue-800 @elseif($order->status=='cancelled') bg-red-100 text-red-800 @else bg-gray-100 text-gray-800 @endif">
                            @switch($order->status)
                                @case('pending') Belum Dibayar @break
                                @case('paid') Sudah Dibayar @break
                                @case('completed') Selesai @break
                                @case('cancelled') Dibatalkan @break
                                @default {{ ucfirst($order->status) }}
                            @endswitch
                        </span>
                    </div>
                </div>
                <div>
                    <div class="mb-1"><span class="font-medium text-gray-700">Metode Pembayaran:</span> {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</div>
                    @if($order->payment)
                        <div class="mb-1"><span class="font-medium text-gray-700">Status Pembayaran:</span> <span class="font-semibold @if($order->payment->status=='paid') text-green-600 @elseif($order->payment->status=='pending') text-yellow-600 @else text-gray-600 @endif">{{ ucfirst($order->payment->status) }}</span></div>
                    @endif
                    @if($order->note)
                        <div class="mb-1"><span class="font-medium text-gray-700">Catatan:</span> {{ $order->note }}</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Ringkasan Total -->
        <div class="flex justify-end mb-8">
            <div class="w-full md:w-1/2 lg:w-1/3">
                <div class="flex justify-between py-2 border-b border-gray-200">
                    <span class="text-gray-700 font-medium">Subtotal:</span>
                    <span class="text-gray-800">Rp {{ number_format($order->total_amount) }}</span>
                </div>
                @if($order->tax_amount > 0)
                <div class="flex justify-between py-2 border-b border-gray-200">
                    <span class="text-gray-700 font-medium">Pajak ({{ round($order->tax_amount / max($order->total_amount,1) * 100) }}%):</span>
                    <span class="text-gray-800">Rp {{ number_format($order->tax_amount) }}</span>
                </div>
                @endif
                @if($order->discount_amount > 0)
                <div class="flex justify-between py-2 border-b border-gray-200">
                    <span class="text-gray-700 font-medium">Diskon:</span>
                    <span class="text-green-600">-Rp {{ number_format($order->discount_amount) }}</span>
                </div>
                @endif
                <div class="flex justify-between py-2">
                    <span class="text-xl font-bold text-gray-800">TOTAL:</span>
                    <span class="text-xl font-bold text-indigo-600">Rp {{ number_format($order->final_amount) }}</span>
                </div>
                @if($order->status == 'pending' && $order->checkout_url)
                <a href="{{ $order->checkout_url }}" target="_blank" rel="noopener" class="mt-6 w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-semibold text-white bg-blue-600 hover:bg-blue-700 transition">Bayar Sekarang</a>
                @endif
            </div>
        </div>

        <!-- Footer Faktur -->
        <div class="text-center text-sm text-gray-500 pt-6 border-t border-gray-200">
            <p>&copy; {{ date('Y') }} DigitalStore. Semua hak dilindungi undang-undang.</p>
        </div>
    </div>
</body>
</html> 