<?php

namespace App\Http\Controllers;

use App\Models\Math;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Str;

class HomeController extends Controller
{
	public $device;
	public $forCurrency;
	public $ad_text;
	public $allcategories;
    protected $calculatorRepository;
    protected $userRepository;

	function __construct(\App\Repositories\Interfaces\CalculatorRepositoryInterface $calculatorRepository, \App\Repositories\Interfaces\UserRepositoryInterface $userRepository)
	{
        $this->calculatorRepository = $calculatorRepository;
        $this->userRepository = $userRepository;
		$useragent = $_SERVER['HTTP_USER_AGENT'] ?? '';
		if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))) {
			$this->device = "mobile";
		} else {
			$this->device = "desktop";
		}
		$this->forCurrency = [
			'time-calculator',
			'date-calculator',
		];
	}

	public function index()
	{
		$data['calculators'] = DB::table('calculators')->select('cal_cat','cal_title','is_calculator','cal_detail','cal_link','no_index')
					->where('is_calculator','Calculator')
					->get();
		$data['device'] = $this->device;
		$data['meta_title'] = 'Time Calculator Online - 100% Free, Reliable & Accurate';
		$data['meta_des'] = 'The 100% free and reliable online Time Calculator that help you solve any calculation-related problems and provide you with precise measurements.';

		$allcategories = DB::table('categories')->select('cat_name', 'is_del', 'img', 'cat_time', 'cat_id')->where('is_del', 0)->get();
		$this->allcategories = $allcategories;

		$posts = DB::table('posts')->where('is_del', 0)->where('show_hide', 1)->orderBy('post_id', 'DESC')->limit(3)->get();
	
		$data['posts'] = $posts;
		$data['device'] = $this->device;
		$data['allcategories'] = $this->allcategories;
		return view('pages/index', $data);
	}

	public function category($category)
	{
		// dd($category);
		if ($category == 'timedate') {
			$meta_title = 'Time & Date Calculators';
			$meta_des = 'Our All Timedate Calculators can be used to manage time and date related calculations. From time duration to date differences, streamline your daily tasks with precise and user-friendly tools that will save you time and effort.';
			$des = 'Plan your trips, schedule events, and understand different time zones with our collection of time and date calculators. By providing accurate time and date information, these calculator can help you stay informed. Calculating date differences, world time conversions, and countdowns are perfect for planning events and managing schedules effectively.';
		} elseif ($category == 'time') {
			$meta_title = 'Time  Calculators';
			$meta_des = 'Our All Timedate Calculators can be used to manage time and date related calculations. From time duration to date differences, streamline your daily tasks with precise and user-friendly tools that will save you time and effort.';
			$des = 'Plan your trips, schedule events, and understand different time zones with our collection of time and date calculators. By providing accurate time and date information, these calculator can help you stay informed. Calculating date differences, world time conversions, and countdowns are perfect for planning events and managing schedules effectively.';
		}
		// dd($category);
		$categoryID = DB::table('categories')
			->where('cat_name', $category)
			->pluck('cat_id')
			->first();

		$subCategoriesName = DB::table('sub_categories')
			->select('cat_id', 'cat_name', 'cat_parent')
			->where('cat_parent', $categoryID)
			->get();

		$all_calc = DB::table('calculators')
			->select('cal_cat', 'cal_sub_cat', 'cal_title', 'cal_link', 'parent')
			->where('is_show', 0)
			->where('no_index', 0)
			->where('cal_cat', $category)
			->get();


		$allcalculator = DB::table('calculators')
			->where('is_show', 0)
			->where('no_index', 0)
			->where('show_hide', 1)
			->get();



		$calculatorsWithoutSubCat = $all_calc->filter(function ($cal) {
			return empty($cal->cal_sub_cat);
		});

		$calculatorsGroupedBySubCat = $all_calc->groupBy('cal_sub_cat');

		$data['device'] = $this->device;
		$data['meta_title'] = $meta_title;
		$data['calculators'] = $allcalculator;
		$data['subCategoriesName'] = $subCategoriesName;
		$data['all_calc'] = $all_calc;
		$data['calculatorsWithoutSubCat'] = $calculatorsWithoutSubCat;
		$data['calculatorsGroupedBySubCat'] = $calculatorsGroupedBySubCat;
		$data['meta_des'] = $meta_des;
		$data['categoryID'] = $categoryID;
		$data['category'] = $category;
		$data['allcategories'] = $this->allcategories;
		$data['category_active'] = 1;
		$data['des'] = $des;
		// $data['calculators']=json_decode(file_get_contents('technical-online-calculators.txt'));
		// dd($data['all_calc']);
		return view('pages/category/index', $data);

		// dd($data);
		// if ($category=='health') {
		// return view('pages/category/health', $data);
		// }elseif($category=='math'){
		// 	return view('pages/category/math', $data);
		// }elseif($category=='physics'){
		// 	return view('pages/category/physics', $data);
		// }elseif($category=='chemistry'){
		// 	return view('pages/category/chemistry', $data);
		// }elseif($category=='statistics'){
		// 	return view('pages/category/statistics', $data);
		// }elseif($category=='finance'){
		// 	return view('pages/category/finance', $data);
		// }elseif($category=='everyday-life'){
		// 	return view('pages/category/everyday-life', $data);
		// }elseif($category=='construction'){
		// 	return view('pages/category/construction', $data);
		// }elseif($category=='pets'){
		// 	return view('pages/category/pets', $data);
		// }elseif($category=='timedate'){
		// 	return view('pages/category/timedate', $data);
		// }
	}



	public function showPageEN($url)
	{

		return $this->showPage($url);
	}

	public function showPage($url)
	{

		if (file_exists(public_path($url)) && is_file(public_path($url))) {
			return response()->file(public_path($url));
		}
		
		error_reporting(0);
		$request = request();
		$check = $_SERVER['REQUEST_URI'];

		$file = $url;

		$cal_data = DB::table('calculators')
			->select('cal_title','cal_link','meta_title','meta_des','parent','no_index','related_cal','cal_cat','is_calculator','content')
			->where('cal_link', $url)->first();

		// dd($cal_data);
		if (isset($cal_data)) {
			if (isset($request->submit)) {
				$fun_name = explode('-', $url);
				$fun = $fun_name[0];
				if ($url == 'time-to-decimal') {
					$fun = 'gas';
				} 

				$modelName = $cal_data->cal_cat;

				if ($modelName == 'Everyday-Life') {
					$modelName = 'EverydayLife';
				}

				if ($modelName == 'Timedate') {
					$detail = $this->calculatorRepository->calculate($request, $fun);
				} else {
					$modelClass = "App\Models\\$modelName";
					$modelInstance = new $modelClass();
					$detail = $modelInstance->$fun($request);
				}

				if (isset($detail['error'])) {
					$data['error'] = $detail['error'];
				} else {
					$data['detail'] = $detail;
				}
			}
			if (in_array($url, $this->forCurrency)) {
				$ip = '';
				if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
					$ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
				} elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
					$ip = $_SERVER['HTTP_CLIENT_IP'];
				} else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
					$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
				} else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
					$ip = $_SERVER['HTTP_X_FORWARDED'];
				} else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
					$ip = $_SERVER['HTTP_FORWARDED_FOR'];
				} else if (isset($_SERVER['HTTP_FORWARDED'])) {
					$ip = $_SERVER['HTTP_FORWARDED'];
				} else if (isset($_SERVER['REMOTE_ADDR'])) {
					$ip = $_SERVER['REMOTE_ADDR'];
				} else {
					$ip = 'UNKNOWN';
				}
				try {
					$response = file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip);

					if ($response === false) {
						$data['currancy'] = '$';
					}

					$dataArray = json_decode($response, true);
					$data['currancy'] = $dataArray["geoplugin_currencySymbol_UTF8"];
				} catch (\Exception $e) {
					$data['currancy'] = '$';
				}
				// $dataArray = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip),true);
				// $data['currancy']=$dataArray["geoplugin_currencySymbol_UTF8"];
			}
			if ($cal_data->no_index == "1") {
				$data['noindex'] = '<meta name="robots" content="noindex">';
			}
			$iphone = strpos($_SERVER['HTTP_USER_AGENT'] ?? '', "iPhone");
			$ipad = strpos($_SERVER['HTTP_USER_AGENT'] ?? '', "iPad");
			$ipod = strpos($_SERVER['HTTP_USER_AGENT'] ?? '', "iPod");
			$img_form = 'webp';
			if ($iphone || $ipad || $ipod  == true) {
				$img_form = 'png';
			}
			$related_raw = json_decode($cal_data->related_cal, true) ?? [];
			$related_ids = [];
			foreach ($related_raw as $key => $val) {
				if (is_numeric($val)) {
					$related_ids[] = $val;
				}
			}

			$related_objects = [];
			if (!empty($related_ids)) {
				$related_objects = DB::table('calculators')
					->whereIn('cal_id', $related_ids)
					->select('cal_id', 'cal_title', 'cal_link')
					->get()
					->keyBy('cal_id');
			}

			$related = [];
			foreach ($related_raw as $key => $val) {
				if ($key === 'more') {
					$related['more'] = $val;
					continue;
				}
				if (is_numeric($val) && isset($related_objects[$val])) {
					$obj = $related_objects[$val];
					$related[] = $obj->cal_title . '//' . $obj->cal_link; // Using double slash to signify resolved
				} else {
					$related[] = $val; // Keep old format for backward compatibility
				}
			}
			
			if (isset($related['more'])) {
				$data['more_cal'] = $related['more'];
			}
			$data['related'] = $related;
			// dd($cal_data->parent);
			$parent = $cal_data->parent;
			$short_parent = [
				// Health URLS
				"21-days-from-today",
			];
			$brudcum_parent = "";
			if (in_array($url, $short_parent)) {
				$url_parts = explode("-", $url);
				for ($i = 0; $i < count($url_parts); $i++) {
					if ($i === 0) {
						$brudcum_parent .= strtoupper($url_parts[$i]);
					} else {
						$brudcum_parent .= " " . ucwords($url_parts[$i]);
					}
				}
			} else {
				$url_convert = str_replace('-', ' ', $url);
				$brudcum_parent = ucwords($url_convert);
				if ($url === "weightloss-calculator") {
					$brudcum_parent = "Weight Loss Calculator";
				}
			}
			
			$data['brudcum_parent'] = $brudcum_parent;
			$data['cal_cat'] = $cal_data->cal_cat;
			$data['meta_title'] = $cal_data->meta_title;
			if ($lang == null && $url == 'tdee-calculator') {
				$data['meta_title'] = $cal_data->meta_title . ' 🔥';
			} elseif ($lang == null && $url == 'age-calculator') {
				$data['meta_title'] = $cal_data->meta_title . ' 📆';
			} elseif ($lang == null && $url == 'weightloss-calculator') {
				$data['meta_title'] = $cal_data->meta_title . ' 🏃';
			}

			$queryParams = $request->all();
			$baseUrl = url()->current();
			$queryString = http_build_query($queryParams);
			$shareURL = $baseUrl . '/?' . $queryString;
			$data['shareURL'] = $shareURL;

			$data['brudcum_parent'] = $brudcum_parent;
			$data['cal_cat'] = $cal_data->cal_cat;
			$data['meta_title'] = $cal_data->meta_title;
			$data['cal_name'] = $cal_data->cal_title;
			$data['cal_detail'] = $cal_data->cal_detail;
			$data['content'] = $cal_data->content;
			$data['meta_des'] = $cal_data->meta_des;
			$data['cal_data'] = $cal_data;
			$data['file'] = $file;
			$data['device'] = $this->device;
			$data['parent'] = $parent;
			$data['type'] = 'calculator';


			// if ($url=='calculate-age') {
			// 	$data['page']='age-calculator';
			// }else{
			$data['page'] = $url;
			// }
			
			$data['is_calculator'] = $cal_data->is_calculator;

			if (isset($cal_data->is_calculator)) {
				if ($cal_data->is_calculator == 'Calculator') {
					$componentPath = 'App\\Livewire\\Calculators\\' . str_replace('-', '', ucwords($data['page'], '-'));
					
					if (!class_exists($componentPath)) {
						return redirect('/'); // fallback to homepage
					}
					return view('calculator', $data);
				} else {
					return redirect(url('/'));
				}
			}
		} else {
			return redirect(url('/'));
		}
	}


	public function search(Request $request)
	{
		//dd($request->search_cal);
		if (isset($request->search_cal)) {
			$keys = trim($request->search_cal);
			$main = trim($request->search_cal);
			$keys = strtolower($keys);
			$keys = str_replace('calculator', '', $keys);
			$keys = str_replace('converter', '', $keys);

			$first = DB::table('calculators')
				->select('cal_title', 'meta_title', 'meta_des', 'cal_cat', 'cal_link', 'is_calculator')
				->where('cal_title', $main)
				->orWhere('cal_title', $main)
				->orWhere('meta_title', $main)
				->orWhere('meta_des', $main)
				->get()
				->toArray();

			$second = DB::table('calculators')
				->select('cal_title', 'meta_title', 'meta_des', 'cal_cat', 'cal_link', 'is_calculator')
				->where('cal_title', 'like', '%' . $main)
				->orWhere('cal_title', 'like', '%' . $keys)
				->orWhere('meta_title', 'like', '%' . $keys)
				->orWhere('meta_des', 'like', '%' . $keys)
				->get()
				->toArray();
			// Merge the two arrays
			$result = array_merge($first, $second);

			$query = DB::table('calculators')
				->select('cal_title', 'meta_title', 'meta_des', 'cal_cat', 'cal_link', 'is_calculator')
				->where('cal_title', 'like', '%' . $main);

			// Explode keys and build query dynamically
			$keysArray = explode(' ', $keys);
			foreach ($keysArray as $key => $value) {
				if ((count($keysArray) - 1) != $key) {
					$query->orWhere('cal_title', 'like', '%' . $value . ' ' . $keysArray[$key + 1]);
					$query->orWhere('meta_title', 'like', '%' . $value . ' ' . $keysArray[$key + 1]);
					$query->orWhere('meta_des', 'like', '%' . $value . ' ' . $keysArray[$key + 1]);
				}
			}
			$get2 = $query->get()->toArray();
			$get1 = array_merge($result, $get2);
			function multi_unique($src)
			{
				$output = array_map(
					"unserialize",
					array_unique(array_map("serialize", $src))
				);
				return $output;
			}
			$get = multi_unique($get1);
			if (app()->getLocale() != 'en') {
				foreach ($get as $key => $value) {
					$url = $value['cal_link'];
					$checkUrl = explode('/', $url);
					if (count($checkUrl) > 1 && $checkUrl[0] == app()->getLocale()) {
						$link = $value->cal_link;
					}
				}
			} else {
				$link = $get[0]->cal_link;
			}

			$related = DB::table('calculators')
				->select('related_cal')
				->where('cal_link', $link)
				->first();
			$data['related'] = json_decode($related->related_cal, true);
			$data['results'] = $get;
			$data['keys'] = $keys;
			$data['main'] = $main;
			$data['noindex'] = '<meta name="robots" content="noindex">';
			$data['device'] = $this->device;
			$data['meta_title'] = "Search Result";
			$data['meta_des'] = __('menu_lang.des');
			$data['page'] = 'search';
			return view('search', $data);
		}
	}
	public function about()
	{
		$data['device'] = $this->device;
		$data['meta_title'] = "About Us - thetime-calculator.com";
		$data['meta_des'] = "Learn more about thetime-calculator.com and our mission to provide accurate tools.";
		$data['page'] = 'about-us';
		return view('pages/about', $data);
	}

	// public function team(){
	// 	$data['device']=$this->device;
	// 	$data['meta_title']="Our Team - thetime-calculator.com";
	// 	$data['meta_des']="Our Team - thetime-calculator.com";
	// 	$data['page'] = 'our-team';
	// 	return view('pages/team',$data);
	// }
	
	public function editorial_Policies()
	{
		$data['device'] = $this->device;
		$data['meta_title'] = "Editorial Policies - thetime-calculator.com";
		$data['meta_des'] = "Our editorial guidelines and commitment to accuracy.";
		$data['page'] = 'privacy-policy';
		return view('pages/editorial', $data);
	}
	public function policy()
	{
		$data['device'] = $this->device;
		$data['meta_title'] = "Privacy Policy - thetime-calculator.com";
		$data['meta_des'] = "Your privacy is important to us. Read our privacy policy.";
		$data['page'] = 'privacy-policy';
		return view('pages/policy', $data);
	}
	public function terms()
	{
		$data['device'] = $this->device;
		$data['meta_title'] = "Terms of Service - thetime-calculator.com";
		$data['meta_des'] = "Read our terms and conditions for using thetime-calculator.com.";
		$data['page'] = 'terms-of-service';
		return view('pages/terms', $data);
	}
	public function disclaimer()
	{
		$data['device'] = $this->device;
		$data['meta_title'] = "Content Disclaimer - thetime-calculator.com";
		$data['meta_des'] = "Read our content disclaimer regarding the accuracy of information.";
		$data['page'] = 'content-disclaimer';
		return view('pages/disclaimer', $data);
	}
	// public function testimonials(){
	// 	$data['device']=$this->device;
	// 	$data['meta_title']="Testimonials - thetime-calculator.com";
	// 	$data['meta_des']="Testimonials - thetime-calculator.com";
	// 	$data['page'] = 'testimonials';
	// 	return view('pages/testimonials',$data);
	// }
	public function feedback()
	{
		$data['device'] = $this->device;
		$data['meta_title'] = "Feedback - thetime-calculator.com";
		$data['meta_des'] = "We value your feedback. Let us know how we can improve.";
		$data['page'] = 'testimonials';
		return view('pages/feedback', $data);
	}



	public function allcalculators()
	{
		$data['device'] = $this->device;
		$data['meta_title'] = "All Calculators - thetime-calculator.com";
		$data['meta_des'] = "All Calculators - thetime-calculator.com";
		$data['page'] = 'All Calculators';

		$allcategories = DB::table('categories')->select('cat_name', 'is_del', 'img', 'cat_time', 'cat_id')->where('is_del', 0)->get();
		$this->allcategories = $allcategories;
		$data['allcategories'] = $this->allcategories;
		return view('pages/all_calculators', $data);
	}




	public function allcategory()
	{
		$data['device'] = $this->device;
		$data['meta_title'] = "All Category - thetime-calculator.com";
		$data['meta_des'] = "All Category - thetime-calculator.com";
		$data['page'] = 'All Category';

		$allcategories = DB::table('categories')->select('cat_name', 'is_del', 'img', 'cat_time', 'cat_id')->where('is_del', 0)->get();
		$this->allcategories = $allcategories;

		$posts = DB::table('posts')->where('is_del', 0)->where('show_hide', 1)->orderBy('post_id', 'DESC')->limit(3)->get();

		$data['posts'] = $posts;
		$data['device'] = $this->device;
		$data['allcategories'] = $this->allcategories;
		return view('pages/all_category', $data);
	}

	public function faq()
	{
		$data['device'] = $this->device;
		$data['meta_title'] = "faq - thetime-calculator.com";
		$data['meta_des'] = "faq - thetime-calculator.com";
		$data['page'] = 'faq';


		return view('pages/faq', $data);
	}


	public function contact(Request $request)
	{


		if (isset($request['send'])) {
			if (!empty($request['name']) && !empty($request['email']) && !empty($request['subject']) && !empty($request['msg'])) {
				$name = $request['name'];
				$email = $request['email'];
				$subject = $request['subject'] . ' (Calculator Logical)';
				$msg = $request['msg'];
				$to_email = 'ranazaidmunawar106@gmail.com';
				Mail::send(
					'email/contact',
					[
						'name'    => $name,
						'email'   => $email,
						'subject' => $subject,
						'comment' => $msg,
					],
					function ($message) use ($request) {
						$message->from($request->email);
						$message->to('ranazaidmunawar106@gmail.com');
						$message->replyTo($request->email)
							->subject('Calculator Logical Contact Form (' . $request['subject'] . ')');
					}
				);
				$data['done'] = 'Thanks for Contact us. Our team will come back to you as soon as possible.';
			} else {
				$data['error'] = "Please! Check Your Input";
			}
		}
		$data['device'] = $this->device;
		$data['meta_title'] = "Contact Us - thetime-calculator.com";
		$data['meta_des'] = "Have questions or feedback? Contact thetime-calculator.com team.";
		$data['page'] = 'contact-us';
		return view('pages/contact', $data);
	}


	public function feedback_email(Request $request)
	{

		if (isset($request['send'])) {
			if (!empty($request['name']) && !empty($request['email']) && !empty($request['subject']) && !empty($request['msg'])) {
				$name = $request['name'];
				$email = $request['email'];
				$subject = $request['subject'] . ' (Calculator Logical)';
				$msg = $request['msg'];
				$to_email = 'ranabilalmunawar122@gmail.com';
				Mail::send(
					'email/contact',
					[
						'name'    => $name,
						'email'   => $email,
						'subject' => $subject,
						'comment' => $msg,
					],
					function ($message) use ($request) {
						$message->from($request->email);
						$message->to('ranabilalmunawar122@gmail.com');
						$message->replyTo($request->email)
							->subject('Calculator Logical Contact Form (' . $request['subject'] . ')');
					}
				);
				$data['done'] = 'Thank you for reaching out! Our team will get back to you as soon as possible.';
			} else {
				$data['error'] = "Please! Check Your Input";
			}
		}
		$data['device'] = $this->device;
		$data['meta_title'] = __('menu_lang.feedback_meta_title');
		$data['meta_des'] = __('menu_lang.feedback_meta_des');
		$data['page'] = 'Feed Back';
		return view('pages/feedback', $data);
	}


	public function register(Request $request)
	{

		if (Auth::check()) {
			// Redirect to home page if already logged in
			return redirect('/')->with('status', 'You are already logged in.');
		}

		if (isset($request['name'])) {
			if (!empty($request['name']) && !empty($request['email']) && !empty($request['password'])) {
				$request->validate([
					'name' => 'required|string|max:250',
					'email' => 'required|email|max:250|unique:users',
					'password' => 'required|min:8|confirmed'
				]);
				User::create([
					'name' => $request->name,
					'email' => $request->email,
					'password' => Hash::make($request->password)
				]);

				$credentials = $request->only('email', 'password');
				Auth::attempt($credentials);
				$request->session()->regenerate();

				$data['done'] = 'You have successfully registered!.';
			} else {
				$data['error'] = "Please! Check Your Input";
			}
		}
		$data['device'] = $this->device;
		$data['meta_title'] = "Feedback - Get in Touch with Us Anytime, Anywhere";
		$data['meta_des'] = "If you have any questions or need assistance with our content and calculators, the Calculator-Online team is here to help you 24/7. Feel free to reach out to us with any queries or comments. Please fill out the form below to share your thoughts or ask for support.";
		$data['page'] = 'contact-us';
		return view('auth/register', $data);
	}

	public function login(Request $request)
	{

		if (Auth::check()) {
			// Redirect to home page if already logged in
			return redirect('/')->with('status', 'You are already logged in.');
		}

		if (isset($request['email'])) {
			if (!empty($request['email']) && !empty($request['password'])) {

				$credentials = $request->validate([
					'email' => 'required|email',
					'password' => 'required'
				]);

				if (Auth::attempt($credentials)) {
					if (Auth::user()->user_role == 'admin') {
						return redirect('admin/dashboard')->with('status', 'Welcome to Dashboard');
					} else {
						return redirect('/')->with('status', 'Login In Successfully');
					}
				}

				return back()->withErrors([
					$data['error'] = "Your provided credentials do not match in our records."
				])->onlyInput('error');
			} else {
				$data['error'] = "Please! Check Your Input";
			}
		}
		$data['device'] = $this->device;
		$data['meta_title'] = "Feedback - Get in Touch with Us Anytime, Anywhere";
		$data['meta_des'] = "If you have any questions or need assistance with our content and calculators, the Calculator-Online team is here to help you 24/7. Feel free to reach out to us with any queries or comments. Please fill out the form below to share your thoughts or ask for support.";
		$data['page'] = 'contact-us';
		return view('auth/login', $data);
	}

	public function logout(Request $request)
	{
		Auth::logout();
		$request->session()->invalidate();
		$request->session()->regenerateToken();
		return redirect('/')->withSuccess('You have logged out successfully!');
	}


	public function submitForgetPasswordForm(Request $request)
	{

		if (isset($request['email'])) {
			if (!empty($request['email'])) {
				$request->validate([
					'email' => 'required|email|exists:users',
				]);
				$token = Str::random(64);
				DB::table('password_resets')->insert([
					'email' => $request->email,
					'token' => $token,
					'created_at' => Carbon::now()
				]);

				Mail::send('email.forgetPassword', ['token' => $token], function ($message) use ($request) {
					$message->to($request->email);
					$message->subject('Reset Password');
				});

				$data['done'] = 'A password reset link has been sent to your email address.';
			} else {
				$data['error'] = "Please! Check Your Input";
			}
		}
		$data['device'] = $this->device;
		$data['meta_title'] = "Feedback - Get in Touch with Us Anytime, Anywhere";
		$data['meta_des'] = "If you have any questions or need assistance with our content and calculators, the Calculator-Online team is here to help you 24/7. Feel free to reach out to us with any queries or comments. Please fill out the form below to share your thoughts or ask for support.";
		$data['page'] = 'contact-us';
		return view('auth/forgetPassword', $data);
	}
	public function showResetPasswordForm(Request $request, $token)
	{

		if (isset($request['email'])) {
			if (!empty($request['email'])) {
				$request->validate([
					'email' => 'required|email|exists:users',
					'password' => 'required|string|min:6|confirmed',
					'password_confirmation' => 'required'
				]);
				$updatePassword = DB::table('password_resets')
					->where([
						'email' => $request->email,
						'token' => $request->token
					])
					->first();
				if (!$updatePassword) {
					$data['error'] = 'Invalid token!!';
				} else {
					$user = User::where('email', $request->email)
						->update(['password' => Hash::make($request->password)]);
					DB::table('password_resets')->where(['email' => $request->email])->delete();
					$data['done'] = 'Your password has been changed!';
				}
			} else {
				$data['error'] = "Please! Check Your Input";
			}
		}
		$data['device'] = $this->device;
		$data['meta_title'] = "Feedback - Get in Touch with Us Anytime, Anywhere";
		$data['meta_des'] = "If you have any questions or need assistance with our content and calculators, the Calculator-Online team is here to help you 24/7. Feel free to reach out to us with any queries or comments. Please fill out the form below to share your thoughts or ask for support.";
		$data['page'] = 'contact-us';
		$data['token'] = $token;
		return view('auth/forgetPasswordLink', $data);
	}
	public function showResetPasswordForms($token)
	{

		$data['device'] = $this->device;
		$data['meta_title'] = "Feedback - Get in Touch with Us Anytime, Anywhere";
		$data['meta_des'] = "If you have any questions or need assistance with our content and calculators, the Calculator-Online team is here to help you 24/7. Feel free to reach out to us with any queries or comments. Please fill out the form below to share your thoughts or ask for support.";
		$data['page'] = 'contact-us';
		$data['token'] = $token;
		return view('auth/forgetPasswordLink', $data);


		// return view('auth.forgetPasswordLink', ['token' => $token]);
	}

	public function submitResetPasswordForm(Request $request)

	{
		$request->validate([
			'email' => 'required|email|exists:users',
			'password' => 'required|string|min:6|confirmed',
			'password_confirmation' => 'required'
		]);
		$updatePassword = DB::table('password_resets')
			->where([
				'email' => $request->email,
				'token' => $request->token
			])
			->first();
		if (!$updatePassword) {
			return back()->withInput()->with('error', 'Invalid token!');
		}
		$user = User::where('email', $request->email)
			->update(['password' => Hash::make($request->password)]);
		DB::table('password_resets')->where(['email' => $request->email])->delete();

		return redirect('/login')->with('message', 'Your password has been changed!');
	}

	public function advertise()
	{
		$data['device'] = $this->device;
		$data['meta_title'] = "Advertise with Us";
		$data['meta_des'] = "Finance calculator from thetime-calculator.com";
		$data['page'] = 'advertise';
		return view('pages/advertise', $data);
	}
	public function hire()
	{
		$data['device'] = $this->device;
		$data['meta_title'] = "Hire Us | thetime-calculator.com";
		$data['meta_des'] = "Hire Us | thetime-calculator.com";
		$data['page'] = 'hire-us';
		return view('pages/hire', $data);
	}
	public function sitemap()
	{
		$path = public_path('sitemap.xml');
		$contents = file_get_contents($path);
	// 	$posts = DB::table('posts')->where('is_del', 0)->where('show_hide', 1)->get();
	// 	$data['posts'] = $posts;
	// 	$data['calculators'] = $calculators;
	// 	// dd($calculators);
	// 	$contents = view('pages/sitemap')->with($data);

	// 	return response($contents)->header('Content-Type', 'text/xml;charset=iso-8859-1');
	// }
	}

	public function sitemapPage()
	{
		$categories = DB::table('categories')
			->select('cat_id', 'cat_name')
			->where('is_del', 0)
			->get();

		$calculators = DB::table('calculators')
			->select('cal_cat', 'cal_sub_cat', 'cal_title', 'cal_link', 'parent')
			->where('is_show', 0)
			->where('no_index', 0)
			->get();

		$groupedCalculators = $calculators->groupBy('cal_cat');
		$calculatorsCount = DB::table('calculators')->select('parent')->groupBy('parent')->where('is_calculator', 'Calculator')->get()->count();
		$data['device'] = $this->device;
		$data['categories'] = $categories;
		$data['calculatorsCount'] = $calculatorsCount;
		$data['groupedCalculators'] = $groupedCalculators;
		$data['allcategories'] = $this->allcategories;
		$data['meta_title'] = "";
		$data['meta_des'] = "";
		$data['page'] = 'sitemap';

		return view('pages.sitemap-page', $data);
	}




}
