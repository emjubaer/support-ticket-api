<?php

namespace App\Http\Controllers\Web;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('role', UserRole::Customer)->withCount(
            'tickets'
        )->latest()->paginate(10);
        return view('admin.customer.index', compact('customers'));
    }

    public function show($id)
    {
        return view('admin/customers/show', compact('id'));
    }
}
