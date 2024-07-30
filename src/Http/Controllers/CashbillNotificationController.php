<?php

namespace MsCode\Cashbill\Http\Controllers;

use MsCode\Cashbill\Events\TransactionStatusChanged;
use MsCode\Cashbill\Order;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use MsCode\Cashbill\Http\Requests\NotificationRequest;
use MsCode\Cashbill\Events\TransactionSuccessfullyCompleted;

class CashbillNotificationController extends Controller
{
    public function handle(NotificationRequest $request): Response
    {
        if (!$request->checkSign())
            abort(403);

        $orderId = $request->getOrderId();
        $order = new Order($orderId);
        $paymentDetails = $order->update();
        if ($order->statusChanged()) {
            if ($order->isPositiveFinish()) {
                event(new TransactionSuccessfullyCompleted($paymentDetails));
            } else {
                event(new TransactionStatusChanged($paymentDetails->getStatus()));
            }
        }
        return response('OK', 200);
    }
}
