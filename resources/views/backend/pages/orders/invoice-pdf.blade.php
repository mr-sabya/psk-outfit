<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        /* 1. Register the SolaimanLipi Font */
        @font-face {
            font-family: 'SolaimanLipi';
            src: url('{{ storage_path("fonts/SolaimanLipi.ttf") }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        /* 2. Global Styling */
        @page {
            size: A5;
            margin: 0;
        }

        * {
            font-family: 'SolaimanLipi', sans-serif !important;
        }

        body {
            margin: 0;
            padding: 0;
            font-size: 11px;
            line-height: 1.5;
            color: #333;
        }

        /* 3. Padding and Spacing */
        .invoice-box {
            padding: 35px 25px;
        }

        .header-table {
            width: 100%;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .info-table {
            width: 100%;
            margin-bottom: 15px;
        }

        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .main-table th {
            background-color: #f1f1f1;
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .main-table td {
            border: 1px solid #ddd;
            padding: 10px 8px;
            /* High padding for clean look */
            vertical-align: top;
        }

        .totals-table {
            width: 50%;
            margin-left: auto;
            margin-top: 15px;
        }

        .totals-table td {
            padding: 4px 8px;
        }

        /* 4. Formatting Helpers */
        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .fw-bold {
            font-weight: bold;
        }

        .taka-sign {
            font-size: 12px;
        }

        /* Slightly larger for clarity */

        .payment-info {
            margin-top: 20px;
            background: #f9f9f9;
            padding: 10px;
            border-radius: 4px;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #888;
        }

        .signature-section {
            margin-top: 50px;
            width: 100%;
        }

        .signature-line {
            border-top: 1px solid #444;
            width: 130px;
            padding-top: 5px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <!-- Brand Header -->
        <table class="header-table">
            <tr>
                <td>
                    <h2 style="color: #007bff; margin: 0; font-size: 20px;">INVOICE</h2>
                    <p style="margin: 4px 0 0 0;">Order: <strong>{{ $order->order_number }}</strong></p>
                    <p style="margin: 0;">Date: {{ $order->placed_at->format('d M, Y') }}</p>
                </td>
                <td class="text-right">
                    <h3 style="margin: 0;">{{ $settings['website_name'] ?? config('app.name') }}</h3>
                    <p style="margin: 2px 0;">{{ $settings['address'] ?? '' }}</p>
                    <p style="margin: 0;">Phone: {{ $settings['phone'] ?? '' }}</p>
                </td>
            </tr>
        </table>

        <!-- Info Section -->
        <table class="info-table">
            <tr>
                <td width="50%" valign="top">
                    <p class="fw-bold" style="border-bottom: 1px solid #ccc; display: inline-block;">BILL TO:</p><br>
                    <strong>{{ $order->shipping_first_name }} {{ $order->shipping_last_name }}</strong><br>
                    {{ $order->shipping_address_line_1 }}<br>
                    {{ $order->shippingCity?->name }}, {{ $order->shippingState?->name }}<br>
                    Phone: {{ $order->shipping_phone }}
                </td>
                <td width="50%" class="text-right" valign="top">
                    <p class="fw-bold" style="border-bottom: 1px solid #ccc; display: inline-block;">SOLD BY:</p><br>
                    <strong>{{ $settings['website_name'] ?? config('app.name') }}</strong><br>
                    Phone: {{ $settings['phone'] ?? '' }}<br>Email: {{ $settings['email'] ?? ''}}
                </td>
            </tr>
        </table>

        <!-- Items Table -->
        <table class="main-table">
            <thead>
                <tr>
                    <th class="text-center" width="5%">#</th>
                    <th>Description</th>
                    <th class="text-center" width="20%">Price</th>
                    <th class="text-center" width="10%">Qty</th>
                    <th class="text-right" width="22%">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        <div class="fw-bold">{{ $item->item_name }}</div>
                        @if($item->item_attributes)
                        <div style="margin-top: 3px;">
                            @foreach($item->item_attributes as $key => $val)
                            <span style="font-size: 8px; background: #eee; padding: 1px 3px;">{{ $key }}: {{ $val }}</span>
                            @endforeach
                        </div>
                        @endif
                    </td>
                    <td class="text-center"><span class="taka-sign">৳</span> {{ number_format($item->unit_price, 2) }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right"><span class="taka-sign">৳</span> {{ number_format($item->subtotal, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Summary Section -->
        <table class="totals-table">
            <tr>
                <td>Subtotal:</td>
                <td class="text-right"><span class="taka-sign">৳</span> {{ number_format($order->subtotal, 2) }}</td>
            </tr>
            <tr>
                <td>Shipping:</td>
                <td class="text-right"><span class="taka-sign">৳</span> {{ number_format($order->shipping_cost, 2) }}</td>
            </tr>
            <tr>
                <td class="fw-bold" style="font-size: 12px; border-top: 1.5px solid #333; padding-top: 6px;">Grand Total:</td>
                <td class="text-right fw-bold" style="font-size: 12px; border-top: 1.5px solid #333; padding-top: 6px;">
                    <span class="taka-sign">৳</span> {{ number_format($order->total_amount, 2) }}
                </td>
            </tr>
        </table>

        <!-- Payment Info -->
        <div class="payment-info">
            <strong>Payment Method:</strong> {{ $order->payment_method_name }} |
            <strong>Status:</strong> {{ strtoupper($order->payment_status->value ?? 'PENDING') }}
            @if($order->transaction_id)
            <br><strong>Trx ID:</strong> {{ $order->transaction_id }}
            @endif
        </div>

        <!-- Signature Section -->
        <table class="signature-section">
            <tr>
                <td>
                    <div class="signature-line">Customer Signature</div>
                </td>
                <td align="right">
                    <div class="signature-line">Authorized Seal</div>
                </td>
            </tr>
        </table>

        <div class="footer">
            Thank you for your purchase!<br>
            Computer generated invoice - no signature required.
        </div>
    </div>
</body>

</html>