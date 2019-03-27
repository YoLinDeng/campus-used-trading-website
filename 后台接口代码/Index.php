<?php
namespace app\index\controller;
use think\Db;
class Index 
{   // 登录接口
    public function login()
    {  $telNum = input('post.telNum');
       $password = input('post.password');
       $userInfo = Db::name('user')->where('telNum','=',$telNum)->select();
       if ($userInfo == null) {
        $data = ['code'=> 0,'status' => false,'msg' => '登录失败'];
        echo json_encode($data);
       } else {
         if ($userInfo[0]['password'] === $password) {
          $data = ['code'=> 1,'status' => true,'msg' => '登录成功','data' =>$userInfo];
          echo json_encode($data);
         }
       }
        
    }
    // 验证手机号唯一
    public function checkTelNum() {
      $telNum = input('post.telNum');
      $users = Db::name('user')->where('telNum','=',$telNum)->select();
      if ($users == null) {
        $data = ['code'=> 1,'msg' => 'fail','isOnly' =>true];
      } else {
        $data = ['code'=> 1,'msg' => 'success','isOnly' =>false];
      }
      echo json_encode($data);
    }
    // 注册接口
    public function register() {
      $param = input('post.');
     $result = Db::name('user')->insert($param);
     if($result) {
        $data = ['code'=>1,'msg'=>'success'];
     } else {
       $data = ['code' => 0,'msg' =>'fail'];
     }
      echo json_encode($data);
    }
    //  上传头像接口
    public function uploadsImg()
    {

        $uptypes = array('image/jpg', 'image/jpeg', 'image/png', 'image/pjpeg');
        $max_file_size = 3000000;     //上传文件大小限制, 单位BYTE
        $upload_path = 'public/upload/img'; //上传文件路径

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!is_uploaded_file($_FILES['img']['tmp_name'])) //是否存在文件
            {
                echo "图片不存在!";
                exit;
            }

            $file = $_FILES["img"];

            if ($max_file_size < $file["size"]) //检查文件大小
            {
                echo "文件太大!";
                exit;
            }

            if (!in_array($file["type"], $uptypes)) //检查文件类型
            {
                echo "文件类型不符!" . $file["type"];
                exit;
            }
            $data = $_POST;
            $files = request()->file('img');
            $telNum = request()->param('telNum');
            if (isset($files)) {
                // 获取表单上传文件 例如上传了001.jpg
                // 移动到框架应用根目录/public/uploads/ 目录下
                $info = $files->move(ROOT_PATH . $upload_path);
                if ($info) {
                    // 成功上传后 获取上传信息
                    $a = $info->getSaveName();
                    $imgp = str_replace("\\", "/", $a);
                    $imgpath = '/upload/img/' . $imgp;
                    $data['path'] = $imgpath;
                    $data['size']=$file["size"];
                    $data['name']=$file["name"];
                } else {
                    // 上传失败获取错误信息
                    echo $file->getError();
                }
            }


