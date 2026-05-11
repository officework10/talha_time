<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public $LoginUser;
	function __construct() {
        if (isset($_COOKIE['technical_calculator'])) {
            $login_id= $_COOKIE['technical_calculator'];
			$id = DB::table('login_table')->where('login_id',$login_id)->select('id')->first();
            if ($id) {
                $id=$id->id;
				$user = DB::table('admins')->where('admin_id',$id)->first();
                $this->LoginUser = (array)$user;
            }else{
                $this->LoginUser = '';
            }
        }else{
            $this->LoginUser = '';
        }
    }

    public function savePost($request,$id=null){
        if (is_null($id)) {
            $post_url=$request->post_url;
            $url_check = DB::table('posts')->where('post_url',$post_url)->first();
            if ($url_check) {
                return back()->with('status',"This url is alreay takken.");
            }
        }
        if (!empty($_FILES['post_img']['name'])) {
            $img_name=$_FILES['post_img']['name'];
            $type=$_FILES['post_img']['type'];
            $path=$_FILES['post_img']['tmp_name'];
            $dir='images/';
            $exp=explode('/', $type);
            if ($exp['0']!='image') {
                return back()->with('status',"Only Image can be uploded.");
            }
            $move=move_uploaded_file($path, $dir.$img_name);
            if (!$move) {
                return back()->with('status',"Image not uploded.");
            }
        }

        $show_hide=0;
		if (isset($request->show_hide)) {
			$show_hide=1;
		}
        $related_cal = null;
        if (isset($request->related_cal)) {
            $related_cal = json_encode($request->related_cal);
        }

        $data = array (
            "post_title" => htmlspecialchars($request->title , ENT_QUOTES),
            "post_des" => $request->des,
            "post_cat" => $request->cat,
            "post_url" => $request->post_url,
            "meta_title" => $request->meta_title,
            "short_des" => $request->short_des,
            "related_cal" => $related_cal,
			'show_hide'=> $show_hide,
            "meta_des" => $request->meta_des,
        );
        if (isset($img_name)) {
            $data['post_img'] = $img_name;
        }
        if (!is_null($id)) {
            $done = DB::table('posts')->where('post_id',$id)->update($data);
            $add = 'update';
        }else{
            $done = DB::table('posts')->insert($data);
            $add = 'add';
        }
        if($done){
                return back()->with('status',"Post $add Successfully.");
        }else{
            return back()->with('status',"<strong>Error!</strong> in post adding");
        }
    }

    public function addPost(Request $request){
        setcookie("technical_calculator-last" , $request->getRequestUri(), time()+24*3600*10 ,"/");
        if (!empty($this->LoginUser)) {
            if (isset($request->add_post)) {
				$data = $request->validate([
					'title' => 'required',
					'post_url' => 'required',
					'des' => 'required',
					'short_des' => 'required',
					'cat' => 'required',
					'meta_title' => 'required',
					'meta_des' => 'required',
					'post_img' => 'required',
				]);

				$this->savePost($request);
			}
            $calculators = DB::table('calculators')->where('is_calculator','Calculator')->select('cal_id','cal_title','cal_link','cal_cat')->get();
			return view('admin/temp/add-post',['calculators'=>$calculators,'LoginUser'=>$this->LoginUser]);
        }else{
            return redirect(url('admin/login/'));
        }
    }

    public function editPost($id,Request $request){
        setcookie("technical_calculator-last" , $request->getRequestUri(), time()+24*3600*10 ,"/");
        if (!empty($this->LoginUser)) {
            if (isset($request->add_post)) {
				$data = $request->validate([
					'title' => 'required',
					'post_url' => 'required',
					'des' => 'required',
					'short_des' => 'required',
					'cat' => 'required',
					'meta_title' => 'required',
					'meta_des' => 'required',
				]);

				$this->savePost($request,$id);
			}
            $post = DB::table('posts')->where('post_id',$id)->first();
            $calculators = DB::table('calculators')->where('is_calculator','Calculator')->select('cal_id','cal_title','cal_link','cal_cat')->get();
			return view('admin/temp/edit-post',['calculators'=>$calculators,'LoginUser'=>$this->LoginUser,'post'=>$post]);
        }else{
            return redirect(url('admin/login/'));
        }
    }

    public function posts(Request $request){
		setcookie("technical_calculator-last" , $request->getRequestUri(), time()+24*3600*10 ,"/");
		if (!empty($this->LoginUser)) {
			$posts = DB::table('posts')->where('is_del',0)->orderBy('post_id','DESC')->get();
			return view('admin/temp/posts',['posts'=>$posts,'LoginUser'=>$this->LoginUser]);
		}else{
			return redirect(url('admin/login/'));
		}
	}
    public function pending(Request $request){
		setcookie("technical_calculator-last" , $request->getRequestUri(), time()+24*3600*10 ,"/");
		if (!empty($this->LoginUser)) {
			$posts = DB::table('posts')->where('is_del',0)->orderBy('post_id','DESC')->get();
			return view('admin/temp/posts',['posts'=>$posts,'LoginUser'=>$this->LoginUser]);
		}else{
			return redirect(url('admin/login/'));
		}
	}
    public function deletePost($id){
        if (!empty($this->LoginUser)) {
			$posts = DB::table('posts')->where('post_id',$id)->update(['is_del'=>1]);
			return back()->with('status',"Post Delete Successfully.");
		}else{
			return redirect(url('admin/login/'));
		}
    }
    
}
