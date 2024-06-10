<?php

namespace App\Service;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Illuminate\Support\Str;

class ImageService
{
    // Method to add image to a model
    public function saveImage($model, $image, $directory)
    {
        // Check if there are images to save
        if (!empty($image)) {
            $directory = 'public/images/' . $directory;
            // Create directory if it doesn't exist
            $this->makeDirectory($directory);
            // Generate unique filename
            $imageNames = $this->makeName($image);
          
            // Move and resize image
            $this->moveImage($image, $directory, $imageNames['saveName'], 1024, 720);
            // Create a new Image model instance
            $imageModel = new Image();
           
            // Assign model type (e.g., User, Product, etc.)
            $imageModel->model_type = $model;
            // Assign model ID
            $imageModel->model_id = $model->id;
            // Assign filename
            $imageModel->filename = $imageNames['saveName'];
            // Assign location
            $imageModel->location = $directory;
            // Save the image in the database
            $model->image()->save($imageModel);
        }

        return; // Return nothing
    }

    // Method to create a directory if it doesn't exist
    private function makeDirectory($path)
    {
        if (!Storage::exists($path)) {
            Storage::makeDirectory($path);
        }

        return; // Return nothing
    }

    // Method to generate a unique filename for an image
    public function makeName($image, $type = null)
    {
        // Get the original filename
        $originalName = Str::replace(' ', '-', trim($image->getClientOriginalName()));
        // Limit the filename length
        $NameWithoutExtension = Str::limit(pathinfo($originalName, PATHINFO_FILENAME), 200);
        // Generate a unique save filename
        $saveName = time() . '-' . $NameWithoutExtension . '.' . $image->getClientOriginalExtension();
        return [
            'saveName' => $saveName, // Return the unique filename
            'originalName' => $originalName, // Return the original filename
        ];
    }

    // Method to move and resize an image
    public function moveImage($image, $directory, $saveName, $width = 544, $height = 356)
    {
        $image=$image->getClientOriginalName();
        // Store the image in the specified directory
        return Storage::put($directory . '/' . $saveName, $image, [
            'visibility' => 'public',
        ]);
    }

    // Method to delete image
    public function deleteImage($image)
    {
        // Delete image from the database
        $image->delete();
        // Delete image from local storage
        $path = $image->location . '/' . $image->filename;
        Storage::delete($path);
    }

      // Method to update images for a model
      public function updateImage($model, $image, $directory, $deletePrevious = false)
      {
          // Check if there are new images to update
          if (!empty($image)) {
              // If deletePrevious flag is set to true, delete previous images
              if ($deletePrevious) {
                  $this->deleteImage($model->image); // Delete previous images
              }
              // Make the directory if it doesn't exist
              $this->makeDirectory($directory);
              // Save new images
              $this->saveImage($model, $image,  $directory);
          }
      }
}