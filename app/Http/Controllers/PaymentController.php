<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CartItem;
use KHQR\BakongKHQR;
use KHQR\Helpers\KHQRData;
use KHQR\Models\IndividualInfo;

class PaymentController extends Controller
{
    public function checkout()
    {
        $cart = CartItem::where('user_id', auth()->id())->get();

        if ($cart->isEmpty()) {
            return redirect()->route('seller.cart.view')
                             ->with('error', 'Your cart is empty.');
        }

        // Calculate total
        $totalAmount = 0;
        foreach ($cart as $item) {
            $totalAmount += $item->price * $item->quantity;
        }

        $expireTimestamp = now()->addMinutes(15)->timestamp * 1000;
        $currency = KHQRData::CURRENCY_KHR;

        $merchant = new IndividualInfo(
            bakongAccountID: 'lyhor_phon@bkrt',
            merchantName: 'LIHOR Phon',
            merchantCity: 'Phnom Penh',
            currency: $currency,
            amount: (float) $totalAmount,
            expirationTimestamp: $expireTimestamp,
            acquiringBank: 'ACLEDA',
            storeLabel: 'Lyhor Store',
            terminalLabel: 'Web Checkout'
        );

        $qrResponse = BakongKHQR::generateIndividual($merchant);

        // ✅ Send Telegram BEFORE return
        $this->sendTelegramMessage(
            "🛒 <b>New Checkout Created</b>\n" .
            "User ID: " . auth()->id() . "\n" .
            "Total: $" . $totalAmount . "\n" .
            "Time: " . now()
        );

        return view('seller.Payments.checkout', [
            'cart' => $cart,
            'totalAmount' => $totalAmount,
            'qr' => $qrResponse->data['qr'] ?? null,
            'md5' => $qrResponse->data['md5'] ?? null,
        ]);
    }

    public function verifyTransaction(Request $request)
    {
        $request->validate([
            'md5' => 'required|string',
        ]);

        try {
            $token = env('BAKONG_TOKEN');
            $bakong = new BakongKHQR($token);

            $result = $bakong->checkTransactionByMD5($request->md5);

            // ✅ Send Telegram BEFORE returning response
            if (isset($result['responseCode']) && $result['responseCode'] == 0) {
                $this->sendTelegramMessage(
                    "✅ <b>Payment Successful</b>\n" .
                    "MD5: " . $request->md5 . "\n" .
                    "Time: " . now()
                );
            }

            return response()->json($result);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function sendTelegramMessage($message)
    {
        $token = env('TELEGRAM_BOT_TOKEN');
        $chatId = env('TELEGRAM_CHAT_ID');

        $url = "https://api.telegram.org/bot{$token}/sendMessage";

        $data = [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'HTML'
        ];

        try {
            file_get_contents($url . '?' . http_build_query($data));
        } catch (\Exception $e) {
            \Log::error('Telegram Error: ' . $e->getMessage());
        }
    }
}