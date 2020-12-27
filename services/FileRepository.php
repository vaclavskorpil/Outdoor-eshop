<?php


namespace services;


use mysql_xdevapi\Exception;

class FileRepository
{
    static function saveFile(): ?string
    {
        try {
            $name = $_FILES['file']['name'];
            $target_dir = "images/";
            $target_file = $target_dir . basename($_FILES["file"]["name"]);

            // Select file type
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Valid file extensions
            $extensions_arr = array("jpg", "jpeg", "png", "gif");

            // Check extension
            if (in_array($imageFileType, $extensions_arr)) {

                // Upload file
                move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $name);
                unset($_FILES[['file']['tmp_name']]);
                return $target_dir . $name;
            }
            return null;
        } catch (Exception $e) {
            return null;
        }
    }
}