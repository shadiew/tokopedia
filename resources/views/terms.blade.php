@extends('layouts.app')

@section('title', 'Syarat & Ketentuan - Toko Digital Download')
@section('description', 'Syarat dan ketentuan penggunaan layanan toko digital download.')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="fw-bold mb-4">
                <i class="fas fa-file-contract me-2"></i>Syarat & Ketentuan
            </h1>
            <p class="text-muted mb-5">Terakhir diperbarui: {{ date('d F Y') }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">1. Penerimaan Syarat dan Ketentuan</h5>
                    <p>
                        Dengan mengakses dan menggunakan website ini, Anda menyetujui untuk terikat dengan syarat dan ketentuan ini. 
                        Jika Anda tidak setuju dengan bagian mana pun dari syarat ini, Anda tidak boleh menggunakan layanan kami.
                    </p>

                    <h5 class="fw-bold mb-3 mt-4">2. Definisi</h5>
                    <ul>
                        <li><strong>Kami/Website:</strong> DigitalStore dan semua layanan terkait</li>
                        <li><strong>Anda/Pengguna:</strong> Individu atau entitas yang menggunakan layanan kami</li>
                        <li><strong>Produk Digital:</strong> File, software, template, atau konten digital lainnya</li>
                        <li><strong>Pesanan:</strong> Transaksi pembelian produk digital</li>
                    </ul>

                    <h5 class="fw-bold mb-3 mt-4">3. Penggunaan Layanan</h5>
                    <p>Anda setuju untuk:</p>
                    <ul>
                        <li>Memberikan informasi yang akurat dan lengkap</li>
                        <li>Menjaga kerahasiaan akun Anda</li>
                        <li>Menggunakan layanan sesuai dengan hukum yang berlaku</li>
                        <li>Tidak menyalahgunakan layanan untuk tujuan ilegal</li>
                        <li>Tidak membagikan file yang dibeli kepada pihak lain</li>
                    </ul>

                    <h5 class="fw-bold mb-3 mt-4">4. Pembelian dan Pembayaran</h5>
                    <ul>
                        <li>Harga produk ditampilkan dalam Rupiah (IDR)</li>
                        <li>Pembayaran harus dilakukan sebelum file dapat diunduh</li>
                        <li>Kami menerima pembayaran melalui metode yang tersedia</li>
                        <li>Pembayaran yang gagal akan mengakibatkan pembatalan pesanan</li>
                        <li>Refund hanya diberikan sesuai kebijakan yang berlaku</li>
                    </ul>

                    <h5 class="fw-bold mb-3 mt-4">5. Lisensi dan Penggunaan</h5>
                    <ul>
                        <li>Setelah pembelian, Anda mendapatkan lisensi untuk menggunakan produk</li>
                        <li>Lisensi bersifat pribadi dan tidak dapat dialihkan</li>
                        <li>Dilarang mendistribusikan ulang produk yang dibeli</li>
                        <li>Dilarang menggunakan produk untuk tujuan komersial tanpa izin</li>
                        <li>Hak cipta tetap dimiliki oleh pencipta asli</li>
                    </ul>

                    <h5 class="fw-bold mb-3 mt-4">6. Ketersediaan Layanan</h5>
                    <p>
                        Kami berusaha untuk menjaga ketersediaan layanan 24/7, namun kami tidak menjamin bahwa layanan akan selalu tersedia tanpa gangguan. 
                        Kami dapat melakukan pemeliharaan atau update yang dapat menyebabkan layanan tidak tersedia sementara.
                    </p>

                    <h5 class="fw-bold mb-3 mt-4">7. Batasan Tanggung Jawab</h5>
                    <ul>
                        <li>Kami tidak bertanggung jawab atas kerusakan yang disebabkan oleh penggunaan produk</li>
                        <li>Kami tidak menjamin bahwa produk bebas dari virus atau malware</li>
                        <li>Pengguna bertanggung jawab atas penggunaan produk yang dibeli</li>
                        <li>Kami tidak bertanggung jawab atas kehilangan data pengguna</li>
                    </ul>

                    <h5 class="fw-bold mb-3 mt-4">8. Hak Kekayaan Intelektual</h5>
                    <ul>
                        <li>Semua konten website dilindungi hak cipta</li>
                        <li>Dilarang menyalin, mendistribusikan, atau menggunakan konten tanpa izin</li>
                        <li>Produk digital tetap menjadi hak cipta pencipta asli</li>
                        <li>Penggunaan logo dan merek dagang harus sesuai ketentuan</li>
                    </ul>

                    <h5 class="fw-bold mb-3 mt-4">9. Privasi dan Keamanan</h5>
                    <p>
                        Penggunaan informasi pribadi Anda diatur oleh Kebijakan Privasi kami. 
                        Kami berkomitmen untuk melindungi data pribadi Anda sesuai dengan standar keamanan yang tinggi.
                    </p>

                    <h5 class="fw-bold mb-3 mt-4">10. Pembatalan dan Refund</h5>
                    <ul>
                        <li>Pesanan dapat dibatalkan sebelum pembayaran selesai</li>
                        <li>Refund hanya diberikan dalam kondisi tertentu</li>
                        <li>Setelah file diunduh, tidak ada refund</li>
                        <li>Refund akan diproses dalam waktu 7-14 hari kerja</li>
                    </ul>

                    <h5 class="fw-bold mb-3 mt-4">11. Pelanggaran dan Sanksi</h5>
                    <ul>
                        <li>Pelanggaran syarat ini dapat mengakibatkan pemblokiran akun</li>
                        <li>Kami berhak mengambil tindakan hukum jika diperlukan</li>
                        <li>Pengguna yang melanggar dapat dikenakan sanksi sesuai hukum</li>
                    </ul>

                    <h5 class="fw-bold mb-3 mt-4">12. Perubahan Syarat</h5>
                    <p>
                        Kami berhak mengubah syarat dan ketentuan ini kapan saja. 
                        Perubahan akan diberitahukan melalui website atau email. 
                        Penggunaan berkelanjutan setelah perubahan berarti Anda menyetujui syarat yang baru.
                    </p>

                    <h5 class="fw-bold mb-3 mt-4">13. Hukum yang Berlaku</h5>
                    <p>
                        Syarat dan ketentuan ini tunduk pada hukum Republik Indonesia. 
                        Setiap sengketa akan diselesaikan melalui pengadilan yang berwenang di Indonesia.
                    </p>

                    <h5 class="fw-bold mb-3 mt-4">14. Kontak</h5>
                    <p>Untuk pertanyaan tentang syarat dan ketentuan ini, silakan hubungi:</p>
                    <ul>
                        <li>Email: legal@digitalstore.com</li>
                        <li>Telepon: +62 21-1234-5678</li>
                        <li>Alamat: Jl. Sudirman No. 123, Jakarta Pusat</li>
                    </ul>

                    <div class="alert alert-warning mt-4">
                        <h6 class="fw-bold mb-2">
                            <i class="fas fa-exclamation-triangle me-2"></i>Peringatan
                        </h6>
                        <p class="mb-0">
                            Dengan menggunakan layanan kami, Anda mengakui bahwa Anda telah membaca, 
                            memahami, dan menyetujui semua syarat dan ketentuan yang tercantum di atas.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 