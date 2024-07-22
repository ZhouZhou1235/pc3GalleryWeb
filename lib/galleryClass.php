<?php
namespace {
    require_once "dbClass.php";
    class furryArt {
        // 毛绒艺术
        function upload($file,$title,$info,$type,$visit,$tags=""){
            // 作品上传
            global $link;
            require_once "coinClass.php";
            require_once "userClass.php";
            $fileName=$file['name'];$tempName=$file['tmp_name'];
            $fileArray = pathinfo($fileName);$fileType = $fileArray['extension'];
            $furryUser = $_SESSION['username'];
            $newFileName = $furryUser."-".date('YmdHis',time())."-".rand(1,100).".".$fileType;
            $sql = "insert into gallery(username,file,title,info,type,visit)
            values('$furryUser','$newFileName','$title','$info','$type','$visit')";
            $result = mysqli_query($link,$sql);$result->num_rows;
            mysqli_commit($link);
            if(!file_exists("../gallery")){mkdir("../gallery");}
            if(!file_exists("../gallery/$furryUser")){mkdir("../gallery/$furryUser");}
            move_uploaded_file($tempName,"../gallery/$furryUser/".$newFileName);
            $this->compress("../gallery/$furryUser/".$newFileName,$newFileName,$furryUser);
            $coinChange = new coinChange;
            $coinChange->coinAdd($furryUser,1);
            if(!empty($tags)){
                $userAction = new userAction;
                $selectData = new selectData;
                $galleryId = $selectData->getMaxId("gallery");
                $userAction->addTagsAndConnect($tags,$galleryId);
            }
            return 1;
        }
        function editGallery($galleryId){
            // 修改画廊
            global $link;
            include_once "../lib/examineClass.php";
            include_once "../lib/coinClass.php";
            session_start();
            $userInput = new userInput;
            $userState = new userState;
            $coinChange = new coinChange;
            $title=$_POST['title'];$info=$_POST['info'];$type=$_POST['type'];$visit=$_POST['visit'];
            $furryUser = $_SESSION['username'];
            $num1 = $userInput->checkEditGallery($title,$type,$visit);
            $num2 = $userState->checkUserAndGallery($galleryId);
            if($num1+$num2<2){return 0;}
            $coinChange->coinSubtract($furryUser,1);
            $sql = "update gallery set title='$title',info='$info',type='$type',visit='$visit' where id='$galleryId'";
            $result = mysqli_query($link,$sql);$result->num_rows;
            return 1;
        }
        function identifyType($type){
            // 识别作品类型输出提示
            if($type==1){$outStr = "原创";}
            else if($type==2){$outStr = "二次创作";}
            else if($type==3){$outStr = "改图";}
            else if($type==4){$outStr = "转载";}
            else if($type==5){$outStr = "照片";}
            return $outStr;
        }
        function identifyVisit($visit,$username,$file){
            // 识别作品分级并输出资源地址
            if($visit==1){$imgSrc = "/galleryThumbnail/$username/$file";}
            else if($visit==2){$imgSrc = "/resource/img/type2.png";}
            else if($visit==3){$imgSrc = "/resource/img/type3.png";}
            else if($visit==4){$imgSrc = "/resource/img/type4.png";}
            return $imgSrc;
        }
        function compress($src="",$newFileName,$furryUser,$percent=0.5){
            // 压缩图片
            list($width,$height,$type,$attr) = getimagesize($src);
            $type = image_type_to_extension($type,false);
            $fun = "imagecreatefrom".$type;
            $image = $fun($src);
            $new_width = $width*$percent;
            $new_height = $height*$percent;
            $createImg = imagecreatetruecolor($new_width,$new_height);
            imagecopyresampled($createImg,$image,0,0,0,0,$new_width,$new_height,$width,$height);
            imagedestroy($image);
            if(!file_exists("../galleryThumbnail")){mkdir("../galleryThumbnail");}
            if(!file_exists("../galleryThumbnail/$furryUser")){mkdir("../galleryThumbnail/$furryUser");}
            $path = "../galleryThumbnail/$furryUser/$newFileName";
            $funcs = "image".$type;
            $funcs($createImg,$path);
            return 1;
        }
    }
}