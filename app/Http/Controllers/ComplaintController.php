<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::where('user_id', Auth::id())->get();
        return view('users.complaints.index', compact('complaints'));
    }

    public function create()
    {
        return view('users.complaints.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'details' => 'required|string',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'date' => 'required|date',
            'address' => 'required|string|max:255',
        ]);

        $filePath = $request->file('file') ? $request->file('file')->store('complaints') : null;

        Complaint::create([
            'user_id' => Auth::id(),
            'category' => $request->input('category'),
            'details' => $request->input('details'),
            'file_path' => $filePath,
            'status' => 'Pending',
            'date' => $request->input('date'),
            'address' => $request->input('address'),
        ]);

        return redirect()->route('users.complaints.index')->with('success', 'Your complaint has been submitted successfully.');
    }

    public function edit($id)
    {
        $complaint = Complaint::findOrFail($id);

        // Ensure the user can only edit their pending complaints
        if ($complaint->status !== 'Pending') {
            return redirect()->route('users.complaints.index')->with('error', 'You can only edit pending complaints.');
        }

        return view('users.complaints.edit', compact('complaint'));
    }

    public function update(Request $request, $id)
    {
        $complaint = Complaint::findOrFail($id);

        // Ensure the complaint is pending
        if ($complaint->status !== 'Pending') {
            return redirect()->route('users.complaints.index')->with('error', 'You can only update pending complaints.');
        }

        $validated = $request->validate([
            'category' => 'required|string|max:255',
            'details' => 'required|string',
            'file' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            'date' => 'required|date',
            'address' => 'required|string|max:255',
        ]);

        // Update file if new one is provided
        if ($request->hasFile('file')) {
            $validated['file_path'] = $request->file('file')->store('complaint_files');
        }

        $complaint->update($validated);

        return redirect()->route('users.complaints.index')->with('success', 'Complaint updated successfully.');
    }

    public function destroy($id)
    {
        $complaint = Complaint::findOrFail($id);

        // Ensure the complaint is pending
        if ($complaint->status !== 'Pending') {
            return redirect()->route('users.complaints.index')->with('error', 'You can only delete pending complaints.');
        }

        $complaint->delete();

        return redirect()->route('users.complaints.index')->with('success', 'Complaint deleted successfully.');
    }

}

