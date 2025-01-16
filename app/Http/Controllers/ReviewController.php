<?php

namespace App\Http\Controllers;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, $productId)
    {
        $request->validate([
            'stars' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:500',  // Make sure you're validating the 'review' field
        ]);

        $review = new Review([
            'stars' => $request->input('stars'),
            'review' => $request->input('review'),  // Use the 'review' input here
        ]);

        $review->user_id = auth()->id();
        $review->product_id = $productId;

        $review->save();

        return redirect()->route('users.products.show', $productId)->with('success', 'Review added successfully!');
    }



    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        // Ensure the logged-in user owns the review
        if ($review->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'stars' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:500',
        ]);

        $review->stars = $request->input('stars');
        $review->review = $request->input('review');
        $review->save();

        return redirect()->route('users.products.show', $review->product_id)->with('success', 'Review updated successfully!');
    }

    public function edit($id)
    {
        $review = Review::findOrFail($id);

        // Ensure the logged-in user owns the review
        if ($review->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('users.reviews.edit', compact('review'));
    }
    


    public function destroy($id)
    {
        $review = Review::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        $review->delete();

        return back()->with('success', 'Review deleted successfully.');
    }
}
