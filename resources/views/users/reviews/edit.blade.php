<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Review</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-4">Edit Your Review</h1>
            <form action="{{ route('reviews.update', $review->id) }}" method="POST">
                @csrf
                @method('PUT') 

                <div class="flex items-center space-x-2">
                    <label class="text-gray-700">Rate:</label>
                    <div class="flex space-x-1" id="star-rating">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg 
                                class="w-8 h-8 text-gray-400 hover:text-yellow-500 cursor-pointer"
                                data-value="{{ $i }}"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none" 
                                viewBox="0 0 24 24" 
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                            </svg>
                        @endfor
                    </div>
                    <input type="hidden" name="stars" id="rating-value" value="{{ $review->stars }}">
                </div>

                <textarea name="review" class="mt-4 border border-gray-300 rounded w-full p-2" rows="3" placeholder="Leave a review (optional)...">{{ old('review', $review->review) }}</textarea>
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded mt-4">Save Changes</button>
            </form>

        </div>
    </div>
</body>
</html>
