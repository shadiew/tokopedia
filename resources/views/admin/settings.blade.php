@extends('layouts.admin')

@section('title', 'Pengaturan - Admin Dashboard')
@section('page-title', 'Pengaturan')

@section('breadcrumb')
<li class="breadcrumb-item active">Pengaturan</li>
@endsection

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0">Pengaturan Aplikasi</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.settings.update') }}">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="short_title" class="form-label">Short Title</label>
                    <input type="text" class="form-control" id="short_title" name="short_title" value="{{ old('short_title', $settings->short_title ?? '') }}">
                </div>
                <div class="col-md-6">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $settings->title ?? '') }}">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="favicon" class="form-label">Favicon URL</label>
                    <input type="text" class="form-control" id="favicon" name="favicon" value="{{ old('favicon', $settings->favicon ?? '') }}">
                </div>
                <div class="col-md-6">
                    <label for="logo" class="form-label">Logo URL</label>
                    <input type="text" class="form-control" id="logo" name="logo" value="{{ old('logo', $settings->logo ?? '') }}">
                </div>
            </div>
            <div class="mb-3">
                <label for="google_analytics" class="form-label">Google Analytics</label>
                <textarea class="form-control" id="google_analytics" name="google_analytics" rows="2">{{ old('google_analytics', $settings->google_analytics ?? '') }}</textarea>
            </div>
            <div class="mb-3">
                <label for="google_search" class="form-label">Google Search Console</label>
                <textarea class="form-control" id="google_search" name="google_search" rows="2">{{ old('google_search', $settings->google_search ?? '') }}</textarea>
            </div>
            <div class="mb-3">
                <label for="embed_code" class="form-label">Embed Code</label>
                <textarea class="form-control" id="embed_code" name="embed_code" rows="2">{{ old('embed_code', $settings->embed_code ?? '') }}</textarea>
            </div>
            <hr>
            <h6>Tripay Settings</h6>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="tripay_merchant" class="form-label">Tripay Merchant</label>
                    <input type="text" class="form-control" id="tripay_merchant" name="tripay_merchant" value="{{ old('tripay_merchant', $settings->tripay_merchant ?? '') }}">
                </div>
                <div class="col-md-4">
                    <label for="tripay_apikey" class="form-label">Tripay API Key</label>
                    <input type="text" class="form-control" id="tripay_apikey" name="tripay_apikey" value="{{ old('tripay_apikey', $settings->tripay_apikey ?? '') }}">
                </div>
                <div class="col-md-4">
                    <label for="tripay_privatekey" class="form-label">Tripay Private Key</label>
                    <input type="text" class="form-control" id="tripay_privatekey" name="tripay_privatekey" value="{{ old('tripay_privatekey', $settings->tripay_privatekey ?? '') }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Tripay Mode</label>
                <select class="form-select" name="tripay_action">
                    <option value="0" {{ old('tripay_action', $settings->tripay_action ?? 0) == 0 ? 'selected' : '' }}>Sandbox</option>
                    <option value="1" {{ old('tripay_action', $settings->tripay_action ?? 0) == 1 ? 'selected' : '' }}>Production</option>
                </select>
            </div>
            <hr>
            <h6>WhatsApp Gateway</h6>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="whatsapp_appkey" class="form-label">App Key</label>
                    <input type="text" class="form-control" id="whatsapp_appkey" name="whatsapp_appkey" value="{{ old('whatsapp_appkey', $settings->whatsapp_appkey ?? '') }}">
                </div>
                <div class="col-md-6">
                    <label for="whatsapp_authkey" class="form-label">Auth Key</label>
                    <input type="text" class="form-control" id="whatsapp_authkey" name="whatsapp_authkey" value="{{ old('whatsapp_authkey', $settings->whatsapp_authkey ?? '') }}">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
        </form>
    </div>
</div>
@endsection 