@extends('layouts.admin')

@section('title', 'Agent Details')
@section('page_title', 'Agent Details')

@section('content')
    <div class="max-w-6xl mx-auto p-6 space-y-6">

        <!-- Header -->
        <div class="flex items-center gap-4 bg-white p-5 rounded shadow">
            <img src="https://via.placeholder.com/80" class="w-20 h-20 rounded-full object-cover border">
            <div>
                <h2 class="text-xl font-semibold">Agent Name</h2>
                <p class="text-sm text-gray-500">agent@email.com</p>
                <span class="inline-block mt-1 px-3 py-1 text-xs rounded-full bg-green-100 text-green-700">
                    Active
                </span>
            </div>
        </div>

        <!-- Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Basic Information -->
            <div class="bg-white p-5 rounded shadow">
                <h3 class="font-semibold mb-4">Basic Information</h3>
                <ul class="space-y-2 text-sm">
                    <li><strong>Name:</strong> Agent Name</li>
                    <li><strong>Email:</strong> agent@email.com</li>
                    <li><strong>Phone:</strong> 01XXXXXXXXX</li>
                    <li><strong>Role:</strong> Agent</li>
                    <li><strong>Status:</strong> Active</li>
                </ul>
            </div>

            <!-- Work Information -->
            <div class="bg-white p-5 rounded shadow">
                <h3 class="font-semibold mb-4">Work Information</h3>
                <ul class="space-y-2 text-sm">
                    <li><strong>Department:</strong> Support</li>
                    <li><strong>Total Tickets Assigned:</strong> 120</li>
                    <li><strong>Total Tickets Solved:</strong> 95</li>
                    <li><strong>Pending Tickets:</strong> 25</li>
                </ul>
            </div>

            <!-- Performance Info -->
            <div class="bg-white p-5 rounded shadow">
                <h3 class="font-semibold mb-4">Performance Info</h3>
                <ul class="space-y-2 text-sm">
                    <li><strong>Avg Response Time:</strong> 15 min</li>
                    <li><strong>Solve Rate:</strong> 79%</li>
                    <li><strong>Last Ticket Activity:</strong> 2 days ago</li>
                </ul>
            </div>

            <!-- Account Info -->
            <div class="bg-white p-5 rounded shadow">
                <h3 class="font-semibold mb-4">Account Information</h3>
                <ul class="space-y-2 text-sm">
                    <li><strong>Account Created:</strong> 10 Jan 2025</li>
                    <li><strong>Last Login:</strong> Today at 9:30 PM</li>
                </ul>
            </div>

        </div>

        <!-- Notes -->
        <div class="bg-white p-5 rounded shadow">
            <h3 class="font-semibold mb-3">Admin Notes</h3>
            <textarea class="w-full border rounded p-3 text-sm focus:outline-none focus:ring" rows="4"
                placeholder="Write internal notes about this agent..."></textarea>

            <div class="mt-3 text-right">
                <button class="px-4 py-2 bg-blue-600 text-white rounded text-sm">
                    Save Notes
                </button>
            </div>
        </div>

    </div>
@endsection
