<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
// use App\Http\Controllers\WidgetController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\UserForgotPasswordController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// use Illuminate\Support\Facades\Auth;

// Route::get('/force-login', function () {
//     // Admin ki ID check kar lein (aam tor par 1 hoti hai)
//     Auth::loginUsingId(1); 
    
//     // Login ke baad direct admin dashboard par redirect
//     return redirect('admin/calculators')->with('success', 'You are logged in as Admin.');
// });


// use Illuminate\Support\Facades\DB;

// Route::get('/force-login', function () {
//     // 1. Database se pehla admin uthayein
//     $user = DB::table('admins')->first();

//     if ($user) {
//         $adminId = $user->admin_id;
//         $name = $user->admin_name;

//         // 2. Login ID create karein (Wahi md5 logic jo aapke controller mein hai)
//         $login_id = md5($name . time());
        
//         $data['login_id'] = $login_id;
//         $data['id'] = $adminId;

//         // 3. login_table mein entry insert karein
//         DB::table('login_table')->insert($data);

//         // 4. Cookie set karein jo aapki website check karti hai
//         setcookie("technical_calculator", $login_id, time() + 24 * 3600, "/", "", true, true);

//         // 5. Redirect karein dashboard par
//         return redirect('admin/calculators')->with('success', 'You are logged in as Admin via Force Login.');
//     }

//     return "Error: Database mein koi admin nahi mila!";
// });



