<?php

require "ServerWrapper.php";
include_once "Resource.php";

class Upload extends ServerWrapper
{

    private $resource;

    //gets called for every file once
    private $target_dir = "../uploads/";
    private $target_file = "";
    private $uploadOk = 0;
    private $fileType = "";


    function __construct()
    {
        //Check if keys exists
        if (isset($_FILES["userfile"]["name"])) {
            $this->target_file = $this->target_dir . basename($_FILES["userfile"]["name"]);
            $this->uploadOk = 1;
            $this->fileType = pathinfo($this->target_file, PATHINFO_EXTENSION);
            $this->resource = new Resource();
            echo $this->execute();
            return;
        }

        echo "Wrong Param Format.";

    }

    /**
     * @return Response The return value shall be a Response
     */
    public function execute()
    {
        if(!$this->checkFiles()) return;
        if ($this->uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else if (move_uploaded_file($_FILES["userfile"]["tmp_name"], $this->target_file)) {

            echo "The file " . basename($_FILES["userfile"]["name"]) . " has been uploaded.";

            $this->resource->setName($_FILES["userfile"]["name"]);

            $this->resource->setData($this->target_dir . $this->resource->getName());
            $query = new Query("INSERT INTO resources (name, type, data) VALUES ('" . $this->resource->getName() . "', '" . $this->resource->getType() . "', '" . $this->resource->getData() . "')");
            $query->executeQuery();

            return $query->getResponse();
        }
        return new Response('404','The file could not be uploaded');
    }

    public function checkFiles()
    {

        if ($this->fileType == 'pdf') $this->resource->setType("pdf");
        else if ($this->fileType == 'ics') $this->resource->setType("caldav");
        else if ($this->fileType == 'image') $this->resource->setType("image");
        else {
            echo "The file type is not supported.";
            return false;
        }

        return true;
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
}

$a = new Upload();

?>