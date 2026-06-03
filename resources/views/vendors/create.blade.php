@extends('layouts.admin')

@section('title', 'Add Vendor')

@section('content')
<div class="fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-kadaju-gold"><i class="bi bi-plus-circle me-2"></i>Add New Vendor</h2>
        <a href="{{ route('vendors.index') }}" class="btn btn-kadaju-outline-gold">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('vendors.store') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror" value="{{ old('full_name') }}" required>
                        @error('full_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Phone <span class="text-danger">*</span></label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required>
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">National ID <span class="text-danger">*</span></label>
                        <input type="text" name="national_id" class="form-control @error('national_id') is-invalid @enderror" value="{{ old('national_id') }}" required>
                        @error('national_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Business Type <span class="text-danger">*</span></label>
                        <select name="business_type" class="form-select @error('business_type') is-invalid @enderror" required>
                            <option value="">Select Type</option>
                            <option value="retail" {{ old('business_type') === 'retail' ? 'selected' : '' }}>Retail</option>
                            <option value="wholesale" {{ old('business_type') === 'wholesale' ? 'selected' : '' }}>Wholesale</option>
                            <option value="food" {{ old('business_type') === 'food' ? 'selected' : '' }}>Food</option>
                            <option value="textile" {{ old('business_type') === 'textile' ? 'selected' : '' }}>Textile</option>
                            <option value="electronics" {{ old('business_type') === 'electronics' ? 'selected' : '' }}>Electronics</option>
                            <option value="crafts" {{ old('business_type') === 'crafts' ? 'selected' : '' }}>Crafts</option>
                            <option value="services" {{ old('business_type') === 'services' ? 'selected' : '' }}>Services</option>
                        </select>
                        @error('business_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Registration Date <span class="text-danger">*</span></label>
                        <input type="date" name="registration_date" class="form-control @error('registration_date') is-invalid @enderror" value="{{ old('registration_date', date('Y-m-d')) }}" required>
                        @error('registration_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="2">{{ old('address') }}</textarea>
                        @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="suspended" {{ old('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-kadaju-gold">
                        <i class="bi bi-save me-1"></i> Create Vendor
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
