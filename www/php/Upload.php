<?php

require_once("Events.php");
include_once "Resource.php";

class Upload extends Events
{

    private $resource;

    //gets called for every file once
    private $target_dir = "../uploads/";
    private $target_file;
    private $fileType;
    private $tempFile;
    private $file;


    function __construct()
    {
        //Check if keys exists
        if (isset($_FILES["userfile"]["name"])) {
            $this->target_file = $this->target_dir . basename($_FILES["userfile"]["name"]);
            $this->tempFile = $_FILES["userfile"]["tmp_name"];
            $this->file = $_FILES["userfile"]["name"];
            $this->uploadOk = 1;
            $this->fileType = pathinfo($this->target_file, PATHINFO_EXTENSION);
            $this->resource = new Resource('','','');
            return;
        }

        echo "Wrong Param Format.";

    }

    /**
     * @return Response The return value shall be a Response
     */
    public function execute()
    {
        if(!$this->verify()) return new Response('404','The file type is not supported');
        if (move_uploaded_file($this->tempFile, $this->target_file) || isset($_POST['test'])) {
            $this->resource->setName($this->file);
            $this->resource->setData($this->target_dir . $this->resource->getName());
            $query = new Query("INSERT INTO resources (name, type, data) VALUES ('" . $this->resource->getName() . "', '" . $this->resource->getType() . "', '" . $this->resource->getData() . "')");
            $query->executeQuery();

            return $query->getResponse();
        }
        return new Response('404','The file could not be uploaded');
    }

    protected function verify()
    {
        if($this->fileType == null) return false;

        if (strcasecmp($this->fileType, 'pdf') == 0) $this->resource->setType("pdf");
        else if (strcasecmp($this->fileType, 'ics') == 0) $this->resource->setType("caldav");
        else if (strcasecmp($this->fileType, 'jpg') == 0 || strcasecmp($this->fileType, 'jpeg') == 0|| strcasecmp($this->fileType, 'png') == 0|| strcasecmp($this->fileType, 'gif') == 0) $this->resource->setType("image");
        else {return false;}

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

    public function initTestData($type,$file,$baseFile){
        $this->target_file = $file;
        $this->fileType = $type;
        $this->tempFile = $baseFile ;
        $this->file =  $baseFile;

        $this->resource = new Resource('','','');
    }
}

$a = new Upload();
echo $a->execute();

?>