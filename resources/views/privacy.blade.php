@extends('layouts.app')

@section('title', 'Kebijakan Privasi - Toko Digital Download')
@section('description', 'Kebijakan privasi dan perlindungan data pribadi pengguna.')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="fw-bold mb-4">
                <i class="fas fa-shield-alt me-2"></i>Kebijakan Privasi
            </h1>
            <p class="text-muted mb-5">Terakhir diperbarui: {{ date('d F Y') }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">1. Informasi yang Kami Kumpulkan</h5>
                    <p>Kami mengumpulkan informasi berikut dari pengguna kami:</p>
                    <ul>
                        <li>Informasi pribadi (nama, email, nomor telepon)</li>
                        <li>Informasi pembayaran</li>
                        <li>Data penggunaan website</li>
                        <li>Informasi perangkat dan browser</li>
                    </ul>

                    <h5 class="fw-bold mb-3 mt-4">2. Bagaimana Kami Menggunakan Informasi</h5>
                    <p>Informasi yang kami kumpulkan digunakan untuk:</p>
                    <ul>
                        <li>Memproses pesanan dan pembayaran</li>
                        <li>Mengirim file digital yang dibeli</li>
                        <li>Memberikan dukungan pelanggan</li>
                        <li>Meningkatkan layanan kami</li>
                        <li>Mengirim informasi penting terkait pesanan</li>
                    </ul>

                    <h5 class="fw-bold mb-3 mt-4">3. Perlindungan Data</h5>
                    <p>Kami berkomitmen untuk melindungi data pribadi Anda dengan:</p>
                    <ul>
                        <li>Menggunakan enkripsi SSL untuk transfer data</li>
                        <li>Menyimpan data di server yang aman</li>
                        <li>Membatasi akses ke data pribadi</li>
                        <li>Melakukan audit keamanan secara berkala</li>
                    </ul>

                    <h5 class="fw-bold mb-3 mt-4">4. Berbagi Informasi</h5>
                    <p>Kami tidak menjual, memperdagangkan, atau mentransfer data pribadi Anda kepada pihak ketiga, kecuali:</p>
                    <ul>
                        <li>Untuk memproses pembayaran (gateway pembayaran)</li>
                        <li>Ketika diwajibkan oleh hukum</li>
                        <li>Untuk melindungi hak dan keamanan kami</li>
                    </ul>

                    <h5 class="fw-bold mb-3 mt-4">5. Cookie dan Teknologi Pelacakan</h5>
                    <p>Kami menggunakan cookie untuk:</p>
                    <ul>
                        <li>Mengingat preferensi Anda</li>
                        <li>Menganalisis penggunaan website</li>
                        <li>Meningkatkan pengalaman pengguna</li>
                        <li>Mengamankan sesi login</li>
                    </ul>

                    <h5 class="fw-bold mb-3 mt-4">6. Hak Pengguna</h5>
                    <p>Anda memiliki hak untuk:</p>
                    <ul>
                        <li>Mengakses data pribadi Anda</li>
                        <li>Memperbaiki data yang tidak akurat</li>
                        <li>Menghapus data pribadi</li>
                        <li>Membatasi penggunaan data</li>
                        <li>Mengundurkan diri dari komunikasi marketing</li>
                    </ul>

                    <h5 class="fw-bold mb-3 mt-4">7. Retensi Data</h5>
                    <p>Kami menyimpan data pribadi Anda selama:</p>
                    <ul>
                        <li>Akun Anda aktif</li>
                        <li>Diperlukan untuk menyediakan layanan</li>
                        <li>Diwajibkan oleh hukum</li>
                    </ul>

                    <h5 class="fw-bold mb-3 mt-4">8. Keamanan</h5>
                    <p>Kami menerapkan langkah-langkah keamanan yang tepat untuk melindungi data Anda dari:</p>
                    <ul>
                        <li>Akses yang tidak sah</li>
                        <li>Perubahan yang tidak sah</li>
                        <li>Pengungkapan yang tidak sah</li>
                        <li>Penghancuran yang tidak sah</li>
                    </ul>

                    <h5 class="fw-bold mb-3 mt-4">9. Perubahan Kebijakan</h5>
                    <p>Kami dapat memperbarui kebijakan privasi ini dari waktu ke waktu. Perubahan akan diberitahukan melalui:</p>
                    <ul>
                        <li>Pemberitahuan di website</li>
                        <li>Email kepada pengguna terdaftar</li>
                        <li>Update tanggal "Terakhir diperbarui"</li>
                    </ul>

                    <h5 class="fw-bold mb-3 mt-4">10. Kontak</h5>
                    <p>Jika Anda memiliki pertanyaan tentang kebijakan privasi ini, silakan hubungi kami:</p>
                    <ul>
                        <li>Email: privacy@digitalstore.com</li>
                        <li>Telepon: +62 21-1234-5678</li>
                        <li>Alamat: Jl. Sudirman No. 123, Jakarta Pusat</li>
                    </ul>

                    <div class="alert alert-info mt-4">
                        <h6 class="fw-bold mb-2">
                            <i class="fas fa-info-circle me-2"></i>Penting
                        </h6>
                        <p class="mb-0">
                            Dengan menggunakan layanan kami, Anda menyetujui kebijakan privasi ini. 
                            Jika Anda tidak setuju dengan kebijakan ini, silakan jangan menggunakan layanan kami.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 