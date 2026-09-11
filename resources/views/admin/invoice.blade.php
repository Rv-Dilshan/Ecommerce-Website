<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</title>
    <style>
        body { font-family: sans-serif; color: #333; line-height: 1.6; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; box-shadow: 0 0 10px rgba(0, 0, 0, 0.15); font-size: 16px; }
        .header { display: flex; justify-content: space-between; border-bottom: 2px solid #333; padding-bottom: 20px; margin-bottom: 20px; }
        .header-left h1 { margin: 0; color: #db6574; font-size: 32px; }
        .header-right { text-align: right; }
        .details-section { width: 100%; margin-bottom: 30px; border-collapse: collapse; }
        .details-section td { vertical-align: top; width: 50%; }
        .details-heading { font-weight: bold; margin-bottom: 5px; color: #555; }
        .table-items { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .table-items th { background: #f4f4f4; border-bottom: 2px solid #ddd; padding: 10px; text-align: left; }
        .table-items td { border-bottom: 1px solid #eee; padding: 10px; }
        .table-items th.right, .table-items td.right { text-align: right; }
        .table-items th.center, .table-items td.center { text-align: center; }
        .total-row td { font-weight: bold; font-size: 18px; border-top: 2px solid #333; border-bottom: none; }
        .footer { text-align: center; font-size: 14px; color: #777; margin-top: 40px; border-top: 1px solid #eee; padding-top: 20px; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="2">
                    <table width="100%" style="border-bottom: 2px solid #333; padding-bottom: 20px; margin-bottom: 20px;">
                        <tr>
                            <td class="header-left">
                                <h1 style="margin: 0; color: #db6574; font-size: 32px;">Lara E-Commerce</h1>
                                <p style="margin: 5px 0 0 0; color: #555;">Gift Shop Invoice</p>
                            </td>
                            <td class="header-right" style="text-align: right;">
                                <h2 style="margin: 0;">INVOICE</h2>
                                <p style="margin: 5px 0 0 0;">Date: {{ $order->created_at->format('M d, Y') }}<br>
                                Invoice #: ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr>
                <td colspan="2">
                    <table class="details-section">
                        <tr>
                            <td>
                                <div class="details-heading">Billed To:</div>
                                <strong>{{ $order->name }}</strong><br>
                                {{ $order->address }}<br>
                                Phone: {{ $order->phone }}<br>
                                Email: {{ $order->user->email ?? 'N/A' }}
                            </td>
                            <td style="text-align: right;">
                                <div class="details-heading">Payment & Delivery:</div>
                                Payment Status: <strong>{{ $order->payment_status }}</strong><br>
                                Delivery Status: <strong>{{ $order->delivery_status }}</strong>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr>
                <td colspan="2">
                    <table class="table-items">
                        <thead>
                            <tr>
                                <th>Item Description</th>
                                <th class="center">Quantity</th>
                                <th class="right">Price</th>
                                <th class="right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                            <tr>
                                <td>{{ $item->product->product_title ?? 'Product Removed' }}</td>
                                <td class="center">{{ $item->quantity }}</td>
                                <td class="right">${{ number_format($item->price, 2) }}</td>
                                <td class="right">${{ number_format($item->price * $item->quantity, 2) }}</td>
                            </tr>
                            @endforeach
                            
                            <tr class="total-row">
                                <td colspan="3" class="right">Subtotal:</td>
                                <td class="right">${{ number_format($order->total_price, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="right">Shipping:</td>
                                <td class="right">Free</td>
                            </tr>
                            <tr class="total-row">
                                <td colspan="3" class="right" style="color: #db6574;">Grand Total:</td>
                                <td class="right" style="color: #db6574;">${{ number_format($order->total_price, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
        
        <div class="footer">
            Thank you for your business!<br>
            If you have any questions about this invoice, please contact us.
        </div>
    </div>
</body>
</html>
