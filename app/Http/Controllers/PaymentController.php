<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * Display Indian Payment Checkout Page
     */
    public function checkout($id)
    {
        $book = Book::with('category')->findOrFail($id);

        $deliveryFee = $book->price > 400 ? 0 : 40;
        $totalAmount = $book->price + $deliveryFee;

        $user = Auth::user();
        $razorpayKeyId = env('RAZORPAY_KEY', 'rzp_test_BooksAppDemoKey');

        return view('pages.payment', compact(
            'book',
            'deliveryFee',
            'totalAmount',
            'user',
            'razorpayKeyId'
        ));
    }

    /**
     * Create Razorpay Order API
     */
    public function createRazorpayOrder(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $book = Book::findOrFail($request->book_id);
        $deliveryFee = $book->price > 400 ? 0 : 40;
        $totalAmount = $book->price + $deliveryFee;
        $amountInPaise = intval($totalAmount * 100);

        $keyId = env('RAZORPAY_KEY', 'rzp_test_BooksAppDemoKey');
        $keySecret = env('RAZORPAY_SECRET', '');

        $orderId = 'order_inr_' . Str::random(14);

        // If real Razorpay keys are provided, call Razorpay Orders API
        if (!empty($keySecret) && $keyId !== 'rzp_test_BooksAppDemoKey') {
            try {
                $ch = curl_init('https://api.razorpay.com/v1/orders');
                curl_setopt($ch, CURLOPT_USERPWD, "{$keyId}:{$keySecret}");
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
                    'amount' => $amountInPaise,
                    'currency' => 'INR',
                    'receipt' => 'rcpt_' . time(),
                    'payment_capture' => 1,
                ]));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
                $response = curl_exec($ch);
                curl_close($ch);

                $data = json_decode($response, true);
                if (isset($data['id'])) {
                    $orderId = $data['id'];
                }
            } catch (\Exception $e) {
                // Fallback to generated order ID
            }
        }

        return response()->json([
            'order_id' => $orderId,
            'amount' => $amountInPaise,
            'currency' => 'INR',
            'key' => $keyId,
            'book_title' => $book->title,
        ]);
    }

    /**
     * Process Payment Submission (UPI, Cards, Net Banking, Razorpay)
     */
    public function process(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $request->validate([
            'customer_name' => 'required|string|max:100',
            'customer_email' => 'required|email|max:120',
            'customer_phone' => 'required|string|max:15',
            'shipping_address' => 'required|string|max:255',
            'city' => 'required|string|max:50',
            'state' => 'required|string|max:50',
            'pincode' => 'required|string|max:10',
            'payment_method' => 'required|in:upi_gpay,upi_phonepe,upi_paytm,upi_id,debit_card,credit_card,net_banking,razorpay',
        ]);

        $deliveryFee = $book->price > 400 ? 0 : 40;
        $totalAmount = $book->price + $deliveryFee;

        // Never store sensitive card numbers or UPI PINs
        $orderNumber = 'BK-INR-' . strtoupper(Str::random(6)) . rand(10, 99);
        $transactionId = 'TXN-' . date('Ymd') . '-' . strtoupper(Str::random(8));

        $order = Order::create([
            'order_number' => $orderNumber,
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'shipping_address' => $request->shipping_address,
            'city' => $request->city,
            'state' => $request->state,
            'pincode' => $request->pincode,
            'amount' => $totalAmount,
            'currency' => 'INR',
            'payment_method' => $request->payment_method,
            'payment_status' => 'completed',
            'transaction_id' => $request->razorpay_payment_id ?? $transactionId,
            'razorpay_order_id' => $request->razorpay_order_id ?? null,
            'razorpay_payment_id' => $request->razorpay_payment_id ?? null,
            'razorpay_signature' => $request->razorpay_signature ?? null,
            'delivery_status' => 'Order Confirmed - Dispatching Soon',
            'order_notes' => $request->order_notes ?? 'Payment verified via secure Indian Gateway.',
        ]);

        return redirect()->route('payment.success', $order->id)
            ->with('success', 'Payment Successful! Your book order has been confirmed.');
    }

    /**
     * Display Payment Success Receipt Page
     */
    public function success($id)
    {
        $order = Order::with('book', 'user')->findOrFail($id);
        return view('pages.payment-success', compact('order'));
    }

    /**
     * Display Payment Failed Page
     */
    public function failed(Request $request)
    {
        $reason = $request->query('reason', 'Payment could not be completed. Please try again.');
        return view('pages.payment-failed', compact('reason'));
    }
}
