<?php

require "dbquery.php";

class Upload extends Query
{
    private $responseCode = 200;

    //gets called for every file once
    private $target_dir = "../uploads/";
    private $target_file = "../uploads/";
    private $uploadOk = 0;
    private $fileType = "";


    function __construct()
    {
        //Check if keys exists
        if (isset($_FILES["userfile"]["name"])) {
            $this->target_file = $this->target_dir . basename($_FILES["userfile"]["name"]);
            $this->uploadOk = 1;
            $this->fileType = pathinfo($this->target_file, PATHINFO_EXTENSION);
        } else {
            $this->responseCode = 400;
        }

    }

    public function checkFiles()
    {
        /*
            // Check if file already exists
            if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;
            }
            // Check file size
            if ($_FILES["userfile"]["size"] > 500000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }
            // Allow certain file formats

            if ($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg"
                && $fileType != "gif"  && $fileType != "pdf"
            ) {
                echo "Sorry, only JPG, JPEG, PNG, GIF and PDF files are allowed.";
                $uploadOk = 0;
            }
        */
    }

    public function uploadFiles()
    {

        if ($this->responseCode == 200) {
            if ($this->uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["userfile"]["tmp_name"], $this->target_file)) {
                    echo "The file " . basename($_FILES["userfile"]["name"]) . " has been uploaded.";

                    $name = $_FILES["userfile"]["name"];
                    $type = "";

                    if ($this->fileType == 'pdf') {
                        $type = 'pdf';
                    } else {
                        $type = 'image';
                    }

                    $path = $this->target_dir . $name;

                    $query = new Query("INSERT INTO resources (name, type, data) VALUES ('" . $name . "', '" . $type . "', '" . $path . "')");
                    $db = $query->getQuery();

                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        } else {
            echo array(
                "status" => 400,
                "msg" => "Sorry, the system did something unexpected. Contact the developers of the system. 400"
            );
        }
    }

}

$a = new Upload();
$a->checkFiles();
$a->uploadFiles();

?>