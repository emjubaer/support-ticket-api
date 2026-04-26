@extends('layouts.admin')

@section('title', 'Customers')
@section('page_title', 'Customers')

@section('content')
    <div class="bg-white rounded-xl shadow">
        <div class="p-5 border-b flex justify-between items-center">
            <h2 class="font-semibold">All Customers</h2>
        </div>

        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-3 text-left">#</th>
                    <th class="p-3 text-left">ID</th>
                    <th class="p-3 text-left">Customer</th>
                    <th class="p-3 text-left">Email</th>
                    <th class="p-3 text-center">Total Tickets</th>
                    <th class="p-3 text-center">Open Tickets</th>
                    <th class="p-3 text-center">Closed Tickets</th>
                    <th class="p-3 text-center">Created At</th>
                    <th class="p-3 text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($customers as $customer)
                    <tr class="border-t">
                        <td class="p-3">{{ $loop->iteration }}</td>
                        <td class="p-3">{{ $customer->id }}</td>

                        <td class="p-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-semibold">
                                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">{{ $customer->name }}</p>
                                    <p class="text-xs text-gray-500">Customer</p>
                                </div>
                            </div>
                        </td>

                        <td class="p-3 text-gray-600">
                            {{ $customer->email }}
                        </td>

                        <td class="p-3 text-center">
                            <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-semibold">
                                {{ $customer->tickets_count }}
                            </span>
                        </td>

                        <td class="p-3 text-center">
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                                {{ $customer->open_tickets_count }}
                            </span>
                        </td>

                        <td class="p-3 text-center">
                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">
                                {{ $customer->closed_tickets_count }}
                            </span>
                        </td>

                        <td class="p-3 text-center text-gray-500">
                            {{ $customer->created_at->format('d M Y') }}
                        </td>

                        <td class="p-3 text-center">
                            <div class="relative inline-block">
                                <button id="customer-button-{{ $customer->id }}"
                                    onclick="toggleCustomerDropdown(event, {{ $customer->id }})"
                                    class="text-gray-600 hover:text-gray-900 font-bold text-lg cursor-pointer">
                                    ⋯
                                </button>

                                <div id="customerDropDownMenu-{{ $customer->id }}"
                                    class="hidden absolute right-0 mt-1 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
                                    <a href="{{ route('customers.show', $customer) }}"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 border-b">
                                        👁️ View Details
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="p-6 text-center text-gray-500">No customers found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4">
            {{ $customers->links() }}
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function toggleCustomerDropdown(event, customerId) {
        event.preventDefault();
        event.stopPropagation();

        const menu = document.getElementById('customerDropDownMenu-' + customerId);

        document.querySelectorAll('[id^="customerDropDownMenu-"]').forEach(m => {
            if (m.id !== 'customerDropDownMenu-' + customerId) {
                m.classList.add('hidden');
            }
        });

        menu.classList.toggle('hidden');
    }

    document.addEventListener('click', function(event) {
        const isButton = event.target.closest('button[onclick*="toggleCustomerDropdown"]');
        if (!isButton) {
            document.querySelectorAll('[id^="customerDropDownMenu-"]').forEach(menu => {
                menu.classList.add('hidden');
            });
        }
    });
</script>
@endpush
