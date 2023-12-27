<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{

 

    public function upload(Request $request, $width, $height, $destinationPath)
    {
        $results = [];

        if ($request->hasFile('photo')) {
            // Validate the uploaded file
            $request->validate([
                'photo' => 'image|mimes:jpeg,png,jpg,gif', // Adjust as needed
            ]);
            // Get the uploaded image
            $image = $request->file('photo');
            // Create an instance of the Intervention Image
            $img = Image::make($image->getRealPath());
            // Resize the image while maintaining its aspect ratio
            $img->fit($width, $height);
            // Define the directory to store the resized image
            $directory = $destinationPath;
            // Ensure that the directory exists
            if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory);
            }

            // Generate a unique filename for the resized image
            $filename = time() . '.' . $image->getClientOriginalExtension();

            // Save the resized image to the storage directory
            $img->save(storage_path('app/' . $directory . '/' . $filename));

            // Get the path to the resized image
            $imagePath = '/storage/photos/userproducts/' . $filename;

            // Optimize the image using Spatie Image Optimizer
            $optimizerChain = OptimizerChainFactory::create();
            $optimizerChain->optimize(storage_path( 'app/' . $directory . $filename));

            // Add the image path to the results array
            $results['image_path'] = $imagePath;
        }

        return $results;
    }


    public function userbannerupload(ProfileUpdateRequest $request, $width, $height, $destinationPath)
    {
        $results = [];

        if ($request->hasFile('photo')) {
            // Validate the uploaded file
            $request->validate([
                'photo' => 'image|mimes:jpeg,png,jpg,gif', // Adjust as needed
            ]);
            // Get the uploaded image
            $image = $request->file('photo');
            // Create an instance of the Intervention Image
            $img = Image::make($image->getRealPath());
            // Resize the image while maintaining its aspect ratio
            $img->fit($width, $height);
            // Define the directory to store the resized image
            $directory = $destinationPath;
            // Ensure that the directory exists
            if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory);
            }

            // Generate a unique filename for the resized image
            $filename = time() . '.' . $image->getClientOriginalExtension();

            // Save the resized image to the storage directory
            $img->save(storage_path('app/' . $directory . '/' . $filename));

            // Get the path to the resized image
            $imagePath = '/storage/photos/p/' . $filename;

            // Optimize the image using Spatie Image Optimizer
            $optimizerChain = OptimizerChainFactory::create();
            $optimizerChain->optimize(storage_path( 'app/' . $directory . $filename));

            // Add the image path to the results array
            $results['image_path'] = $imagePath;
        }

        return $results;
    }
     

    
}
