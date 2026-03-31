@extends('layouts.admin')

@section('title', 'Manage Quotes - MK Gilze Africa')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manage Quotes</h1>
</div>

<div class="card shadow">
    <div class="card-body">
        @if($quotes->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Quote #</th>
                        <th>Customer</th>
                        <th>Machine</th>
                        <th>Total Price</th>
                        <th>Installation Time</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quotes as $quote)
                    <tr>
                        <td><strong>{{ $quote->quote_number }}</strong></td>
                        <td>
                            {{ $quote->customer_name }}
                            <br><small class="text-muted">{{ $quote->customer_email }}</small>
                        </td>
                        <td>{{ $quote->machine->display_name }}</td>
                        <td>€{{ number_format($quote->total_price, 2) }}</td>
                        <td>{{ $quote->total_installation_time }} hours</td>
                        <td>
                            <span class="badge bg-{{ $quote->status === 'accepted' ? 'success' : ($quote->status === 'rejected' ? 'danger' : 'secondary') }}">
                                {{ strtoupper($quote->status) }}
                            </span>
                        </td>
                        <td>{{ $quote->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.quotes.show', $quote) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.quotes.export-pdf', $quote) }}" class="btn btn-outline-success" target="_blank">
                                    <i class="fas fa-download"></i>
                                </a>
                                <form action="{{ route('admin.quotes.destroy', $quote) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-4">
            <i class="fas fa-file-invoice fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">No quotes found</h5>
            <p class="text-muted">Quotes will appear here when customers generate them through the configurator.</p>
            <a href="{{ route('configurator.index') }}" class="btn btn-primary" target="_blank">
                <i class="fas fa-external-link-alt me-2"></i>Test Configurator
            </a>
        </div>
        @endif
    </div>
</div>
@endsection