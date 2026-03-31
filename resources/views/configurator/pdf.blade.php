<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Quote {{ $quote->quote_number }} - MK Gilze Africa</title>
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif; 
            font-size: 12px;
            line-height: 1.4;
        }
        .header { 
            border-bottom: 2px solid #2c5aa0; 
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .company-info { 
            float: left; 
            width: 60%; 
        }
        .quote-info { 
            float: right; 
            text-align: right;
            width: 35%; 
        }
        .clear { 
            clear: both; 
        }
        .section { 
            margin-bottom: 20px; 
        }
        .section-title { 
            background-color: #f8f9fa; 
            padding: 8px 12px;
            border-left: 4px solid #2c5aa0;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .customer-info, .machine-info {
            width: 100%;
            border-collapse: collapse;
        }
        .customer-info td, .machine-info td {
            padding: 4px 8px;
            vertical-align: top;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        .items-table th {
            background-color: #2c5aa0;
            color: white;
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        .items-table td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        .total-row {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            font-size: 10px;
            color: #666;
        }
        .page-break {
            page-break-before: always;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .mb-3 {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="company-info">
            <h1 style="color: #2c5aa0; margin: 0;">MK Gilze Africa</h1>
            <p style="margin: 2px 0; color: #666;">
                Packaging Machines & Solutions<br>
                Tunisia Branch<br>
                Email: info@mkgilze-africa.tn<br>
                Phone: +216 XX XXX XXX
            </p>
        </div>
        <div class="quote-info">
            <h2 style="color: #2c5aa0; margin: 0;">QUOTE</h2>
            <p style="margin: 2px 0;"><strong>Quote Number:</strong> {{ $quote->quote_number }}</p>
            <p style="margin: 2px 0;"><strong>Date:</strong> {{ $quote->created_at->format('M d, Y') }}</p>
            <p style="margin: 2px 0;"><strong>Valid Until:</strong> {{ $quote->created_at->addDays(30)->format('M d, Y') }}</p>
            <p style="margin: 2px 0;"><strong>Status:</strong> {{ strtoupper($quote->status) }}</p>
        </div>
        <div class="clear"></div>
    </div>

    <!-- Customer Information -->
    <div class="section">
        <div class="section-title">CUSTOMER INFORMATION</div>
        <table class="customer-info">
            <tr>
                <td style="width: 50%;">
                    <strong>Customer Name:</strong> {{ $quote->customer_name }}<br>
                    <strong>Email:</strong> {{ $quote->customer_email }}<br>
                    @if($quote->customer_company)
                    <strong>Company:</strong> {{ $quote->customer_company }}<br>
                    @endif
                    @if($quote->customer_phone)
                    <strong>Phone:</strong> {{ $quote->customer_phone }}
                    @endif
                </td>
                <td style="width: 50%;">
                    <strong>Prepared For:</strong> {{ $quote->customer_name }}<br>
                    <strong>Quote Date:</strong> {{ $quote->created_at->format('M d, Y') }}<br>
                    <strong>Quote Reference:</strong> {{ $quote->quote_number }}
                </td>
            </tr>
        </table>
    </div>

    <!-- Machine Configuration -->
    <div class="section">
        <div class="section-title">MACHINE CONFIGURATION</div>
        
        <!-- Base Machine -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 60%;">Item Description</th>
                    <th style="width: 20%;">Specifications</th>
                    <th style="width: 20%; text-align: right;">Price (€)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>{{ $quote->machine->display_name }}</strong><br>
                        <em>{{ $quote->machine->description }}</em><br>
                        <small>Model: {{ $quote->machine->name }}</small>
                    </td>
                    <td>
                        @foreach(array_slice($quote->machine->specifications, 0, 3) as $key => $value)
                        {{ $key }}: {{ $value }}<br>
                        @endforeach
                    </td>
                    <td style="text-align: right;">{{ number_format($quote->machine->base_price, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Selected Components -->
        <div class="mb-3"></div>
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 10%;">Category</th>
                    <th style="width: 50%;">Component Description</th>
                    <th style="width: 20%;">Details</th>
                    <th style="width: 20%; text-align: right;">Price (€)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quote->components->groupBy('category.name') as $categoryName => $components)
                @foreach($components as $index => $component)
                <tr>
                    @if($index === 0)
                    <td rowspan="{{ $components->count() }}" style="vertical-align: top;">
                        {{ $categoryName }}
                    </td>
                    @endif
                    <td>
                        <strong>{{ $component->name }}</strong><br>
                        <em>{{ $component->description }}</em><br>
                        <small>Code: {{ $component->code }}</small>
                    </td>
                    <td>
                        Installation: {{ $component->pivot->installation_time }}h
                    </td>
                    <td style="text-align: right;">{{ number_format($component->pivot->unit_price, 2) }}</td>
                </tr>
                @endforeach
                @endforeach
            </tbody>
        </table>
    </div>

   <!-- Pricing Summary -->
<div class="section">
    <div class="section-title">PRICING SUMMARY</div>
    <table style="width: 100%;">
        <tr>
            <td style="width: 70%;"></td>
            <td style="width: 30%;">
                <table style="width: 100%;">
                    <tr>
                        <td>Base Machine:</td>
                        <td style="text-align: right;">€{{ number_format($quote->machine->base_price, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Components:</td>
                        <td style="text-align: right;">€{{ number_format($quote->components->sum('pivot.unit_price'), 2) }}</td>
                    </tr>
                    <tr style="border-top: 2px solid #333;">
                        <td><strong>Total:</strong></td>
                        <td style="text-align: right;"><strong>€{{ number_format($quote->total_price, 2) }}</strong></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>

    <!-- Additional Information -->
    <div class="section">
        <div class="section-title">ADDITIONAL INFORMATION</div>
        <table style="width: 100%;">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <strong>Installation Details:</strong><br>
                    Total Installation Time: {{ $quote->total_installation_time }} hours<br>
                    Components Selected: {{ $quote->components->count() }}<br>
                    <br>
                    <strong>Quote Validity:</strong><br>
                    This quote is valid for 30 days from the date of issue.
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <strong>Terms & Conditions:</strong><br>
                    • Prices exclude installation labor<br>
                    • Transportation costs not included<br>
                    • Site preparation excluded<br>
                    • Subject to technical feasibility<br>
                    • Payment terms: 50% advance, 50% before delivery
                </td>
            </tr>
        </table>

        @if($quote->notes)
        <div style="margin-top: 15px; padding: 10px; background-color: #f8f9fa; border-left: 4px solid #2c5aa0;">
            <strong>Customer Notes:</strong><br>
            {{ $quote->notes }}
        </div>
        @endif
    </div>

    <!-- Footer -->
    <div class="footer">
        <table style="width: 100%;">
            <tr>
                <td style="width: 50%;">
                    <strong>MK Gilze Africa - Tunisia Branch</strong><br>
                    Specialists in Packaging Machinery<br>
                    Maintenance, Service, and Production
                </td>
                <td style="width: 50%; text-align: right;">
                    <strong>Contact Information</strong><br>
                    Email: info@mkgilze-africa.tn<br>
                    Phone: +216 XX XXX XXX<br>
                    www.mkgilze-africa.tn
                </td>
            </tr>
        </table>
        <div style="text-align: center; margin-top: 10px;">
            This document was generated automatically on {{ date('M d, Y \a\t H:i') }}
        </div>
    </div>
</body>
</html>