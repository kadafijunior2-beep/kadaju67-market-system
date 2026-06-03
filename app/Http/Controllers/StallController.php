<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStallRequest;
use App\Http\Requests\UpdateStallRequest;
use App\Models\Stall;
use App\Models\Vendor;
use App\Services\StallService;
use Illuminate\Http\Request;

class StallController extends Controller
{
    protected StallService $stallService;

    public function __construct(StallService $stallService)
    {
        $this->stallService = $stallService;
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', Stall::class);
        $filters = $request->only(['search', 'status', 'location']);
        $stalls = $this->stallService->getAll($filters);
        $locations = $this->stallService->getLocations();

        return view('stalls.index', compact('stalls', 'locations', 'filters'));
    }

    public function create()
    {
        $this->authorize('create', Stall::class);
        return view('stalls.create');
    }

    public function store(StoreStallRequest $request)
    {
        $this->authorize('create', Stall::class);
        $this->stallService->create($request->validated());

        return redirect()->route('stalls.index')
            ->with('success', 'Stall created successfully.');
    }

    public function show(Stall $stall)
    {
        $this->authorize('view', $stall);
        $stall->load('currentVendor');
        $vendors = Vendor::where('status', 'active')->get();
        return view('stalls.show', compact('stall', 'vendors'));
    }

    public function edit(Stall $stall)
    {
        $this->authorize('update', $stall);
        return view('stalls.edit', compact('stall'));
    }

    public function update(UpdateStallRequest $request, Stall $stall)
    {
        $this->authorize('update', $stall);
        $this->stallService->update($stall, $request->validated());

        return redirect()->route('stalls.index')
            ->with('success', 'Stall updated successfully.');
    }

    public function destroy(Stall $stall)
    {
        $this->authorize('delete', $stall);
        $this->stallService->delete($stall);

        return redirect()->route('stalls.index')
            ->with('success', 'Stall deleted successfully.');
    }

    public function assignVendor(Request $request, Stall $stall)
    {
        $this->authorize('update', $stall);
        $validated = $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
        ]);

        $this->stallService->assignVendor($stall, $validated['vendor_id'], $request->all());

        return redirect()->route('stalls.show', $stall)
            ->with('success', 'Vendor assigned to stall successfully.');
    }
}
