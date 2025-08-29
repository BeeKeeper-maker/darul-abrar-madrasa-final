<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Children\'s Fees') }}
            </h2>
            <a href="{{ route('guardian.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                {{ __('Back to Dashboard') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach ($students as $student)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">{{ $student->user->name }} - {{ $student->class->name }}</h3>
                        
                        <!-- Fee Summary -->
                        <div class="mb-6">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                @php
                                    $totalFees = $student->fees->sum('amount');
                                    $paidFees = $student->fees->sum('paid_amount');
                                    $dueFees = $totalFees - $paidFees;
                                    $paymentPercentage = $totalFees > 0 ? round(($paidFees / $totalFees) * 100) : 0;
                                @endphp
                                
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-700">Payment Status</h4>
                                        <div class="mt-2 flex items-center">
                                            <div class="w-full bg-gray-200 rounded-full h-2.5 mr-2">
                                                <div class="bg-green-600 h-2.5 rounded-full" style="width: {{ $paymentPercentage }}%"></div>
                                            </div>
                                            <span class="text-sm font-medium text-gray-700">{{ $paymentPercentage }}%</span>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-700">Total Fees</h4>
                                        <p class="text-2xl font-bold text-gray-900">{{ number_format($totalFees, 2) }}</p>
                                    </div>
                                    
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-700">Paid Amount</h4>
                                        <p class="text-2xl font-bold text-green-600">{{ number_format($paidFees, 2) }}</p>
                                    </div>
                                    
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-700">Due Amount</h4>
                                        <p class="text-2xl font-bold text-red-600">{{ number_format($dueFees, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Fee Details -->
                        <h4 class="text-md font-medium text-gray-800 mb-3">Fee Details</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Fee Type
                                        </th>
                                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Due Date
                                        </th>
                                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Amount
                                        </th>
                                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Paid
                                        </th>
                                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Balance
                                        </th>
                                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($student->fees->sortByDesc('due_date') as $fee)
                                        @php
                                            $balance = $fee->amount - $fee->paid_amount;
                                            $status = $balance <= 0 ? 'Paid' : ($fee->due_date < now() ? 'Overdue' : 'Pending');
                                        @endphp
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                                {{ $fee->fee_type }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                                {{ $fee->due_date->format('d M, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                                {{ number_format($fee->amount, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                                {{ number_format($fee->paid_amount, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                                {{ number_format($balance, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                                @if ($status == 'Paid')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        Paid
                                                    </span>
                                                @elseif ($status == 'Overdue')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        Overdue
                                                    </span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        Pending
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200 text-sm font-medium">
                                                <a href="{{ route('fees.generate-invoice', $fee->id) }}" class="text-indigo-600 hover:text-indigo-900" target="_blank">
                                                    <svg class="w-5 h-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                    Invoice
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-6 py-4 whitespace-nowrap border-b border-gray-200 text-center text-gray-500">
                                                No fee records found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Payment History -->
                        @if ($student->fees->sum('paid_amount') > 0)
                            <h4 class="text-md font-medium text-gray-800 mt-6 mb-3">Payment History</h4>
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white">
                                    <thead>
                                        <tr>
                                            <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Date
                                            </th>
                                            <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Fee Type
                                            </th>
                                            <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Amount
                                            </th>
                                            <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Payment Method
                                            </th>
                                            <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Transaction ID
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($student->fees as $fee)
                                            @if ($fee->payments && count($fee->payments) > 0)
                                                @foreach ($fee->payments as $payment)
                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                                            {{ $payment->payment_date->format('d M, Y') }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                                            {{ $fee->fee_type }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                                            {{ number_format($payment->amount, 2) }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                                            {{ $payment->payment_method }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                                            {{ $payment->transaction_id ?? 'N/A' }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>