Route::get('forget-password', [UserForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [UserForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
Route::get('reset-password/{token}', [UserForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [UserForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
Route::middleware(['guest'])->group(function () {
    Route::get('login', [AuthController::class, 'index'])->name('login');
    Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post'); 
    Route::get('register', [AuthController::class, 'registration'])->name('register');
    Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
});

Route::middleware(['auth'])->group(function () {
    Route::get('logoutuser', [AuthController::class, 'logoutuser'])->name('logoutuser');
    Route::get('profile', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::get('change-password', [ChangePasswordController::class, 'index']);
   Route::post('change-password', [ChangePasswordController::class, 'changePassword']);

});

    //  GoogleController
    Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('back.google');



Route::get('/home', function () {
    return view('Homepage');
});
Route::get('/bilal', function () {
    return view('calculators.height-comparing');
});

Route::get('/blogs', function () {
    return view('tawingcss.blogs');
});

Route::get('/blogs-detail', function () {
    return view('tawingcss.blogs-details');
});


    Route::prefix('admin')->group(function () {
        Route::get('/',[AdminController::class,'index']);
        Route::get('/dashboard',[AdminController::class,'dashboard']);
        Route::match(['get', 'post'],'/login',[AdminController::class,'login']);
        Route::match(['get', 'post'],'/logout',[AdminController::class,'logout']);
        Route::match(['get', 'post'],'/add-calculator',[AdminController::class,'addCalculator']);
        Route::match(['get', 'post'],'/edit-calculator/{id}',[AdminController::class,'editCalculator']);
        
        Route::post('/keys',[AdminController::class,'keys']);
        Route::get('/calculators',[AdminController::class,'calculators']);
        Route::get('/pending-calculators',[AdminController::class,'pendingCalculators']);
        Route::get('/approve/{id}',[AdminController::class,'approve']);
        
        Route::match(['get', 'post'],'/media',[AdminController::class,'media']);

        Route::get('/posts',[PostController::class,'posts']);
        Route::get('/pending-posts',[PostController::class,'pending']);
        Route::match(['get', 'post'],'/add-post',[PostController::class,'addPost']);
        Route::match(['get', 'post'],'/edit-post/{id}',[PostController::class,'editPost']);
        Route::match(['get', 'post'],'/delete-post/{id}',[PostController::class,'deletePost']);

        Route::get('/users',[UserController::class,'index']);
        Route::match(['get', 'post'],'/add-user',[UserController::class,'addUser']);
        Route::match(['get', 'post'],'/edit-user/{id}',[UserController::class,'editUser']);

        // for categories
        Route::match(['get', 'post'],'/categories',[AdminController::class,'categories']);
        Route::match(['get', 'post'],'/add-category',[AdminController::class,'addCategory']);
        Route::match(['get', 'post'],'/edit-category/{id}',[AdminController::class,'editCategory']);
        Route::match(['get', 'post'],'/delete-category/{id}',[AdminController::class,'deleteCategory']);
        Route::match(['get', 'post'],'/sub-categories',[AdminController::class,'subCategories']);
        Route::match(['get', 'post'],'/add-sub-category',[AdminController::class,'addsubCategories']);
        Route::match(['get', 'post'],'/delete-sub-category/{id}',[AdminController::class,'deleteSubCategory']);
        Route::match(['get', 'post'],'/edit-sub-category/{id}',[AdminController::class,'editSubCategory']);
        Route::match(['get', 'post'],'/search-subcategory',[AdminController::class,'searchsubcategory']);
});





Route::middleware([App\Http\Middleware\RedirectIfIndexPhp::class])->group(function () {
    Route::post('/calculate', [HomeController::class, 'calculate'])->name('calculate_calculator');
    Route::get('/{category}',[HomeController::class,'category'])
    ->where('category', 'health|finance|math|physics|chemistry|statistics|everyday-life|construction|pets|timedate|time');
    Route::get('/blog',[BlogController::class,'index']);
    Route::get('blog/{category}',[BlogController::class,'category'])
    ->where('category', 'health|finance|math|physics|chemistry|statistics|everyday-life|construction|pets|timedate|Informative|time');
    Route::get('blog/{url}',[BlogController::class,'post']);

    // Route::match(['get', 'post'],'preview/{url}',[WidgetController::class,'preview']);
    // Route::match(['get', 'post'],'preview/{category}/{url}',[WidgetController::class,'subConverter']);
    Route::post('/search',[HomeController::class,'search']);
    Route::get('/about-us',[HomeController::class,'about']);
    
    Route::get('/privacy-policy',[HomeController::class,'policy']);
    Route::get('/all-category',[HomeController::class,'allcategory']);
    Route::get('/all-calculators',[HomeController::class,'allcalculators']);
    Route::get('/faq',[HomeController::class,'faq']);
    Route::get('/editorial-Policies',[HomeController::class,'editorial_Policies']);
    
    Route::get('/terms-of-service',[HomeController::class,'terms']);
    
    Route::get('/content-disclaimer',[HomeController::class,'disclaimer']);
    Route::get('/sitemap.xml',[HomeController::class,'sitemap']);
    // Route::get('/sitemap', [HomeController::class, 'sitemapPage'])->name('sitemapPage');
    Route::match(['get', 'post'], '/contact-us', [HomeController::class, 'contact']);
    Route::post('/contact/submit', [HomeController::class, 'contactSubmit'])->name('contact.submit');
    Route::match(['get', 'post'], '/feedback', [HomeController::class, 'feedback_email']);
    Route::post('/feedback/submit', [HomeController::class, 'feedbackSubmit'])->name('feedback.submit');
    Route::match(['get', 'post'],'/login',[HomeController::class,'login']);


    

   // Route::get('/our-team',[HomeController::class,'team']);
        // Tire Size Calculator API
    // Route::post('peechy-to-dekho',[ToolController::class,'chukeyaTire']);
    // Route::post('/contact/submit', [MailController::class, 'feedback'])->name('feedback');
    // Route::post('/contact/submit', [MailController::class, 'feedback'])->name('feedback');
    // Weight Loss Meals
    // Route::post('weight-loss-calculator-meals/', [HomeController::class, 'weightlossMeals'])->name('weightlossMeals');
    // Meal Planner Calculator
    Route::post('meal-planner-calculator/', [HomeController::class, 'mealPlanner'])->name('mealPlanner');
    // AI Math solver
    // Route::post('ai-math/', [HomeController::class, 'mathSolver'])->name('mathSolver');
    // Route::post('image-crop/', [HomeController::class, 'imageCrop'])->name('imageCrop');
    // Delet all source files for mathsolver
    // Route::get('delete-source-files/', [HomeController::class, 'cron'])->name('cron');
    
    // Route::get('/knowledge',[BlogController::class,'knowledge']);
    // Route::get('health/{url}',[BlogController::class,'knowPost']);
    // Route::get('math/{url}',[BlogController::class,'knowPost']);
    // Route::get('finance/{url}',[BlogController::class,'knowPost']);
    // Route::get('informative/{url}',[BlogController::class,'knowPost']);
    // Route::get('physics/{url}',[BlogController::class,'knowPost']);
    // Route::get('statistics/{url}',[BlogController::class,'knowPost']);
    // Route::get('math/{url}',[BlogController::class,'knowPost']);
    // Route::get('contraction/{url}',[BlogController::class,'knowPost']);
    // Route::get('ecology/{url}',[BlogController::class,'knowPost']);
    // Route::get('everyday/{url}',[BlogController::class,'knowPost']);
    // Route::get('food/{url}',[BlogController::class,'knowPost']);
    // Route::get('Sports/{url}',[BlogController::class,'knowPost']);
    // Route::get('others/{url}',[BlogController::class,'knowPost']);
    // Route::get('conversion/{url}',[BlogController::class,'knowPost']);
  
    
    // Route::match(['get', 'post'],'/register',[HomeController::class,'register']);
    // Route::get('/Register',[HomeController::class,'register'])->name('register');
    // Route::get('/Login',[HomeController::class,'login'])->name('login');
    // Route::get('/store',[HomeController::class,'store']);
    // Route::get('/authenticate',[HomeController::class,'authenticate'])->name('authenticate');
    // Route::controller(LoginRegisterController::class)->group(function() {
    //     Route::get('/register', 'register')->name('register');
    //     Route::post('/store', 'store')->name('store');
    //     Route::get('/login', 'login')->name('login');
    //     Route::post('/authenticate', 'authenticate')->name('authenticate');
       
    //     Route::post('/logout', 'logout')->name('logout');
    // });

    // Route::get('/testimonials',[HomeController::class,'testimonials']);
    // Route::get('/advertise',[HomeController::class,'advertise']);

    // Route::get('/feedback',[HomeController::class,'feedback']);
    // Route::get('/hire-us',[HomeController::class,'hire']);
  
    // Route::match(['get', 'post'],'/forget-password',[HomeController::class,'submitForgetPasswordForm']);
    // Route::match(['get', 'post'],'//reset-password/{token}',[HomeController::class,'showResetPasswordForm']);
    // Route::get('/logout',[HomeController::class,'logout'])->name('logout');

    // Route::get('/reset-password',[HomeController::class,'submitResetPasswordForm'])->name('reset.password.post');
    // Route::get('/reset-password/{token}',[HomeController::class,'showResetPasswordForm'])->name('reset.password.get');
    // Route::get('/forget-password',[HomeController::class,'submitForgetPasswordForm'])->name('forget.password.post');
    // Route::get('/forget-password',[HomeController::class,'showForgetPasswordForm'])->name('forget.password.get');

    
    Route::get('/',[HomeController::class,'index']);
    Route::match(['get', 'post'],'/{url}',[HomeController::class,'showPageEN']);


});
// Route::get('/', function () {
//     return view('welcome');
// });



// Route::get('/', function () {
//     return view('welcome');
// });





