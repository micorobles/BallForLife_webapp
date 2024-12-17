<?php

namespace App\Services;

use CodeIgniter\HTTP\Files\UploadedFile;

class FileUploadService
{
    /**
     * Handle file upload and move to public directory.
     *
     * @param \CodeIgniter\HTTP\Files\UploadedFile $file The file to be uploaded.
     * @param string $folder The folder where the file will be stored.
     * @param string $userID The user ID to create a unique file name.
     * @param array $profileData The array where the image path will be added.
     * @param string $key The key under which the image path will be stored in profileData.
     * @return void
     */
    public function handleFileUpload(UploadedFile $file, $folder, $userID, &$array, $key)
    {
        // if ($file && $file->isValid() && !$file->hasMoved()) {
        //     // Define a new name for the uploaded file
        //     $newFileName = $userID . '_' . $file->getName();
        //     $uploadPath = WRITEPATH . 'images/uploads/' . $folder . '/'; // Change this to your upload directory

        //     // Move the file to the writable directory
        //     $file->move($uploadPath, $newFileName);

        //     // Move to public folder
        //     copy($uploadPath . $newFileName, 'images/uploads/' . $folder . '/' . $newFileName);

        //     // Add the image path to the profile data
        //     $array[$key] = 'images/uploads/' . $folder . '/' . $newFileName; // Store the path relative to your public directory
        // } else {
        //     error_log('FILE IS NOT VALID');
        // }

        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Define the new file name
            $newFileName = $userID . '_' . $file->getName();

            // Define the paths for writable and public directories
            $uploadPath = WRITEPATH . 'images/uploads/' . $folder . '/'; // Writable directory path
            $publicPath = 'images/uploads/' . $folder . '/'; // Public directory path

            // Check if the file already exists in the writable directory
            if (!file_exists($uploadPath . $newFileName)) {
                // Move the file to the writable directory if it doesn't exist
                $file->move($uploadPath, $newFileName);
            }

            // Check if the file already exists in the public directory
            if (!file_exists($publicPath . $newFileName)) {
                // Copy the file from writable to public directory if it doesn't exist
                copy($uploadPath . $newFileName, $publicPath . $newFileName);
            }

            // Add the file path to the array (relative to public directory)
            $array[$key] = $publicPath . $newFileName; // Store the path relative to your public directory
        }
    }
}
