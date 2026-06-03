<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Models\Payment;
use App\Models\Vendor;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', Payment::class);
        $filters = $request->only(['search', 'status', 'payment_method', 'date_from', 'date_to', 'vendor_id']);
        $payments = $this->paymentService->getAll($filters);
        $vendors = Vendor::select('id', 'full_name')->where('status', 'active')->get();

        return view('payments.index', compact('payments', 'vendors', 'filters'));
    }

    public function create()
    {
        $this->authorize('create', Payment::class);
        $vendors = Vendor::where('status', 'active')->get();
        return view('payments.create', compact('vendors'));
    }

    public function store(StorePaymentRequest $request)
    {
        $this->authorize('create', Payment::class);
        $this->paymentService->create($request->validated());

        return redirect()->route('payments.index')
            ->with('success', 'Payment recorded successfully.');
    }

    public function show(Payment $payment)
    {
        $this->authorize('view', $payment);
        $payment->load('vendor');
        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $this->authorize('update', $payment);
        $payment->load('vendor');
        $vendors = Vendor::where('status', 'active')->get();
        return view('payments.edit', compact('payment', 'vendors'));
    }

    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        $this->authorize('update', $payment);
        $this->paymentService->update($payment, $request->validated());

        return redirect()->route('payments.index')
            ->with('success', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment)
    {
        $this->authorize('delete', $payment);
        $this->paymentService->delete($payment);

        return redirect()->route('payments.index')
            ->with('success', 'Payment deleted successfully.');
    }

    public function receipt(Payment $payment)
    {
        $this->authorize('view', $payment);
        $payment->load('vendor');
        return view('payments.receipt', compact('payment'));
    }

    public function printReceipt(Payment $payment)
    {
        $this->authorize('view', $payment);
        $payment->load('vendor');
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('payments.pdf-receipt', compact('payment'));
        return $pdf->download('receipt-' . $payment->reference_number . '.pdf');
    }
}
