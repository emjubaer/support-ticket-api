<?php

namespace App\Http\Controllers\Web;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AgentController extends Controller
{
     public function agentsIndex(){

        $agents = User::where('role', UserRole::Agent)->withCount(relations: 'assignedTickets')->get();

        return view('admin.agents.agentIndex', compact('agents'));
    }
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        // Create a new agent user
        $agent = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'role' => UserRole::Agent, // Assuming you have a UserRole enum
        ]);

        // Redirect to the agents list or show a success message
        return redirect()->route('agents.index')->with('success', 'Agent created successfully.');
    }

     public function agentDetails(User $agent){
        $agent->load('assignedTickets');

        return view('admin.agents.agentDetails', compact('agent'));
    }
}
