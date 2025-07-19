@extends('layouts.app')

@section('title', 'Kontak Kami - Toko Digital Download')
@section('description', 'Hubungi tim support kami untuk bantuan dan pertanyaan seputar produk digital.')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="fw-bold mb-4 text-center">
                <i class="fas fa-envelope me-2"></i>Kontak Kami
            </h1>
            <p class="lead text-center text-muted mb-5">
                Kami siap membantu Anda dengan pertanyaan dan dukungan teknis
            </p>
        </div>
    </div>

    <div class="row">
        <!-- Contact Information -->
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informasi Kontak
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Email</h6>
                                <p class="mb-0 text-muted">support@digitalstore.com</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-success bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="fab fa-whatsapp"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">WhatsApp</h6>
                                <p class="mb-0 text-muted">+62 812-3456-7890</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-info bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Telepon</h6>
                                <p class="mb-0 text-muted">+62 21-1234-5678</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center">
                            <div class="bg-warning bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Alamat</h6>
                                <p class="mb-0 text-muted">Jl. Sudirman No. 123, Jakarta Pusat</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Jam Operasional</h6>
                        <div class="row">
                            <div class="col-6">
                                <small class="text-muted">Senin - Jumat</small><br>
                                <span class="fw-bold">09:00 - 18:00</span>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Sabtu</small><br>
                                <span class="fw-bold">09:00 - 15:00</span>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h6 class="fw-bold mb-3">Ikuti Kami</h6>
                        <div class="d-flex gap-2">
                            <a href="#" class="btn btn-outline-primary btn-sm">
                                <i class="fab fa-facebook"></i>
                            </a>
                            <a href="#" class="btn btn-outline-info btn-sm">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="btn btn-outline-danger btn-sm">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="btn btn-outline-dark btn-sm">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-paper-plane me-2"></i>Kirim Pesan
                    </h6>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nama Lengkap *</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Nomor Telepon</label>
                                <input type="tel" class="form-control" id="phone" name="phone">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="subject" class="form-label">Subjek *</label>
                                <select class="form-select" id="subject" name="subject" required>
                                    <option value="">Pilih subjek</option>
                                    <option value="general">Pertanyaan Umum</option>
                                    <option value="technical">Dukungan Teknis</option>
                                    <option value="payment">Pembayaran</option>
                                    <option value="product">Produk</option>
                                    <option value="complaint">Keluhan</option>
                                    <option value="suggestion">Saran</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="message" class="form-label">Pesan *</label>
                            <textarea class="form-control" id="message" name="message" rows="5" 
                                      placeholder="Tulis pesan Anda di sini..." required></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="agree" required>
                                <label class="form-check-label" for="agree">
                                    Saya setuju dengan <a href="{{ route('privacy') }}" target="_blank">Kebijakan Privasi</a>
                                </label>
                            </div>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>Kirim Pesan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="fw-bold mb-4 text-center">Pertanyaan yang Sering Diajukan</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="accordion" id="faqAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faq1">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
                            Bagaimana cara membeli produk digital?
                        </button>
                    </h2>
                    <div id="collapse1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Pilih produk yang ingin Anda beli, tambahkan ke keranjang, lalu lanjutkan ke checkout. 
                            Pilih metode pembayaran dan selesaikan pembayaran. Setelah pembayaran berhasil, 
                            Anda dapat langsung mengunduh file produk.
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faq2">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">
                            Berapa lama waktu konfirmasi pembayaran?
                        </button>
                    </h2>
                    <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Untuk pembayaran bank transfer, konfirmasi akan diproses dalam waktu maksimal 24 jam 
                            setelah bukti transfer diupload. Untuk pembayaran kartu kredit dan PayPal, 
                            konfirmasi bersifat instan.
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faq3">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
                            Apakah file yang dibeli bisa didownload ulang?
                        </button>
                    </h2>
                    <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Ya, file yang telah Anda beli dapat didownload ulang kapan saja melalui 
                            halaman "Produk Saya" di dashboard akun Anda.
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faq4">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4">
                            Bagaimana jika ada masalah dengan file yang dibeli?
                        </button>
                    </h2>
                    <div id="collapse4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Jika ada masalah dengan file yang dibeli, silakan hubungi tim support kami 
                            melalui email, WhatsApp, atau telepon. Kami akan membantu menyelesaikan masalah Anda.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 