            if($telNum) {
          
            $result=Db::table('user')->where('telNum',$telNum)->setField('userImg',  $imgpath);
            if ($result){
                $msg['msg'] = '图片保存成功';
                $msg['code'] = 1;
                $msg['path']=$imgpath;
            }else{
                $msg['msg'] = '图片保存失败';
                $msg['code'] = 0;
                $msg['path']=" ";
            }

            echo json_encode($msg);
          } else {
            $data = ['code' =>1,'msg'=>'success','path'=>$imgpath];
            echo json_encode($data);
          }
        }
    }

    // 获取用户信息通过手机号
    public function getUserInfoByTelNum() {
      $telNum = input('post.telNum');
      $userInfo = Db::name('user')->where('telNum',$telNum)->find();
      if($userInfo) {
        $data = ['code' => 1,'msg' => 'success','data' => $userInfo];
        echo json_encode($data);
      }
    }

    // 修改用户信息
    public function changeUserInfo() {
      $userName = input('post.userName');
      $sex = input('post.sex');
      $age = input('post.age');
      $address = input('post.address');
      $telNum = input('post.telNum');
      if($userName) {
       $result = Db::table('user')->where('telNum',$telNum)->setField('userName', $userName);
       if($result) {
        $data = ['code'=>1,'msg'=>'用户名设置成功'];
       } else {
        $data = ['code'=>0,'msg'=>'用户名设置失败'];
       }
        echo json_encode($data);
      }
      if($sex) {
        $result = Db::name('user')->where('telNum',$telNum)->setField('sex',  $sex);
        if($result) {
          $data = ['code'=>1,'msg'=>'性别设置成功'];
         } else {
          $data = ['code'=>0,'msg'=>'性别设置失败'];
         }
        echo json_encode($data);
      }
      if($age) {
        $result = Db::name('user')->where('telNum',$telNum)->setField('age',  $age);
        if($result) {
          $data = ['code'=>1,'msg'=>'年龄设置成功'];
         } else {
          $data = ['code'=>0,'msg'=>'年龄设置失败'];
         }
        echo json_encode($data);
      }
      if($address) {
        $result = Db::name('user')->where('telNum',$telNum)->setField('address',  $address);
        if($result) {
          $data = ['code'=>1,'msg'=>'地址设置成功'];
         } else {
          $data = ['code'=>0,'msg'=>'地址设置失败'];
         }
        echo json_encode($data);
      }
    }

    // 通过uid查询商品信息列表 status: 1发布 
    public function getGoodsList() {
      $uid = input('post.uid');
      $status = input('post.status');
      $goodsList = Db::name('goods')->where('uid',$uid)->where('status',$status)->select(); 
      if($goodsList) {
        $data = ['code' => 1, 'msg'=>'success','data' => $goodsList];
      } else {
        $data = ['code' => 0, 'msg'=>'fail'];
      }
      echo json_encode($data);
    }
     // 通过uid查询订单信息列表 status: 0买到，1卖出
     public function getOrderList() {
      $uid = input('post.uid');
      $status = input('post.status');
      $goodsList = Db::name('order')->where('uid',$uid)->where('status',$status)->select(); 
      if($goodsList) {
        $data = ['code' => 1, 'msg'=>'success','data' => $goodsList];
      } else {
        $data = ['code' => 0, 'msg'=>'fail'];
      }
      echo json_encode($data);
    }


    // 通过商品Id获取商品详情页面信息
    public function getGoodsDetailInfo() {
      $goodsId = input('post.goodsId');
      $uid = input('post.uid');
      $goodsDetail = Db::name('goods')->where('goodsId',$goodsId)->find();
      $userInfo = Db::name('user')->where('uid',$uid)->find();
      if($goodsDetail) {
        $data = ['code' => 1, 'msg'=>'success','goodsData' => $goodsDetail,'userData' =>$userInfo];
      } else {
        $data = ['code' => 0, 'msg'=>'fail'];
      }
      echo json_encode($data);
    }

    // 通过商品Id删除发布商品
    public function deletePublicGoods() {
      $goodsId = input('post.goodsId');
      $result = Db::table('goods')->where('goodsId',$goodsId)->delete();
      if($result) {
        $data = ['code'=>1,'msg'=>'删除成功'];
      } else {
        $data = ['code'=>0,'msg'=>'删除失败'];
      }
      echo json_encode($data);
    }

    // 通过uid获取收藏夹列表
    public function getFavoriteList() {
      $uid = input('post.uid');
      $goodsId = input('post.goodsId');
      if($goodsId) {
        $favoriteList = Db::name('favorites')->where('uid',$uid)->where('goodsId',$goodsId)->select();
      } else {
        $favoriteList = Db::name('favorites')->where('uid',$uid)->select();
      }
     
      if($favoriteList) {
        $data = ['code'=>1,'msg'=>'success', 'data' => $favoriteList];
      } else {
        $data = ['code'=>0,'msg'=>'fail'];
      }
      echo json_encode($data);
    }

    // 通过uid获取管理操作栏 （未发布0、发布1、买到0、卖出1,收藏夹）个数
    public function getManageNum() {
      $uid = input('post.uid');
      // 获取发布信息
      $public = Db::name('goods')->where('uid',$uid)->where('status',1)->select();
      // 获取卖出信息
      $sell = Db::name('order')->where('uid',$uid)->where('status',1)->select();
      // 获取买到信息
      $buy = Db::name('order')->where('uid',$uid)->where('status',0)->select();
      // 获取收藏夹信息
      $favorite =  Db::name('favorites')->where('uid',$uid)->select();
      $publicNum = count($public);
      $sellNum = count($sell);
      $buyNum = count($buy);
      $favoriteNum = count($favorite);
      $data = ['code' => 1, 'msg' => 'success', 'publicNum' =>  $publicNum, 
      'sellNum' => $sellNum, 'buyNum' => $buyNum, 
      'favoriteNum' => $favoriteNum];
      echo json_encode($data);
    }

    // 删除收藏夹项
    public function deleteFavorite() {
      $uid = input('post.uid');
      $goodsId = input('post.goodsId');
      // 更新想要次数
      $goodsObj = Db::name('goods')->where('goodsId',$goodsId)->select();
      $likeNum = $goodsObj[0]['likeNum'] - 1;
      Db::name('goods')->where('goodsId',$goodsId)->setField('likeNum',$likeNum);
      $result = Db::table('favorites')->where('uid',$uid)->where('goodsId',$goodsId)->delete();
      if($result) {
        $data = ['code' => 1, 'msg' =>'删除成功'];
      } else {
        $data = ['code' => 0, 'msg' =>'删除失败'];
      }
      echo json_encode($data);
    }

    // 添加收藏夹接口
    public function addFavorite() {
      $param = input('post.');
      $uid = $param['uid'];
      $goodsId = $param['goodsId'];
      // 更新想要次数
      $goodsObj = Db::name('goods')->where('goodsId',$goodsId)->select();
      $likeNum = $goodsObj[0]['likeNum'] + 1;
      Db::name('goods')->where('goodsId',$goodsId)->setField('likeNum',$likeNum);
      $hasfollow = Db::name('favorites')->where('uid',$uid)->where('goodsId',$goodsId)->select();
      if(!$hasfollow) {
        $result =  Db::name('favorites')->insert($param);
        if($result) {
          $data = ['code' => 1,'msg'=>'success'];
          echo json_encode($data);
        } else {
          $data = ['code' => 0,'msg'=>'fail'];
          echo json_encode($data);
        }
      } else {
        $data = ['code' => 0,'msg'=>'fail'];
        echo json_encode($data);
      }

    }

    // 获取评论信息
    public function getCommentList() {
      $uid = input('post.uid');
      $goodsId = input('post.goodsId');
      if($goodsId) {
        $comment = Db::name('comment')->where('goodsId',$goodsId)->order('id desc')->select();
      } else {
        $comment = Db::name('comment')->where('uid',$uid)->order('id desc')->select();
      }
      if($comment) {
        $data = ['code'=>1,'msg'=>'success','data'=>$comment];
      } else {
        $data = ['code'=>0,'msg'=>'fail'];
      }
      echo json_encode($data);
    }

    // 添加评论
    public function addComment() {
      $params = input('post.');
      $result = Db::name('comment')->insert($params);
      if($result) {
        $data = ['code'=>1,'msg'=>'success'];
      } else {
        $data = ['code'=>0,'msg'=>'fail'];
      }
      echo json_encode($data);
    }

    // 获取用户信息通过id
    public function getUserInfoById() {
      $uid = input('post.uid');
      // 当前账户ID
      $userId = input('post.userId');
      $follow = Db::name('follow')->where('uid',$userId)->where('follUid',$uid)->select();
      if($follow) {
        $isFollow = true;
      } else {
        $isFollow =false;
      }
      $userInfo = Db::name('user')->where('uid',$uid)->select();
      if($userInfo) {
        $data = ['code' =>1,'msg'=>'success','data'=>$userInfo,'isFollow' =>$isFollow];
      } else {
        $data = ['code' =>0,'msg'=>'fail'];
      }
      echo json_encode($data);
    }
    
    // 关注用户 
    public function followUser() {
      $param = input('post.');
      $follUid =$param['follUid'];
      $uid = $param['uid'];
      // 用户关注数更新
      $user = Db::name('user')->where('uid',$uid)->select();
      $followNum = $user[0]['followNum'] + 1;
      // 被关注用户粉丝数更新 
      $follUser = Db::name('user')->where('uid',$follUid)->select();
      $fansNum = $follUser[0]['fansNum'] + 1;
      Db::table('user')->where('uid',$uid)->setField('followNum', $followNum);
      Db::table('user')->where('uid',$follUid)->setField('fansNum', $fansNum);
      $result = Db::name('follow')->insert($param);
      if($result) {
        $data = ['code' =>1,'msg'=>'success'];
      } else {
        $data = ['code' =>0,'msg'=>'fail'];
      }
      echo json_encode($data);
    }
    
    // 取消关注
    public function cancelFollowUser() {
      $uid = input('post.uid');
      $follUid = input('post.follUid');
       // 用户关注数更新
       $user = Db::name('user')->where('uid',$uid)->select();
       $followNum = $user[0]['followNum'] - 1;
       // 被关注用户粉丝数更新 
       $follUser = Db::name('user')->where('uid',$follUid)->select();
       $fansNum = $follUser[0]['fansNum'] - 1;
       Db::table('user')->where('uid',$uid)->setField('followNum', $followNum);
       Db::table('user')->where('uid',$follUid)->setField('fansNum', $fansNum);
      $result = Db::table('follow')->where('uid',$uid)->where('follUid',$follUid)->delete();
      if($result) {
        $data = ['code' =>1,'msg'=>'success'];
      } else {
        $data = ['code' =>0,'msg'=>'fail'];
      }
      echo json_encode($data);
    }
    
    // 获取关注用户列表
    public function getFollowUserList() {
      $uid = input('post.uid');
      $users = Db::name('follow')->where('uid',$uid)->select();
      if($users) {
        $data = ['code' =>1,'msg' => 'success','data' =>$users];
      } else {
        $data = ['code' =>0,'msg' => 'fail'];
      }
      echo json_encode($data);
    }

    // 添加历史查看记录
    public function addHistoryLookList() {
      $param = input('post.');
      $uid = $param['uid'];
      $goodsId = $param['goodsId'];
      $lookNum = $param['lookNum'] + 1;
      // 浏览次数更新
      Db::name('goods')->where('goodsId',$goodsId)->update(['lookNum' => $lookNum]);
      $alreadyHave = Db::name('history')->where('uid',$uid)->where('goodsId',$goodsId)->select();
      if(!$alreadyHave) {
        $result = Db::name('history')->insert($param);
        if($result) {
          $data = ['code' =>1 ,'msg' =>'success'];
          echo json_encode($data);
        } else {
          $data = ['code' =>0 ,'msg' =>'fail'];
          echo json_encode($data);
        }
      } else {
        $data = ['code' =>0 ,'msg' =>'fail'];
          echo json_encode($data);
      }
    }

    // 查询历史查看记录
    public function getHistoryLookList() {
      $uid = input('post.uid');
      $historyList = Db::name('history')->where('uid',$uid)->select();
      if($historyList) {
        $data = ['code'=>1,'msg'=>'success','data'=>$historyList];
      } else {
        $data = ['code' =>0,'msg'=>'fail'];
      }
      echo json_encode($data);
    }

    // 获取活动列表
    public function getActivityList() {
      $result = Db::name('activity')->select();
      if($result) {
        $data = ['code' =>1, 'msg' => 'success', 'data' =>$result];
      } else {
        $data = ['code' =>0,'msg'=>'fail'];
      }
      echo json_encode($data);
    }

    // 添加购物车
    public function addCar() {
      $params = input('post.');
      $uid = $params['uid'];
      $goodsId = $params['goodsId'];
      $hasAdd = Db::name('car')->where('uid',$uid)->where('goodsId',$goodsId)->select();
      if(!$hasAdd) {
        $result = Db::name('car')->insert($params);
        if($result) {
          $data = ['code'=>1,'msg'=>'success'];
          echo json_encode($data);
        } else {
          $data = ['code'=>0,'msg'=>'fail'];
          echo json_encode($data);
        }
      } else {
        $data = ['code'=>0,'msg'=>'fail'];
        echo json_encode($data);
      }
    }

    // 获取购物车列表
    public function getCarList() {
      $uid = input('post.uid');
      $result = Db::name('car')->where('uid',$uid)->select();
      if($result) {
        $data = ['code'=>1,'msg'=>'success','data'=>$result];
      } else {
        $data = ['code'=>0,'msg'=>'获取列表失败'];
      }
      echo json_encode($data);
    }

    // 删除购物车项
    public function deleteCarItem() {
      $uid = input('post.uid');
      $goodsId = input('post.goodsId');
      $result = Db::table('car')->where('uid',$uid)->where('goodsId',$goodsId)->delete();
      if($result) {
        $data = ['code'=>1,'msg'=>'success'];
      } else {
        $data = ['code'=>0,'msg'=>'fail'];
      }
      echo json_encode($data);
    }

    // 根据uid，goodsId获取下单信息
    public function getConfirmOrderInfo() {
      $uid = input('post.uid');
      $goodsId = input('post.goodsId');
      $userData = Db::name('user')->where('uid',$uid)->select();
      $carData = Db::name('goods')->where('goodsId',$goodsId)->select();
      if($userData||$carData) {
        $data = ['code'=>1,'msg'=>'success','userData'=>$userData,'carData'=>$carData];
      } else {
        $data = ['code'=>0,'msg'=>'fail'];
      }
      echo json_encode($data);
    }

    // 添加订单信息
    public function addOrderInfo() {
      $params = input('post.');
      $result = Db::name('order')->insert($params);
      if($result) {
        $data = ['code'=>1,'msg'=>'success'];
      } else {
        $data = ['code'=>1,'msg'=>'fail'];
      }
      echo json_encode($data);
    }

    // 判断是否已经购买
    public function judgeBuy() {
      $uid = input('post.uid');
      $goodsId = input('post.goodsId');
      // 0买，1卖
      $status = 0;
      $result = Db::name('order')->where('uid',$uid)->where('goodsId',$goodsId)->where('status',$status)->select();
      if($result) {
        $data = ['code'=>1,'msg'=>'success'];
      } else {
        $data = ['code'=>0,'msg'=>'fail'];
      }
      echo json_encode($data);
    }

    // 删除发布信息
    public function deletePublishInfo() {
      $uid = input('post.pubUid');
      $goodsId = input('post.goodsId');
      $result = Db::table('goods')->where('uid',$uid)->where('goodsId',$goodsId)->delete();
      if($result) {
        $data = ['code'=>1,'msg'=>'success'];
      } else {
        $data = ['code'=>0,'msg'=>'fail'];
      }
      echo json_encode($data);
    }

    // 发布商品信息 
    public function publishGoods() {
      $params = input('post.');
      $result = Db::name('goods')->insert($params);
      if($result) {
        $data = ['code'=>1,'msg'=>'success'];
      } else {
        $data = ['code'=>0,'msg'=>'fail'];
      }
      echo json_encode($data);
    }

    // 分类、分页查询商品列表 没有传type查全部，0 ：电脑数码  1：户外运动  2：服饰鞋包 3：文具书籍 4：日用品
    public function getAllGoodsListByType() {
      $type = input('post.type');
      $page = input('post.page');
      if(!$page){
        $page = 1;
      }
      if($type!=0) {
        $goodsList = Db::name('goods')->where('type',$type)->where('status',1)->page($page,6)->select();
      } else {
        $goodsList = Db::name('goods')->where('status',1)->page($page,6)->select();
      }
      if($goodsList) {
        $data = ['code'=>1,'msg'=>'success','data'=>$goodsList];
      } else {
        $data = ['code'=>0,'msg'=>'没有商品更多信息了'];
      }
      echo json_encode($data);
    }

    // 关键词搜索
    public function searchByKey() {
      $key = input('post.key');
      $searchData = Db::table('goods')
      ->where('title|desc','like',"%{$key}%")
      ->where('status',1)
      ->select();
      if($searchData) {
        $data = ['code' =>1, 'msg'=>'success','data'=>$searchData];
      } else {
        $data = ['code'=>0,'msg'=>'没有相关商品内容'];
      }
      echo json_encode($data);
    }

    // 添加搜索历史
    public function addSearchHistory() {
      $params = input('post.');
      $key = $params['key'];
      $uid = $params['uid'];
      $has = Db::name('searchhistory')->where('key',$key)->where('uid',$uid)->select();
      if(!$has) {
        $result = Db::name('searchhistory')->insert($params);
        if($result) {
          $data = ['code'=>1,'msg'=>'success'];
          echo json_encode($data);
        } else {
          $data = ['code'=>1,'msg'=>'fail'];
          echo json_encode($data);
        }
      } else {
        $data = ['code'=>1,'msg'=>'fail'];
        echo json_encode($data);
      }
    }

    // 获取用户搜索历史记录
    public function getUserSearchHistory() {
      $uid = input('post.uid');
      $list = Db::name('searchhistory')->where('uid',$uid)->select();
      if($list) {
        $data = ['code'=>1,'msg'=>'success','data'=>$list];
      } else {
        $data = ['code'=>1,'msg'=>'fail'];
      }
      echo json_encode($data);
    }

    // 删除用户搜索历史
    public function deleteUserSearchHistory() {
      $uid = input('post.uid');
      $result = Db::table('searchhistory')->where('uid',$uid)->delete();
      if($result) {
        $data = ['code'=>1,'msg'=>'success'];
      } else {
        $data = ['code'=>1,'msg'=>'fail'];
      }
      echo json_encode($data);
    }

   

    // 管理员登录
    public function managelogin() {
      $name = input('post.name');
      $password = input('post.password');
      $managerInfo = Db::name('manager')->where('name',$name)->where('password',$password)->select();
      if($managerInfo) {
        $data = ['code'=>1,'msg'=>'登录成功'];
      } else {
        $data = ['code'=>0,'msg'=>'登录失败'];
      }
      echo json_encode($data);
    }

    // 查询所有用户信息
    public function getAllUserInfo() {
      $page = input('post.page');
      $pageSize = input('post.pageSize');
      $currentUser = Db::name('user')->page($page,$pageSize)->order('uid desc')->select();
      $allUser = Db::name('user')->select();
      $total = count($allUser); 
      if($currentUser) {
        $data = ['code' =>1,'msg'=>'success','data' =>$currentUser,'total'=>$total];
      } else {
        $data = ['code'=>0,'msg'=>'fail'];
      }
      echo json_encode($data);
    }

    //修改用户信息
    public function updateUserInfo() {
      $userName = input('post.userName');
      $telNum = input('post.telNum');
      $email = input('post.email');
      $uid = input('post.uid');
      if($userName!=null) {
        $r1 = Db::table('user')->where('uid',$uid)->update(['userName' => $userName]);
        $data = ['code'=>1,'success'];
      } else {
        $data = ['code'=>0,'msg'=>'fail'];
      }
      if($telNum!=null) {
        $r2 = Db::table('user')->where('uid',$uid)->update(['telNum' => $telNum]);
        $data = ['code'=>1,'success'];
      } else {
        $data = ['code'=>0,'msg'=>'fail'];
      }
      if($email!=null) {
        $r3 = Db::table('user')->where('uid',$uid)->update(['email' => $email]);
        $data = ['code'=>1,'success'];
      } else {
        $data = ['code'=>0,'msg'=>'fail'];
      }

      echo json_encode($data);
    }
    
    // 删除用户接口
    public function deleteUser() {
      $uid = input('post.uid');
      $result = Db::name('user')->where('uid',$uid)->delete();
      $userList = Db::name('user')->order('uid desc')->select();
      if($result) {
        $data = ['code'=>1,'msg'=>'success','data'=> $userList];
      } else {
        $data = ['code'=>0,'msg'=>'fail','data'=> $userList];
      }
      echo json_encode($data);
    }

    // 查询所有商品包括 审核和未审核， 条件查询（通过商品id，用户id，发布状态，类型）
    public function getAllGoods() {
      $page = input('post.page');
      $pageSize = input('post.pageSize');
      $goodsId = input('post.goodsId');
      $uid = input('post.uid');
      $status = input('post.status');
      $type = input('post.type');
      if($status=='0'||$status=='1'){
        $isTrue = true;
      } else {
        $isTrue = false;
      }
      
      if($goodsId && !$uid && !$status) {
        $result = Db::name('goods')->where('goodsId',$goodsId)->page($page,$pageSize)->order('goodsId desc')->select();
      } 
      if(!$goodsId && $uid && !$status){
        $result = Db::name('goods')->where('uid',$uid)->page($page,$pageSize)->order('goodsId desc')->select();
      }
      if(!$goodsId && !$uid &&$isTrue){
        $result = Db::name('goods')->where('status',$status)->page($page,$pageSize)->order('goodsId desc')->select();
      }
      if($goodsId && $uid && !$status){
        $result = Db::name('goods')->where('goodsId',$goodsId)->where('uid',$uid)->page($page,$pageSize)->order('goodsId desc')->select();
      }
      if(!$goodsId && $uid && $status){
        $result = Db::name('goods')->where('uid',$uid)->where('status',$status)->page($page,$pageSize)->order('goodsId desc')->select();
      }
      if($goodsId && !$uid && $status){
        $result = Db::name('goods')->where('goodsId',$goodsId)->where('status',$status)->page($page,$pageSize)->order('goodsId desc')->select();
      }
      if($goodsId && $uid && $status){
        $result = Db::name('goods')->where('uid',$uid)->where('goodsId',$goodsId)->where('status',$status)->order('goodsId desc')->page($page,$pageSize)->select();
      }
      if(!$goodsId && !$uid && !$isTrue){
        $result = Db::name('goods')->page($page,$pageSize)->order('goodsId desc')->select();
      }
      if($type) {
        $result = Db::name('goods')->where('type',$type)->page($page,$pageSize)->order('goodsId desc')->select();
      }
      $all =  Db::name('goods')->order('uid desc')->select();
      $total = count($all);
      if($result) {
        $data = ['code'=>1,'msg'=>'success','data'=>$result,'total'=>$total];
      } else {
        $data = ['code'=>0,'msg'=>'没有数据','data'=>[],'total'=>$total];
      }
      echo json_encode($data);
    }

    // 审核商品
    public function confirmGoods() {
      $goodsId = input('post.goodsId');
      $result = Db::table('goods')->where('goodsId',$goodsId)->setField('status', 1);
      $data = Db::name('goods')->where('status',0)->order('goodsId desc')->select();
      if($result) {
        $data = ['code'=>1,'msg'=>'success','data'=>$data];
      } else {
        $data = ['code'=>0,'msg'=>'fail','data'=>$data];
      }
      echo json_encode($data);
    }
    
    // 查询订单列表
    public function orderList() {
      $page = input('post.page');
      $pageSize = input('post.pageSize');
      $orderList = Db::name('order')->page($page,$pageSize)->order('oid desc')->select();
      $allList = Db::name('order')->select();
      $total = count($allList);
      if($orderList) {
        $data = ['code'=>1,'msg'=>'success','data'=>$orderList,'total'=>$total];
      } else {
        $data = ['code'=>0,'msg'=>'没有相关数据','data'=>[]];
      }
      echo json_encode($data);
    } 
     // 删除订单接口
     public function deleteOrder() {
      $oid = input('post.oid');
      $result = Db::name('order')->where('oid',$oid)->delete();
      $orderList = Db::name('order')->order('oid desc')->select();
      if($result) {
        $data = ['code'=>1,'msg'=>'success','data'=>$orderList];
      } else {
        $data = ['code'=>0,'msg'=>'fail','data'=>$orderList];
      }
      echo json_encode($data);
    }

    // 批量删除商品
    public function batchDeleteGoods () {
      $goodsIdArr = input('post.goodsIdArr/a');
      for($i=0;$i<sizeof($goodsIdArr);$i++){
        $result = Db::name('goods')->where('goodsId',$goodsIdArr[$i])->delete();
      }
       $goodsList = Db::name('goods')->order('goodsId desc')->select();
       if($result) {
        $data = ['code'=>1,'msg'=>'success','data'=>$goodsList];
      } else {
        $data = ['code'=>0,'msg'=>'fail','data'=>$goodsList];
      }
      echo json_encode($data);
    }

    // 获得所有评论
    public function getComment() {
      $page = input('post.page');
      $pageSize = input('post.pageSize');
      $uid = input('post.uid');
      $goodsId = input('post.goodsId');
      if(!$uid && !$goodsId) {
        $commentList = Db::name('comment')->page($page,$pageSize)->order('id desc')->select();
      }
      if($uid && !$goodsId) {
        $commentList = Db::name('comment')->where('uid',$uid)->page($page,$pageSize)->order('id desc')->select();
      }
      if(!$uid && $goodsId) {
        $commentList = Db::name('comment')->where('goodsId',$goodsId)->page($page,$pageSize)->order('id desc')->select();
      }
      if($uid && $goodsId) {
        $commentList = Db::name('comment')->where('uid',$uid)->where('goodsId',$goodsId)->page($page,$pageSize)->order('id desc')->select();
      }

      $allComment = Db::name('comment')->select();
      $total = count($allComment);
      if($commentList) {
        $data = ['code'=>1,'msg'=>'success','data'=>$commentList,'total'=>$total];
      } else {
        $data = ['code'=>0,'msg'=>'没有相关数据','data'=>[]];
      }
      echo json_encode($data);
    }

    // 删除评论
    public function deleteComment() {
      $id = input('post.id');
      $result = Db::name('comment')->where('id',$id)->delete();
      $commentList = Db::name('comment')->order('id desc')->select();
      if($result) {
        $data = ['code'=>1,'msg'=>'success','data'=>$commentList];
      } else {
        $data = ['code'=>0,'msg'=>'fail','data'=>$commentList];
      }
      echo json_encode($data);
    }

    // 获得管理员信息
    public function getManagerInfo() {
      $page = input('post.page');
      $pageSize = input('post.pageSize');
      $managerList = Db::name('manager')->page($page,$pageSize)->select();
      $allManage = Db::name('manager')->select();
      $total = count($allManage);
      if($managerList) {
        $data = ['code'=>1,'msg'=>'success','data'=>$managerList,'total'=>$total];
      } else {
        $data = ['code'=>0,'msg'=>'没有数据'];
      }
      echo json_encode($data);
    }

    // 修改管理员信息
    public function updateManagerInfo() {
      $page = input('post.page');
      $pageSize = input('post.pageSize');
      $mid = input('post.mid');
      $name = input('post.name');
      $password = input('post.password');
      if($name) {
        Db::table('manager')->where('mid',$mid)->setField('name', $name);
      }
      if($password) {
        Db::table('manager')->where('mid',$mid)->setField('password', $password);
      }
      $managerList = Db::name('manager')->page($page,$pageSize)->select();
      $data = ['code'=>1,'msg'=>'success','data'=>$managerList];
      echo json_encode($data);
    }
    
    //新增管理员
    public function addManager() {
      $page = input('post.page');
      $pageSize = input('post.pageSize');
      $name = input('post.name');
      $password = input('post.password');
      $params = array('name'=>$name,'password'=>$password);
      $result = Db::name('manager')->insert($params);
      $managerList = Db::name('manager')->page($page,$pageSize)->select();
      $allManage = Db::name('manager')->select();
      $total = count($allManage);
      if ($result) {
        $data = ['code'=>1,'msg'=>'success','data'=>$managerList,'total'=>$total];
      } else {
        $data = ['code'=>0,'msg'=>'fail'];
      }
      echo json_encode($data);
    }

    // 删除管理员
    public function deleteManager() {
    $page = input('post.page');
    $pageSize = input('post.pageSize');
    $mid = input('post.mid');
    $result = Db::name('manager')->where('mid',$mid)->delete();
    $managerList = Db::name('manager')->page($page,$pageSize)->select();
    $allManage = Db::name('manager')->select();
    $total = count($allManage);
    if ($result) {
      $data = ['code'=>1,'msg'=>'success','data'=>$managerList,'total'=>$total];
    } else {
      $data = ['code'=>0,'msg'=>'fail'];
    }
    echo json_encode($data);
  }
}