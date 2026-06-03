<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVendorRequest;
use App\Http\Requests\UpdateVendorRequest;
use App\Models\Vendor;
use App\Services\VendorService;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    protected VendorService $vendorService;

    public function __construct(VendorService $vendorService)
    {
        $this->vendorService = $vendorService;
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', Vendor::class);
        $filters = $request->only(['search', 'status', 'business_type']);
        $vendors = $this->vendorService->getAll($filters);
        $businessTypes = $this->vendorService->getBusinessTypes();

        return view('vendors.index', compact('vendors', 'businessTypes', 'filters'));
    }

    public function create()
    {
        $this->authorize('create', Vendor::class);
        return view('vendors.create');
    }

    public function store(StoreVendorRequest $request)
    {
        $this->authorize('create', Vendor::class);
        $this->vendorService->create($request->validated());

        return redirect()->route('vendors.index')
            ->with('success', 'Vendor created successfully.');
    }

    public function show(Vendor $vendor)
    {
        $this->authorize('view', $vendor);
        $vendor->load(['payments' => fn($q) => $q->latest()->take(10)]);
        return view('vendors.show', compact('vendor'));
    }

    public function edit(Vendor $vendor)
    {
        $this->authorize('update', $vendor);
        return view('vendors.edit', compact('vendor'));
    }

    public function update(UpdateVendorRequest $request, Vendor $vendor)
    {
        $this->authorize('update', $vendor);
        $this->vendorService->update($vendor, $request->validated());

        return redirect()->route('vendors.index')
            ->with('success', 'Vendor updated successfully.');
    }

    public function destroy(Vendor $vendor)
    {
        $this->authorize('delete', $vendor);
        $this->vendorService->delete($vendor);

        return redirect()->route('vendors.index')
            ->with('success', 'Vendor deleted successfully.');
    }
}
