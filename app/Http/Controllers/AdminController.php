<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
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
	public function index(){
		if (!empty($this->LoginUser)) {
			return redirect('admin/dashboard');
		}else{
			return redirect('admin/login');
		}
	}

    public function dashboard() {
        if (empty($this->LoginUser)) {
            return redirect('admin/login');
        }

        $stats = [];

        // Calculators stats
        $stats['calculators'] = [
            'total' => DB::table('calculators')->where('is_calculator', 'Calculator')->count(),
            'normal' => DB::table('calculators')->where('is_calculator', 'Calculator')->where('cal_link', 'not like', '%/%')->count(),
            'language' => DB::table('calculators')->where('is_calculator', 'Calculator')->where('cal_link', 'like', '%/%')->count(),
            'indexed' => DB::table('calculators')->where('is_calculator', 'Calculator')->where('no_index', 1)->count(),
            'no_index' => DB::table('calculators')->where('is_calculator', 'Calculator')->where('no_index', 0)->count(),
        ];


        // Posts stats
        $stats['posts'] = [
            'total' => DB::table('posts')->where('is_del', 0)->count(),
            'indexed' => DB::table('posts')->where('is_del', 0)->where('show_hide', 1)->count(),
            'no_index' => DB::table('posts')->where('is_del', 0)->where('show_hide', 0)->count(),
        ];

        // Categories & Subcategories
        $stats['categories'] = DB::table('categories')->count();
        $stats['sub_categories'] = DB::table('sub_categories')->count();

        // Users
        $stats['users'] = [
            'total' => DB::table('admins')->count(),
            'active' => DB::table('admins')->count(), 
            'inactive' => 0,
        ];

        // Responses
        $stats['responses'] = DB::table('user_responses')->count();

        // Images count
        $imagePath = public_path('images');
        $stats['images'] = is_dir($imagePath) ? count(array_diff(scandir($imagePath), ['.', '..'])) : 0;

        return view('admin.dashboard', ['stats' => $stats, 'LoginUser' => $this->LoginUser]);
    }
    public function login(Request $request){
	   
    	if (isset($request->submit)) {


    		$request->validate([
			    'name' => 'required',
			    'pass' => 'required',
			]);


			$name=$request->name;
			$password=$request->pass;
			$user = DB::table('admins')->where([
                ['admin_name',$name],['admin_pass',$password]
            ])->first();
			
            if ($user) {
				$adminId = $user->admin_id;
				$login_id=md5($name.time());
				$data['login_id']=$login_id;
				$data['id']=$adminId;
                DB::table('login_table')->insert($data);
				// dd($login_id);

				setcookie("technical_calculator" , $login_id , time()+24*3600 ,"/", "", true, true);
                if (isset($_COOKIE['technical_calculator-last'])) {
					$last=$_COOKIE['technical_calculator-last'];
					return redirect($last);
				}else{
					return redirect('admin/calculators');
				}
            }else{
                return back()->with('admin_error',"User name or password not correct!");
            }
    	}else{
    		return view('admin/login');
    	}
    }

	public function logout(){
		$id=$this->LoginUser['admin_id'];
		//dd($id);
		DB::table('login_table')->where('id',$id)->delete();
		setcookie("technical_calculator" , 'logout' , time()-1 ,"/");
		// return redirect(url()->to('admin/login-admin'));
		return redirect('admin/login');
	}


	function slugify_string($text) {
		// replace non letter or digits by -
		$text = str_replace("'", '', $text);
		$text = str_replace("?", '', $text);
		$text = str_replace("%", '', $text);
		$text = str_replace(" ", '-', $text);
		$text = preg_replace('~[^\pL\d]+~u', '-', $text);
		// transliterate
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
		// remove unwanted characters
		$text = preg_replace('~[^-\w]+~', '', $text);
		// trim
		$text = trim($text, '-');
		// remove duplicate -
		$text = preg_replace('~-+~', '-', $text);
		// lowercase
		$text = strtolower($text);
		if (empty($text)) {
			return 'n-a';
		}
		return $text;
	}
	function Combine($array1, $array2) {
		if(count($array1) == count($array2)) {
			$assArray = array();
			for($i=0;$i<count($array1);$i++) {
				if (!empty($array1[$i]) && !empty($array2[$i])) {
					$assArray[$array1[$i]] = ($array2[$i]);
				}
			}
			return $assArray;
		}else{
			// $check=false;
		}
	}
	public function saveCalculator($request,$id=null){
		$keysname=$request->keyname;
		$keyvalues=$request->keyvalue;
		$check=true;
		$key_values=$this->Combine($keysname,$keyvalues);
		$key_values=json_encode($key_values);
		// foreach ($_POST as $key => $value) {
		// 	if (empty($value)) {
		// 		if($key!='cal_des' && $key!='parent' && $key!='cal_cat' && $key!='count_rel' && $key!='TOC'){
		// 			$check=false;
		// 		}
		// 	}
		// }

		$desktop_ad = array();
		$mobile_ad = array();
		$noindex=0;
		if (isset($request->noindex)) {
			$noindex=1;
		}
		$show_hide=0;
		if (isset($request->show_hide)) {
			$show_hide=1;
		}

		if (is_null($id)) {
			$cal_link=$request->cal_url;
			// Sanitize cal_link: remove blade tags and leading/trailing slashes
			$cal_link = preg_replace('/\{\{.*?\}\}/', '', $cal_link);
			$cal_link = trim($cal_link, '/');
			
			$url_check = DB::table('calculators')->where('cal_link',$cal_link)->first();
			if ($url_check) {
				return back()->with('status',"This url is alreay takken.");
			}
		}
		

		if ($check=='true') {
			$cal_title=$request->cal_title;
			$cal_link=$request->cal_url;
			$is_calculator=$request->is_calculator;
			$cal_search=$request->cal_search;
			$meta_title=$request->meta_title;
			$meta_des=$request->meta_des;
			$cal_des=$request->cal_des;
			if (!empty($request->parent)){
				$parent=$request->parent;
			}else{
				$parent=$request->cal_title;
			}
			$cal_cat=$request->cal_cat;

			$is_show=0;
			if (isset($request->is_show)) {
				$is_show=1;
			}
			$cal_sub_cat=$request->cal_sub_cat;
			
		
			if ($is_calculator==='Calculator') {
				$related_cal = $request->related_cal ?? [];
			}else{
				$related_cal = $request->related_cal ?? [];
			}
			$more = DB::table('calculators')->select('cal_link','cal_title','cal_cat','no_index')->where('cal_cat',$cal_cat)->limit(13)->get();
			$related_cal['more']=$more;
			$related_cal=json_encode($related_cal);
			if(isset($request->cal_sub_cat)){
				$cal_sub_cat = $cal_sub_cat;
			}else{
				$cal_sub_cat = 0;
			}
			$data_array = array(
				'cal_title' => $cal_title,
				'cal_link' => $cal_link,
				'cal_detail' => $cal_des,
				'meta_title' => $meta_title,
				'meta_des'=> $meta_des,
				'content'=> $request->content,
				'lang_keys' => $key_values,
				'cal_sub_cat'=> $cal_sub_cat,
				'show_hide'=> $show_hide,
				'no_index' => $noindex,
				'related_cal' => $related_cal,
				'cal_cat' => $cal_cat,
				'parent' => $parent,
				'is_show' => $is_show,
				'is_calculator' => $is_calculator,
			);
			if (!is_null($id)){
				$done = DB::table('calculators')->where('cal_id',$id)->update($data_array);
			}else{
				// dd($data_array);
				$done = DB::table('calculators')->insert($data_array);
			}
			if ($done) {
				if (!is_null($id)){
					$add = 'Update';
				}else{
					$add = 'Add';
				}
				return back()->with('status',"Calculator $add Successfully.");
			} else {
				return back()->with('status',"Nothing to Update here");
			}
		} else {
			return back()->with('status',"Please fill all fields.");
		}
	}

	public function addCalculator(Request $request){
		setcookie("technical_calculator-last" , $request->getRequestUri(), time()+24*3600*10 ,"/");
		if (!empty($this->LoginUser)) {
			if (isset($request->add_calculator)) {
				$data = $request->validate([
					'cal_cat' => 'required',
					'cal_title' => 'required',
					'cal_url' => 'required',
					'meta_title' => 'required',
					'meta_des' => 'required',
					// 'cal_sub_cat' => 'required',
				]);

				$this->saveCalculator($request);
			}
			$parent = DB::table('calculators')->where('is_calculator','Calculator')->select('cal_id','cal_title','cal_link','cal_cat')->get();
			$get_cats = DB::table('categories')->select('cat_id', 'cat_name', 'is_del', 'cat_time')->get();
			$get_subcats = DB::table('sub_categories')->select('cat_id', 'cat_name', 'cat_parent', 'cat_time')->get();
			return view('admin/temp/index',['parent'=>$parent,'get_cats'=>$get_cats,'get_subcats'=>$get_subcats,'LoginUser'=>$this->LoginUser]);

		}else{
			return redirect(url('admin/login/'));
		}
	
	}

	public function editCalculator($id,Request $request){
		setcookie("technical_calculator-last" , $request->getRequestUri(), time()+24*3600*10 ,"/");
		if (!empty($this->LoginUser)) {
			if (isset($request->add_calculator)) {
				$data = $request->validate([
					'cal_cat' => 'required',
					'cal_title' => 'required',
					'cal_url' => 'required',
					'meta_title' => 'required',
					'meta_des' => 'required',  
					// 'cal_sub_cat' => 'required',
				]);
				$this->saveCalculator($request,$id);
			}
			$page = DB::table('calculators')->where('cal_id',$id)->first();
			$get_sub = null;
			$get_subcats = collect();

			if(!empty($page->cal_sub_cat)){
				$get_sub = DB::table('sub_categories')->select('cat_id', 'cat_name', 'cat_parent', 'cat_time')->where('cat_id',$page->cal_sub_cat)->first();
				if ($get_sub) {
					$get_subcats = DB::table('sub_categories')->select('cat_id', 'cat_name', 'cat_parent', 'cat_time')->where('cat_parent',$get_sub->cat_parent)->get();
				}
			}

			if (!$get_sub) {
				$categories = DB::table('categories')->select('cat_id', 'cat_name', 'is_del', 'cat_time')->where('cat_name',$page->cal_cat)->first();
				if ($categories) {
					$get_subcats = DB::table('sub_categories')->select('cat_id', 'cat_name', 'cat_parent', 'cat_time')->where('cat_parent',$categories->cat_id)->get();
				}
				$get_sub = DB::table('sub_categories')->select('cat_id', 'cat_name', 'cat_parent', 'cat_time')->where('cat_parent', 0)->first();
			}
			$parent = DB::table('calculators')->where('is_calculator','Calculator')->select('cal_id','cal_title','cal_link','cal_cat')->get();
			$get_cats = DB::table('categories')->select('cat_id', 'cat_name', 'is_del', 'cat_time')->get();
			return view('admin/temp/edit-calculator',['page'=>$page,'parent'=>$parent,'get_cats'=>$get_cats,'get_subcats'=>$get_subcats,'LoginUser'=>$this->LoginUser , 'subcategor_id'=>$page->cal_sub_cat ,'cal_cat'=>$page->cal_cat , 'get_sub'=>$get_sub]);
		}else{
			return redirect(url('admin/login/'));
		}
	}


    public function approve($id,Request $request){
		return back()->with('status',"Method not supported.");
	}


	public function calculators(Request $request){
		setcookie("technical_calculator-last" , $request->getRequestUri(), time()+24*3600*10 ,"/");
		if (!empty($this->LoginUser)) {
			// $checking = DB::table('calculators')
			// ->select('cal_img','cal_title','cal_link','meta_title','meta_des','lang_keys','parent','no_index','related_cal','cal_cat','desktop_ad','mobile_ad','is_calculator','mathjax','TOC','is_same','content')->get();
			// foreach ($checking as $key => $value) {
			// 	$file = str_replace('/','-',$value->cal_link);	
			// 	file_put_contents("keys/".$file.".txt", json_encode($value));
			// }
			// $get_cal = DB::table('calculators')->select('cal_link','cal_id')->get();
			// foreach ($get_cal as $key => $value) {
			// 	$post_name = $value->cal_link;
			// 	$post_name = str_replace('/','-',$post_name);
			// 	$content = DB::table('wp_posts')->select('post_content')->where('post_name',$post_name)->first();
			// 	if (!is_null($content)) {
			// 		echo $value->cal_id.'<br>';
			// 		$id = $value->cal_id;
			// 		$data_array['content'] = $content->post_content;
			// 		$done = DB::table('calculators')->where('cal_id',$id)->update($data_array);
			// 	}
			// }
			$is = 'Calculator';
			$get_cal = DB::table('calculators')->where('is_calculator',$is)->select('parent','cal_title','is_calculator','cal_id','cal_link','cal_cat','show_hide','no_index')->get();
			$total = DB::table('calculators')->select('parent')->groupBy('parent')->where('is_calculator',$is)->get()->count();
			// Health count All 1
			$healthcount = DB::table('calculators')->select('parent')->groupBy('parent')->where('is_calculator',$is)->where('cal_cat','Health')->get()->count();
			// Math count All 2
			$mathcount = DB::table('calculators')->select('parent')->groupBy('parent')->where('is_calculator',$is)->where('cal_cat','Math')->get()->count();
				// Everyday-Life count All 3
				$everydayLifecount = DB::table('calculators')->select('parent')->groupBy('parent')->where('is_calculator',$is)->where('cal_cat','Everyday-Life')->get()->count();
				// Finance count All 4
				$financecount = DB::table('calculators')->select('parent')->groupBy('parent')->where('is_calculator',$is)->where('cal_cat','Finance')->get()->count();
				// Physics count All 5
	     	$physicscount = DB::table('calculators')->select('parent')->groupBy('parent')->where('is_calculator',$is)->where('cal_cat','Physics')->get()->count();
			// Chemistry count All 6
			$chemistrycount = DB::table('calculators')->select('parent')->groupBy('parent')->where('is_calculator',$is)->where('cal_cat','Chemistry')->get()->count();
			
			// statistics count All 7
			$statisticscount = DB::table('calculators')->select('parent')->groupBy('parent')->where('is_calculator',$is)->where('cal_cat','Statistics')->get()->count();
			// Construction count All 8
			$Constructioncount = DB::table('calculators')->select('parent')->groupBy('parent')->where('is_calculator',$is)->where('cal_cat','Construction')->get()->count();
					// Pets count All 9
			$petscount = DB::table('calculators')->select('parent')->groupBy('parent')->where('is_calculator',$is)->where('cal_cat','Pets')->get()->count();
					// Timedate count All 10
			$timedatecount = DB::table('calculators')->select('parent')->groupBy('parent')->where('is_calculator',$is)->where('cal_cat','Timedate')->get()->count();
			
			// Index count All 1
			$indexcount = DB::table('calculators')->select('parent')->groupBy('parent')->where('is_calculator',$is)->where('no_index', 1)->get()->count();

			// noindex count All 0
			$noindexcount = DB::table('calculators')->select('parent')->groupBy('parent')->where('is_calculator',$is)->where('no_index', 0)->get()->count();


			return view('admin/temp/all-calculators',['pages'=>$get_cal,'is'=> $is,'LoginUser'=>$this->LoginUser,'total'=>$total,'healthcount'=>$healthcount,'mathcount'=>$mathcount,'everydayLifecount'=>$everydayLifecount,'financecount'=>$financecount,'physicscount'=>$physicscount,'chemistrycount'=>$chemistrycount,'statisticscount'=>$statisticscount,'Constructioncount'=>$Constructioncount,'petscount'=>$petscount,'timedatecount'=>$timedatecount,'indexcount'=>$indexcount,'noindexcount'=>$noindexcount]);
		}else{
			return redirect(url('admin/login/'));
		}
	}

	public function media(Request $request){
		setcookie("technical_calculator-last" , $request->getRequestUri(), time()+24*3600*10 ,"/");
		if (!empty($this->LoginUser)) {
			if (isset($request->upload)) {
				// dd($request);
				if (!empty($_FILES['image']['name'])) {
					$img_name=$_FILES['image']['name'];
					$path=$_FILES['image']['tmp_name'];
					$dir = public_path('images/');
					if (!file_exists($dir)) {
						mkdir($dir, 0755, true);
					}
					$move = move_uploaded_file($path, $dir . $img_name);
					if ($move) {
						return back()->with('status',"Image uploded. Link=" .url('images/'.$img_name));
					} else {
						return back()->with('status',"Image not upload.");
					}
				}else{
					
					return back()->with('status',"Please select an image.");
				}
			}

			$folderPath = public_path('images');

			// Get all files in the folder
			$files = scandir($folderPath);
			return view('admin/temp/media',['files'=>$files,'LoginUser'=>$this->LoginUser]);
		}else{
			return redirect(url('admin/login/'));
		}
	}

	public function categories(Request $request){
		setcookie("technical_calculator-last" , $request->getRequestUri(), time()+24*3600*10 ,"/");
		if (!empty($this->LoginUser)) {
			// $get_cats = DB::table('categories')->where('is_del', 0)->select('cat_id', 'cat_name', 'is_del', 'cat_time')->get();
			$get_cats = DB::table('categories')->select('cat_id', 'cat_name', 'is_del', 'cat_time')->get();
			return view('admin/temp/all-categories',['cats'=>$get_cats,'LoginUser'=>$this->LoginUser]);
		}else{
			return redirect(url('admin/login/'));
		}
	}

	public function addCategory(Request $request){
		setcookie("technical_calculator-last" , $request->getRequestUri(), time()+24*3600*10 ,"/");
		if (!empty($this->LoginUser)) {
			$get_cats = DB::table('categories')
    ->select('cat_id', 'cat_name', 'img', 'is_del', 'cat_time')
    ->get();

	if (isset($request->addCategory)) {
		if (isset($request->cat_name)) {
			// Set is_del based on checkbox input
			$is_del = isset($request->is_del) ? 1 : 0;

			// Prepare data array to insert
				$data = [
					'cat_name' => $request->cat_name,
					'is_del' => $is_del,
				];

				// Check if category name already exists
				$name_check = DB::table('categories')->where('cat_name', $request->cat_name)->first();
				if ($name_check) {
					return view('admin/temp/add-category', [
						'cats' => $get_cats,
						'LoginUser' => $this->LoginUser,
						'error' => "This Category Name is already taken."
					]);
				}

				// Check if image is uploaded
				if (!empty($_FILES['img']['name'])) {
					$img_name = $_FILES['img']['name'];
					$type = $_FILES['img']['type'];
					$path = $_FILES['img']['tmp_name'];
					$dir = public_path('images/category/');
					if (!file_exists($dir)) {
						mkdir($dir, 0755, true);
					}
					$exp = explode('/', $type);

					// Validate the file type (must be an image)
					if ($exp[0] != 'image') {
						return back()->with('status', "Only images can be uploaded.");
					}

					// Generate a unique filename to prevent overwriting
					$unique_name = time() . '_' . $img_name;
					$move = move_uploaded_file($path, $dir . $unique_name);

					// Check if the image was successfully uploaded
					if (!$move) {
						return back()->with('status', "Image not uploaded.");
					}

					// Add the image path to the data array
					$data['img'] = $unique_name;
				} else {
					// Set a default image name if no image is uploaded
					$data['img'] = 'null';
				}

				// Insert the category into the database
				$done = DB::table('categories')->insert($data);

				// Fetch the updated category list
				$get_cats = DB::table('categories')
					->select('cat_id', 'cat_name', 'img', 'is_del', 'cat_time')
					->get();

				// Return the appropriate view based on success or failure
				if ($done) {
					return view('admin/temp/add-category', [
						'cats' => $get_cats,
						'LoginUser' => $this->LoginUser,
						'status' => "Category added successfully."
					]);
				} else {
					return view('admin/temp/add-category', [
						'cats' => $get_cats,
						'LoginUser' => $this->LoginUser,
						'error' => "Something went wrong."
					]);
				}
			} else {
				// Return an error if the category name is not provided
				return view('admin/temp/add-category', [
					'cats' => $get_cats,
					'LoginUser' => $this->LoginUser,
					'error' => "Please enter a category name."
				]);
			}
		}
			
			return view('admin/temp/add-category', [
				'cats' => $get_cats,
				'LoginUser' => $this->LoginUser
			]);
		}else{
			return redirect(url('admin/login/'));
		}
	}

	public function editCategory($id, Request $request)
{
    setcookie("technical_calculator-last", $request->getRequestUri(), time() + 24 * 3600 * 10, "/");

    if (!empty($this->LoginUser)) {
        // Fetch category details
        $cat_detail = DB::table('categories')->where('cat_id', $id)->first();
        $get_cats = DB::table('categories')
            ->select('cat_id', 'cat_name', 'is_del', 'cat_time')
            ->get();

        // If the form is submitted to update the category
        if (isset($request->updateCategory)) {
            if (isset($request->cat_name)) {
                $is_del = isset($request->is_del) ? 1 : 0;

                // Prepare data for update
                $data = [
                    'cat_name' => $request->cat_name,
                    'is_del' => $is_del,
                ];

                // Check if a new image is uploaded
                if (!empty($_FILES['img']['name'])) {
					$img_name = $_FILES['img']['name'];
					$type = $_FILES['img']['type'];
					$path = $_FILES['img']['tmp_name'];
					$dir = public_path('images/category/');
					$exp = explode('/', $type);
				
					// Validate the file type (must be an image)
					if ($exp[0] != 'image') {
						return back()->with('status', "Only images can be uploaded.");
					}
				
					// Generate a unique filename to prevent overwriting
					$unique_name = time() . '_' . $img_name;
				
					// Check if the old image exists before attempting to delete it
					if ($cat_detail->img != 'null' && !empty($cat_detail->img)) {
						$old_image_path = $dir . $cat_detail->img;
				
						// Ensure the old image exists in the folder
						if (file_exists($old_image_path)) {
							unlink($old_image_path); // Delete old image from directory
						}
					}
				
					// Move the new image to the directory
					$move = move_uploaded_file($path, $dir . $unique_name);
				
					// Check if the new image was successfully uploaded
					if (!$move) {
						return back()->with('status', "Image not uploaded.");
					}
				
					// Add the new image path to the data array
					$data['img'] = $unique_name;
				}
				

                // Update the category in the database
                $done = DB::table('categories')
                    ->where('cat_id', $id)
                    ->update($data);

                // Fetch the updated category list and the details of the current category
                $get_cats = DB::table('categories')
                    ->select('cat_id', 'cat_name', 'is_del', 'cat_time')
                    ->get();
                $cat_detail = DB::table('categories')->where('cat_id', $id)->first();

                // Check if the update was successful and return the appropriate response
                if ($done) {
                    return view('admin/temp/edit-category', [
                        'cats' => $get_cats,
                        'cat_detail' => $cat_detail,
                        'LoginUser' => $this->LoginUser,
                        'status' => "Category updated successfully."
                    ]);
                } else {
                    return view('admin/temp/edit-category', [
                        'cats' => $get_cats,
                        'cat_detail' => $cat_detail,
                        'LoginUser' => $this->LoginUser,
                        'error' => "Something went wrong."
                    ]);
                }
            } else {
                // Return an error if the category name is not provided
                return view('admin/temp/edit-category', [
                    'cats' => $get_cats,
                    'cat_detail' => $cat_detail,
                    'LoginUser' => $this->LoginUser,
                    'error' => "Please enter category name."
                ]);
            }
        }

        // Show the edit category page with category details
        return view('admin/temp/edit-category', [
            'cats' => $get_cats,
            'cat_detail' => $cat_detail,
            'LoginUser' => $this->LoginUser
        ]);
    } else {
        // If the user is not logged in, redirect to the login page
        return redirect(url('admin/login/'));
    }
	}

	public function deleteCategory($id, Request $request)
	{
		setcookie("technical_calculator-last", $request->getRequestUri(), time() + 24 * 3600 * 10, "/");

		if (!empty($this->LoginUser)) {
			// Retrieve the category details to get the image filename
			$cat_detail = DB::table('categories')->where('cat_id', $id)->first();

			// Check if the category has an associated image and delete it from the directory
			if ($cat_detail && $cat_detail->img != 'null' && !empty($cat_detail->img)) {
				$img_path = public_path('images/category/' . $cat_detail->img);
				// Ensure the image exists in the directory before attempting to delete it
				if (file_exists($img_path)) {
					unlink($img_path);  // Delete the image file from the directory
				}
			}

			// Delete the category from the database
			$done = DB::table('categories')
				->where('cat_id', $id)
				->delete();

			// Check if the deletion was successful
			if ($done) {
				return redirect()->back()->with('status', "Category deleted successfully.");
			} else {
				return redirect()->back()->with('error', "Something went wrong.");
			}
		} else {
			// Redirect to login page if the user is not logged in
			return redirect(url('admin/login/'));
		}
	}


	public function subCategories(Request $request){
		setcookie("technical_calculator-last" , $request->getRequestUri(), time()+24*3600*10 ,"/");
		if (!empty($this->LoginUser)) {    
				$get_cats = DB::table('sub_categories')->select('cat_id', 'cat_name', 'cat_parent', 'cat_time')->get();
				// $get_cats = DB::table('categories')
				// ->select('categories.cat_id as main_cat_id', 'categories.cat_name', 'categories.is_del', 'categories.cat_time', 
				// 		'sub_categories.cat_id as sub_cat_id', 'sub_categories.cat_name as sub_cat_name', 
				// 		'sub_categories.cat_parent', 'sub_categories.cat_time as sub_cat_time')
				// ->leftJoin('sub_categories', 'categories.cat_id', '=', 'sub_categories.cat_parent')
				// ->get();
				// dd($get_cats);
			return view('admin/temp/sub-categories',['cats'=>$get_cats,'LoginUser'=>$this->LoginUser]);
		}else{
			return redirect(url('admin/login/'));
		}
	}

	public function addsubCategories(Request $request){
		setcookie("technical_calculator-last" , $request->getRequestUri(), time()+24*3600*10 ,"/");
		if (!empty($this->LoginUser)) {
			$get_cats = DB::table('categories')->select('cat_id', 'cat_name', 'is_del', 'cat_time')->get();
			if (isset($request->subCategory)) {
				if(isset($request->cat_name)){
					$data = [
						'cat_name' => $request->cat_name,
						'cat_parent'   => $request->cat_parent,
					];
					$name_check = DB::table('sub_categories')->where('cat_name',$request->cat_name)->first();
					if ($name_check) {
						return view('admin/temp/add-sub-category', [
							'cats' => $get_cats,
							'LoginUser' => $this->LoginUser,
							'error' => "This Sub Category Name is alreay takken."
						]);
					}
					$done = DB::table('sub_categories')->insert($data);
					if (isset($done)) {
						return view('admin/temp/add-sub-category', [
							'cats' => $get_cats,
							'LoginUser' => $this->LoginUser,
							'status' => "Category added successfully."
						]);
					} else {
						return view('admin/temp/add-sub-category', [
							'cats' => $get_cats,
							'LoginUser' => $this->LoginUser,
							'error' => "Something went wrong."
						]);
					}
				}else{
					return view('admin/temp/add-sub-category', [
						'cats' => $get_cats,
						'LoginUser' => $this->LoginUser,
						'error' => "Please eneter category name."
					]);
				}
				
			}
			return view('admin/temp/add-sub-category', [
				'cats' => $get_cats,
				'LoginUser' => $this->LoginUser
			]);
		}else{
			return redirect(url('admin/login/'));
		}
	}

	public function deleteSubCategory($id,Request $request){
		setcookie("technical_calculator-last" , $request->getRequestUri(), time()+24*3600*10 ,"/");
		if (!empty($this->LoginUser)) {
			$done = DB::table('sub_categories')
			->where('cat_id', $id)
			->delete();
			if ($done) {
				return redirect()->back()->with('status', "Sub Category deleted successfully.");
			} else {
				return redirect()->back()->with('error', "Something went wrong.");
			}
		}else{
			return redirect(url('admin/login/'));
		}
	}

	public function editSubCategory($id,Request $request){
		setcookie("technical_calculator-last" , $request->getRequestUri(), time()+24*3600*10 ,"/");
		if (!empty($this->LoginUser)) {
			$cat_detail = DB::table('sub_categories')->where('cat_id',$id)->first();
			$get_cats = DB::table('categories')->select('cat_id', 'cat_name', 'is_del', 'cat_time')->get();
			if (isset($request->updateCategory)) {
				if(isset($request->cat_name)){
					$data = [
						'cat_name' => $request->cat_name,
						'cat_parent'   => $request->cat_parent,
					];
					$done = DB::table('sub_categories')
					->where('cat_id', $id)
					->update($data);
					$get_cats = DB::table('categories')
                    ->select('cat_id', 'cat_name', 'is_del', 'cat_time')
                    ->get();
					$cat_detail = DB::table('sub_categories')->where('cat_id',$id)->first();
					if (isset($done)) {
						return view('admin/temp/edit-sub-category', [
							'cats' => $get_cats,
							'cat_detail' => $cat_detail,
							'LoginUser' => $this->LoginUser,
							'status' => "Category updated successfully."
						]);
					} else {
						return view('admin/temp/edit-sub-category', [
							'cats' => $get_cats,
							'cat_detail' => $cat_detail,
							'LoginUser' => $this->LoginUser,
							'error' => "Something went wrong."
						]);
					}
				}else{
					return view('admin/temp/edit-sub-category', [
						'cats' => $get_cats,
						'cat_detail' => $cat_detail,
						'LoginUser' => $this->LoginUser,
						'error' => "Please eneter category name."
					]);
				}
				
			}
			return view('admin/temp/edit-sub-category', [
				'cats' => $get_cats,
				'cat_detail' => $cat_detail,
				'LoginUser' => $this->LoginUser
			]);
		}else{
			return redirect(url('admin/login/'));
		}
	}

	public function searchsubcategory(Request $request){

		$cat_parentid = $request->cal_id;
		setcookie("technical_calculator-last" , $request->getRequestUri(), time()+24*3600*10 ,"/");
		if (!empty($this->LoginUser)) {

			$categories = DB::table('categories')->select('cat_id', 'cat_name', 'is_del', 'cat_time')->where('cat_id', $cat_parentid)->first();
			$get_cats = DB::table('sub_categories')->select('cat_id', 'cat_name', 'cat_parent')->where('cat_parent', $cat_parentid)->get();
			// dd($get_cats);
			return response()->json([
				'status' => 'success',
				'data' => $get_cats,
				'categoriesName' => $categories->cat_name
			]);
			
		}else{
			return response()->json([
				'status' => 'error',
				'message' => 'User not logged in'
			]);
		}

	}



}
