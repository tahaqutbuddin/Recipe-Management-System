<?php
$arr = array();
if(isset($_FILES['file'])){
    $target_path = "assets/img/cookingsteps/";
    // Loop to get individual element from the array
    $validextensions = array("jpeg", "jpg", "png","svg","webp");      // Extensions which are allowed.
    for($i = 0; $i < count($_FILES["file"]["name"]);$i++)
    {
        $md5_name = "";
        $ext = explode('.', basename(strtolower($_FILES["file"]['name'][$i])));   // Explode file name from dot(.)
        $file_extension = end($ext); // Store extensions in the variable.
        $md5_name = md5(uniqid()) . "." . $ext[count($ext) - 1];
        $checkExtension = strtolower($ext[count($ext) - 1]);
        if( ($checkExtension == "jpeg") || ($checkExtension == "jpg") || ($checkExtension == "png") || ($checkExtension == "svg") || ($checkExtension == "webp"))
        {
            $target_path = $target_path . $md5_name;     // Set the target path with a new name of image.
            if (($_FILES["file"]["size"][$i] < 8000000)  && in_array($file_extension, $validextensions)) 
            {
                if (move_uploaded_file($_FILES["file"]['tmp_name'][$i], $target_path)) 
                {
                    array_push($arr,$md5_name);
                    $target_path = "assets/img/cookingsteps/";
                }else { continue; } // unable to move file 
            }else { continue; } //invalid type and size
        }else { continue; }
    }
    echo json_encode($arr);
}else { echo false;}

?>