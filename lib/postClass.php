<?php
namespace {
    require_once "examineClass.php";
    class furryGarden {
        // 小兽花园
        function __construct(){
            echo <<<EOF
                <script>console.log("furryGarden 小兽花园");</script>
            EOF;
        }
        function addNewPost($furryUser){
            // 发布新帖子
            include_once "dbClass.php";
            include_once "userClass.php";
            include_once "examineClass.php";
            $userInput = new userInput;
            $dbTable = new dbTable;
            $selectData = new selectData;
            $userAction = new userAction;
            $dataExist = new dataExist;
            $userState = new userState;
            // 获得输入内容
            $title = $userInput->inputFilter($_POST["title"]);
            $subtitle = $userInput->inputFilter($_POST["subtitle"]);
            $content = $userInput->inputFilter($_POST["content"]);
            $galleryId = $userInput->inputFilter($_POST["galleryId"]);
            $tags = $userInput->inputFilter($_POST["tags"]);
            $file = $_FILES['postImg'];
            // 检查输入内容
            $num1 = $userInput->checkAddPost($title,$content,$file);
            if(empty($galleryId)){$num2=1;}
            else{$num2=$dataExist->checkGalleryExist($galleryId);}
            $num3 = $userState->checkLogin();
            if($num1+$num2+$num3<3){return 0;}
            // 如果有文件则上传帖子图片
            if(!empty($file['name'])){
                if($file['size']<=0.5*1024*1024){$this->uploadNewPostImg($furryUser,$file,1);}
                else{$this->uploadNewPostImg($furryUser,$file);}
                $postImgId = $selectData->getMaxId("postimg");
            }
            // 帖子信息写入数据库
            $postId = $dbTable->db_addPost($furryUser,$title,$subtitle,$content,$galleryId,$postImgId);
            // 添加标签
            $userAction->addTagsToPost($tags,$postId);
            return 1;
        }
        function uploadNewPostImg($furryUser,$file,$percent=0.5){
            // 上传帖子图片
            include_once "dbClass.php";
            $dbTable = new dbTable;
            // 得到图片基本信息
            $fileName=$file['name'];
            $tempName=$file['tmp_name'];
            $fileArray=pathinfo($fileName);
            $fileType=$fileArray['extension'];
            $newFileName = $furryUser."-".date('YmdHis',time())."-".rand(1,100).".".$fileType;
            // 保存图片
            if($fileType=="gif"){
                // 若为gif动图则不要压缩直接保存
                $this->postImgGifSave($tempName,$newFileName,$furryUser);
            }
            else{$this->postImgCompress($tempName,$newFileName,$furryUser,$percent);}
            // 图片信息写入数据库
            $dbTable->db_addPostImg($furryUser,$newFileName);
            return 1;
        }
        function postImgCompress($src="",$newFileName,$furryUser,$percent=0.5){
            // 压缩帖子图片并保存
            list($width,$height,$type,$attr) = getimagesize($src);
            $type = image_type_to_extension($type,false);
            $fun = "imagecreatefrom".$type;
            $image = $fun($src);
            $new_width = $width*$percent;
            $new_height = $height*$percent;
            $createImg = imagecreatetruecolor($new_width,$new_height);
            imagecopyresampled($createImg,$image,0,0,0,0,$new_width,$new_height,$width,$height);
            imagedestroy($image);
            if(!file_exists("../postImg")){mkdir("../postImg");}
            if(!file_exists("../postImg/$furryUser")){mkdir("../postImg/$furryUser");}
            $path = "../postImg/$furryUser/$newFileName";
            $funcs = "image".$type;
            $funcs($createImg,$path);
            return 1;
        }
        function postImgGifSave($theGif,$newFileName,$username){
            // 帖子图片 对于GIF直接保存
            if(!file_exists("../postImg")){mkdir("../postImg");}
            if(!file_exists("../postImg/$username")){mkdir("../postImg/$username");}
            $save_url = "../postImg/$username/$newFileName";
            rename($theGif,$save_url);
        }
    }
}