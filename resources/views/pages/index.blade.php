@extends('layouts.app')
@section('title', $meta_title)
@section('meta_des', $meta_des)
@section('content')
  <link href="https://fonts.googleapis.com/css2?family=Audiowide&family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet"/>

    <style>
        .cursor-pointer {
            cursor: pointer !important;
        }
        .border-bb {
            border: 1px solid #D2D4D8 !important;
        }
        .autosearch-activeclass {
            background-color: #1670a712;
        }
        .search_bars_div {
            border: 1px solid #D2D4D8 !important;
        }
        /* Blog Card Cutout Styling */
        .blog-card-cutout {
            position: absolute;
            bottom: 0;
            right: 0;
            background: white;
            padding: 1.25rem 0 0 1.25rem;
            border-top-left-radius: 2.5rem;
            border-bottom-right-radius: 2.5rem;
            z-index: 10;
        }
        .blog-card-cutout::before,
        .blog-card-cutout::after {
            content: "";
            position: absolute;
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            pointer-events: none;
        }
        .blog-card-cutout::before {
            top: -2rem;
            right: 0;
            box-shadow: 1rem 1rem 0 0 white;
        }
        .blog-card-cutout::after {
            bottom: 0;
            left: -2rem;
            box-shadow: 1rem 1rem 0 0 white;
        }
        /* User Card Cutout Styling (Top Right) */
        .user-card-cutout {
            position: absolute;
            top: 0;
            right: 0;
            background: white;
            padding: 0 0 1.25rem 1.25rem;
            border-bottom-left-radius: 2.5rem;
            z-index: 10;
        }
        .user-card-cutout::before,
        .user-card-cutout::after {
            content: "";
            position: absolute;
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            pointer-events: none;
        }
        .user-card-cutout::before {
            top: 0;
            left: -2rem;
            box-shadow: 1rem -1rem 0 0 white;
        }
        .user-card-cutout::after {
            bottom: -2rem;
            right: 0;
            box-shadow: 1rem -1rem 0 0 white;
        }
        /* Calculator Card Cutout (Smaller) */
        .cal-card-cutout {
            position: absolute;
            top: 0;
            right: 0;
            background: white;
            padding: 0 0 0.85rem 0.85rem;
            border-bottom-left-radius: 1.5rem;
            z-index: 10;
            transition: all 0.30s ease;
        }
        .cal-card-cutout::before,
        .cal-card-cutout::after {
            content: "";
            position: absolute;
            width: 1rem;
            height: 1rem;
            border-radius: 50%;
            pointer-events: none;
            transition: all 0.30s ease;
        }
        .cal-card-cutout::before {
            top: 0;
            left: -1rem;
            box-shadow: 0.5rem -0.5rem 0 0 white;
        }
        .cal-card-cutout::after {
            bottom: -1rem;
            right: 0;
            box-shadow: 0.5rem -0.5rem 0 0 white;
        }
        .group:hover .cal-card-cutout,
        .group:hover .cal-card-cutout::before,
        .group:hover .cal-card-cutout::after {
            background-color: transparent;
            box-shadow: none;
        }
        .group:hover .cal-card-cutout {
            background: transparent;
        }
    </style>
    {{-- Hero Section --}}


  <style>
    /* ── Outer wrapper ── */
    .hero-outer-wrap {
      width: 100%;
      max-width: 1200px;
      position: relative;
      margin: 0 auto;
    }

    /* ── Hero dark card ── */
    .hero-main-card {
      background: radial-gradient(ellipse 60% 80% at 25% 50%, #14300a 0%, #0b1e06 40%, #040c02 100%);
      border-radius: 26px;
      overflow: hidden;
      position: relative;
      min-height: 520px;
      display: flex;
    }

    /* ── Left text zone ── */
    .hero-text-content {
      flex: 0 0 52%;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 48px 0 56px 48px;
      position: relative;
      z-index: 3;
    }

    .hero-main-title {
      font-family: 'Audiowide', sans-serif;
      font-size: clamp(2.5rem, 5.5vw, 4.8rem);
      font-weight: 400;
      line-height: 1.08;
      text-transform: uppercase;
      color: transparent;
      -webkit-text-stroke: 1.5px #3ef53e;
      letter-spacing: 0.02em;
    }

    .hero-main-desc {
      color: rgba(255,255,255,0.75);
      font-size: 0.95rem;
      line-height: 1.6;
      margin-top: 20px;
      margin-bottom: 32px;
      max-width: 440px;
    }

    .hero-action-btns {
      display: flex;
      gap: 16px;
      flex-wrap: wrap;
    }

    .btn-hero-outline {
      background: transparent;
      border: 1.8px solid #fff;
      color: #fff;
      padding: 14px 28px;
      border-radius: 999px;
      font-size: 0.8rem;
      font-weight: 700;
      letter-spacing: 0.08em;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 10px;
      transition: all 0.3s ease;
      white-space: nowrap;
    }
    .btn-hero-outline:hover { background: rgba(255,255,255,0.12); border-color: #3ef53e; color: #3ef53e; }

    .btn-hero-green {
      background: #3ef53e;
      border: none;
      color: #000;
      padding: 14px 32px;
      border-radius: 999px;
      font-size: 0.8rem;
      font-weight: 700;
      letter-spacing: 0.08em;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 10px;
      transition: all 0.3s ease;
    }
    .btn-hero-green:hover { background: #29d929; transform: translateY(-2px); box-shadow: 0 4px 15px rgba(62, 245, 62, 0.3); }

    /* ── Hourglass zone (center) ── */
    .hero-visual-center {
      flex: 0 0 35%;
      display: flex;
      align-items: flex-end;
      justify-content: center;
      position: relative;
      z-index: 2;
    }

    /* ── Circles zone (top-right) ── */
    .hero-visual-right {
      flex: 1;
      position: relative;
    }

    .circles-svg-bg {
      position: absolute;
      top: -20px;
      right: -10px;
      width: 280px;
      height: 280px;
      opacity: 0.5;
    }

    /* ── Info cards ── */
    .hero-live-cards {
      position: absolute;
      bottom: -45px;
      right: 30px;
      display: flex;
      gap: 20px;
      z-index: 10;
    }

    .live-icard {
      background: #ffffff;
      border-radius: 24px;
      padding: 24px 32px;
      min-width: 190px;
      box-shadow: 0 15px 35px rgba(0,0,0,0.1);
      border: 1px solid rgba(0,0,0,0.05);
    }

    .live-icard-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 0.8rem;
      color: #666;
      margin-bottom: 12px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }

    .live-icard-value {
      font-size: 3.2rem;
      font-weight: 800;
      color: #000;
      line-height: 1;
      margin-bottom: 10px;
      letter-spacing: -0.02em;
    }

    .live-icard-sub {
      font-size: 0.7rem;
      font-weight: 700;
      color: #56BE30;
      letter-spacing: 0.08em;
      text-transform: uppercase;
    }

    @media (max-width: 1024px) {
        .hero-main-card { flex-direction: column; min-height: auto; padding-bottom: 100px; }
        .hero-text-content { flex: 1; padding: 40px; }
        .hero-visual-center { display: none; }
        .hero-live-cards { position: relative; bottom: 0; right: 0; padding: 0 40px; margin-top: -50px; justify-content: center; }
    }
    @media (max-width: 640px) {
        .hero-live-cards { flex-direction: column; align-items: center; }
        .live-icard { width: 100%; max-width: 280px; }
    }
  </style>

  <div class="container-fluid mx-auto mt-12 mb-28">
    <section class="max-w-7xl mx-auto px-4">
      <div class="hero-outer-wrap">
        <div class="hero-main-card">
          <div class="hero-text-content">
            <h1 class="hero-main-title">CALCULATE<br>TIME &amp;<br>DATE</h1>
            <div>
              <p class="hero-main-desc">Your ultimate companion for precise time calculations. Fast, reliable, and designed to simplify your daily scheduling needs.</p>
              <div class="hero-action-btns">
                <button class="btn-hero-outline" onclick="document.getElementById('calculator-section').scrollIntoView({ behavior: 'smooth' })">EXPLORE TOOLS &nbsp;→</button>
                <button class="btn-hero-green">
                  SEARCH &nbsp;
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2.5" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><line x1="16.5" y1="16.5" x2="22" y2="22"/></svg>
                </button>
              </div>
            </div>
          </div>

          <div class="hero-visual-center">
            <svg width="180" height="380" viewBox="0 0 200 420" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect x="28" y="380" width="144" height="28" rx="6" fill="#5a3a18"/>
              <rect x="22" y="374" width="156" height="14" rx="5" fill="#7a4e20"/>
              <rect x="22" y="18" width="156" height="14" rx="5" fill="#7a4e20"/>
              <rect x="28" y="10" width="144" height="14" rx="6" fill="#5a3a18"/>
              <path d="M38 32 L162 32 L108 200 L92 200 Z" fill="rgba(150,210,170,0.08)" stroke="rgba(200,230,210,0.35)" stroke-width="1.5"/>
              <path d="M92 200 L108 200 L162 368 L38 368 Z" fill="rgba(100,160,120,0.06)" stroke="rgba(200,230,210,0.35)" stroke-width="1.5"/>
              <path d="M42 34 L158 34 L114 170 L86 170 Z" fill="#b8852a" opacity="0.25"/>
              <path d="M50 34 L150 34 L106 155 L94 155 Z" fill="#d4a040" opacity="0.3"/>
              <line x1="100" y1="195" x2="100" y2="220" stroke="#c49030" stroke-width="2.5" stroke-linecap="round" opacity="0.8"/>
              <line x1="100" y1="195" x2="100" y2="218" stroke="#e0b050" stroke-width="1.2" opacity="0.5"/>
              <ellipse cx="100" cy="358" rx="52" ry="9" fill="#a06820" opacity="0.85"/>
              <path d="M55 356 Q100 326 145 356 L148 366 L52 366 Z" fill="#c48030" opacity="0.7"/>
              <path d="M65 352 Q100 330 135 352" fill="#d49040" opacity="0.55"/>
              <path d="M90 330 Q100 318 110 330 L115 346 L85 346 Z" fill="#c08030" opacity="0.6"/>
              <path d="M52 36 L62 36 L96 180" stroke="rgba(255,255,255,0.12)" stroke-width="10" stroke-linecap="round" fill="none"/>
              <path d="M55 36 L64 36 L97 175" stroke="rgba(255,255,255,0.07)" stroke-width="5" stroke-linecap="round" fill="none"/>
              <path d="M54 368 L60 368 L96 218" stroke="rgba(255,255,255,0.09)" stroke-width="10" stroke-linecap="round" fill="none"/>
              <ellipse cx="100" cy="200" rx="8" ry="4" fill="rgba(180,230,200,0.2)" stroke="rgba(200,230,210,0.4)" stroke-width="1"/>
              <rect x="34" y="30" width="132" height="6" rx="3" fill="rgba(180,200,190,0.3)"/>
              <rect x="34" y="366" width="132" height="6" rx="3" fill="rgba(180,200,190,0.3)"/>
              <path d="M44 34 L156 34 L108 192 L92 192 Z" fill="rgba(2,8,2,0.55)" stroke="none"/>
              <path d="M92 210 L108 210 L158 366 L42 366 Z" fill="rgba(2,8,2,0.45)" stroke="none"/>
            </svg>
          </div>

          <div class="hero-visual-right">
            <svg class="circles-svg-bg" viewBox="0 0 240 240" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="220" cy="20" r="170" stroke="rgba(220,240,220,0.25)" stroke-width="1.2"/>
              <circle cx="220" cy="20" r="130" stroke="rgba(220,240,220,0.25)" stroke-width="1.2"/>
              <circle cx="220" cy="20" r="90" stroke="rgba(220,240,220,0.25)" stroke-width="1.2"/>
              <circle cx="220" cy="20" r="50" stroke="rgba(220,240,220,0.2)" stroke-width="1.2"/>
            </svg>
          </div>
        </div>

        <div class="hero-live-cards">
          <div class="live-icard">
            <div class="live-icard-header">
              <span>Time</span>
              <span>Local</span>
            </div>
            <div class="live-icard-value" id="js-time">--:--</div>
            <div class="live-icard-sub" id="js-ampm">PAKISTAN</div>
          </div>
          <div class="live-icard">
            <div class="live-icard-header">
              <span>Date</span>
              <span id="js-month">---</span>
            </div>
            <div class="live-icard-value" id="js-date">--/--</div>
            <div class="live-icard-sub" id="js-daysub">----</div>
          </div>
        </div>
      </div>
    </section>
  </div>
    <!-- Search bar -->

    {{-- Category-wise Calculators Grid --}}
    <div class="container-fluid mx-auto mt-[20px]">
        <section class="max-w-7xl mx-auto px-6 py-6">
            <div class="text-center mb-12">
                <div class="mb-4">
                    <button class="bg-[#56BE30] text-white px-10 py-2.5 rounded-full text-sm font-semibold shadow-sm hover:bg-green-600 transition">
                        ALL CALCULATORS
                    </button>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2">All Major Calculators</h2>
            </div>

            @if(isset($allcategories) && count($allcategories) > 0)
                @foreach($allcategories as $category)
                    @php
                        $catCalculators = $calculators->where('cal_cat', $category->cat_name);
                    @endphp
                    @if($catCalculators->count() > 0)
                        <div class="mb-16">
                           
                            
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                                @foreach ($catCalculators->take(11) as $cal)
                                <a href="{{ url($cal->cal_link) }}" class="group relative bg-[#F3F4F6] hover:bg-[#56BE30] rounded-[1.5rem] p-5 pt-8 transition duration-300 flex flex-col h-full overflow-hidden hover:shadow-md">
                                    <div class="cal-card-cutout">
                                        <div class="w-8 h-8 flex items-center justify-center">
                                            <span class="text-lg font-light text-gray-900 group-hover:text-white transition-colors">↗</span>
                                        </div>
                                    </div>
                                    <span class="text-[15px] font-bold text-gray-900 group-hover:text-white leading-snug transition-colors">
                                        {{ $cal->cal_title }}
                                    </span>
                                </a>
                                @endforeach

                                {{-- View All for this category --}}
                                <a href="{{ url('timedate') }}" class="group relative bg-[#56BE30] hover:bg-green-600 rounded-[1.5rem] p-5 pt-8 transition duration-300 flex flex-col h-full overflow-hidden shadow-lg shadow-green-100">
                                    <div class="absolute top-0 right-0 p-2">
                                        <span class="text-lg font-light text-white">↗</span>
                                    </div>
                                    <span class="text-[15px] font-bold text-white leading-snug">
                                        View All <br> {{ $category->cat_name }}
                                    </span>
                                </a>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        </section>
    </div>
 


    {{-- About Calculator --}}
    <div class="container-fluid mx-auto mt-[20px]">
        <section class="max-w-7xl mx-auto px-6 py-6">
            <div class="text-center">
                <div class="mb-4">
                    <button class="bg-black text-white px-6 py-3 rounded-full text-sm font-semibold shadow-md hover:bg-gray-900 transition">
                        ABOUT US
                    </button>
                </div>
            </div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mt-2 text-center">About Our Tool</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center mt-6">
                <div class="space-y-4 text-gray-800">
                    <p>
                        TheTime-Calculator.com is your move-to destination all the time-associated calculations. Whether you're planning a task, managing your every day schedule, or simply curious approximately the time differences throughout the globe, our platform gives equipment designed to simplify and decorate it slow control enjoy.
                    </p>
                    <p>
                        From calculating time intervals to changing among time units or figuring out the precise length between dates, TheTime-Calculator.com guarantees short and accurate results at your fingertips. With a user-pleasant interface and a ramification of equipment, you may effects manage some time and make knowledgeable selections. Revel in the convenience of precision with TheTime-Calculator.com today!
                    </p>
                </div>
                <div class="relative p-4 overflow-hidden">
                    <img src="https://thetime-calculator.com/images/about.png" 
                         alt="Clock and Calendar" 
                         width="721" 
                         height="292" 
                         loading="lazy" 
                         class="w-full h-auto">
                </div>
            </div>
        </section>
    </div>

    {{-- Users Section --}}
    <div class="container mx-auto mt-16 px-4">
         <section class="max-w-7xl mx-auto px-6 py-6">

        <div class="text-center mb-12">
            <div class="mb-4">
                <button class="bg-[#56BE30] text-white px-10 py-2.5 rounded-full text-sm font-semibold shadow-sm hover:bg-green-600 transition">
                    USERS
                </button>
            </div>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2">Users of Time Calculator</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 max-w-7xl mx-auto">
            {{-- Card 1 --}}
            <div class="group relative bg-[#F3F4F6] hover:bg-[#56BE30] rounded-[2.5rem] p-8 transition duration-300 flex flex-col h-full overflow-hidden hover:shadow-lg hover:shadow-green-100">
                <div class="user-card-cutout">
                    <div class="w-16 h-16 flex items-center justify-center">
                        <span class="text-3xl font-light text-gray-900">↗</span>
                    </div>
                </div>
                <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center mb-8 shadow-sm transition duration-300 group-hover:scale-110">
                    <img src="https://thetime-calculator.com/images/Group_37.png" alt="Icon" class="w-8 h-8">
                </div>
                <h3 class="text-2xl font-bold text-gray-900 group-hover:text-white leading-tight mb-6 uppercase transition duration-300">
                    Students <br> & Teachers
                </h3>
                <p class="text-gray-600 group-hover:text-white group-hover:text-opacity-90 text-sm leading-relaxed transition duration-300">
                    Lorem ipsum dolor sit amet consectetur ntum et telluhabi ant ltrices sodales vestibulu sque tellus quis sed lectus...
                </p>
            </div>

            {{-- Card 2 --}}
            <div class="group relative bg-[#F3F4F6] hover:bg-[#56BE30] rounded-[2.5rem] p-8 transition duration-300 flex flex-col h-full overflow-hidden hover:shadow-lg hover:shadow-green-100">
                <div class="user-card-cutout">
                    <div class="w-16 h-16 flex items-center justify-center">
                        <span class="text-3xl font-light text-gray-900">↗</span>
                    </div>
                </div>
                <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center mb-8 shadow-sm transition duration-300 group-hover:scale-110">
                    <img src="https://thetime-calculator.com/images/Group_38.png" alt="Icon" class="w-8 h-8">
                </div>
                <h3 class="text-2xl font-bold text-gray-900 group-hover:text-white leading-tight mb-6 uppercase transition duration-300">
                    Office <br> Professional <br> & Managers
                </h3>
                <p class="text-gray-600 group-hover:text-white group-hover:text-opacity-90 text-sm leading-relaxed transition duration-300">
                    Lorem ipsum dolor sit amet consectetur ntum et telluhabi ant ltrices sodales vestibulu sque tellus quis sed lectus...
                </p>
            </div>

            {{-- Card 3 --}}
            <div class="group relative bg-[#F3F4F6] hover:bg-[#56BE30] rounded-[2.5rem] p-8 transition duration-300 flex flex-col h-full overflow-hidden hover:shadow-lg hover:shadow-green-100">
                <div class="user-card-cutout">
                    <div class="w-16 h-16 flex items-center justify-center">
                        <span class="text-3xl font-light text-gray-900">↗</span>
                    </div>
                </div>
                <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center mb-8 shadow-sm transition duration-300 group-hover:scale-110">
                    <img src="https://thetime-calculator.com/images/Group_39.png" alt="Icon" class="w-8 h-8">
                </div>
                <h3 class="text-2xl font-bold text-gray-900 group-hover:text-white leading-tight mb-6 uppercase transition duration-300">
                    Event <br> Planners
                </h3>
                <p class="text-gray-600 group-hover:text-white group-hover:text-opacity-90 text-sm leading-relaxed transition duration-300">
                    Lorem ipsum dolor sit amet consectetur ntum et telluhabi ant ltrices sodales vestibulu sque tellus quis sed lectus...
                </p>
            </div>

            {{-- Card 4 --}}
            <div class="group relative bg-[#F3F4F6] hover:bg-[#56BE30] rounded-[2.5rem] p-8 transition duration-300 flex flex-col h-full overflow-hidden hover:shadow-lg hover:shadow-green-100">
                <div class="user-card-cutout">
                    <div class="w-16 h-16 flex items-center justify-center">
                        <span class="text-3xl font-light text-gray-900">↗</span>
                    </div>
                </div>
                <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center mb-8 shadow-sm transition duration-300 group-hover:scale-110">
                    <img src="https://thetime-calculator.com/images/Group_40.png" alt="Icon" class="w-8 h-8">
                </div>
                <h3 class="text-2xl font-bold text-gray-900 group-hover:text-white leading-tight mb-6 uppercase transition duration-300">
                    Freelancers <br> & Remote <br> Workers
                </h3>
                <p class="text-gray-600 group-hover:text-white group-hover:text-opacity-90 text-sm leading-relaxed transition duration-300">
                    Lorem ipsum dolor sit amet consectetur ntum et telluhabi ant ltrices sodales vestibulu sque tellus quis sed lectus...
                </p>
            </div>
        </div>
         </section>
    </div>
    
    {{-- Blogs Section --}}
    <div class="container mx-auto mt-12 px-4">
        <div class="text-center">
            <div class="mb-4">
                <button class="bg-[#56BE30] text-white px-10 py-2.5 rounded-full text-sm font-semibold shadow-sm hover:bg-green-600 transition">
                    BLOGS
                </button>
            </div>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-2">Read and get your concept strong</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12 max-w-7xl mx-auto">
            @if(isset($posts) && count($posts) > 0)
                @foreach ($posts as $post)
                <div class="group relative bg-[#F3F4F6] rounded-[2.5rem] p-6 shadow-sm transition duration-300 flex flex-col h-full">
                    <a href="{{ url('blog/'.$post->post_url) }}" class="block flex-grow">
                        <div class="overflow-hidden rounded-[2rem]">
                            <img src="{{ $post->post_img ? url('images/'.$post->post_img) : asset('images/blog_thumbnail.png') }}" alt="{{ $post->post_title }}" class="w-full h-56 object-cover group-hover:scale-105 transition duration-500">
                        </div>
                        <div class="mt-6 mb-16">
                            <h3 class="text-xl font-bold text-gray-900 leading-tight">
                                {{ \Illuminate\Support\Str::limit($post->post_title, 60) }}
                            </h3>
                            <p class="text-gray-500 text-sm mt-3 leading-relaxed">
                                {{ \Illuminate\Support\Str::limit(strip_tags($post->short_des), 120) }}
                            </p>
                        </div>
                    </a>
                    {{-- Arrow Cutout --}}
                    <div class="blog-card-cutout transition-all duration-300">
                        <a href="{{ url('blog/'.$post->post_url) }}" class="bg-white w-16 h-16 rounded-full flex items-center justify-center hover:scale-110 transition-transform">
                            <span class="text-3xl font-light text-gray-900">↗</span>
                        </a>
                    </div>
                </div>
                @endforeach
            @else
                {{-- Fallback if no posts found --}}
                @for ($i = 0; $i < 3; $i++)
                <div class="group relative bg-[#F3F4F6] rounded-[2.5rem] p-6 shadow-sm hover:shadow-md transition duration-300 flex flex-col h-full">
                    <div class="overflow-hidden rounded-[2rem]">
                        <img src="{{ asset('images/blog_thumbnail.png') }}" alt="Blog Image" class="w-full h-56 object-cover group-hover:scale-105 transition duration-500">
                    </div>
                    <div class="mt-6 mb-16">
                        <h3 class="text-xl font-bold text-gray-900 leading-tight">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                        </h3>
                        <p class="text-gray-500 text-sm mt-3 leading-relaxed">
                            Simply copy and paste your text into the input box, and decide whether you want a longer, medium-siz.....
                        </p>
                    </div>
                    {{-- Arrow Cutout --}}
                    <div class="absolute bottom-0 right-0 bg-white pt-5 pl-5 rounded-tl-[2.5rem]">
                        <div class="w-16 h-16 flex items-center justify-center">
                            <span class="text-3xl font-light text-gray-900">↗</span>
                        </div>
                    </div>
                </div>
                @endfor
            @endif
        </div>
    </div>



    {{-- FAQs Section --}}
    <div class="container mx-auto mt-5 px-4">
        <div class="text-center py-10">
            <div class="my-8">
                <button class="bg-black text-white px-6 py-3 rounded-full text-sm font-semibold shadow-md hover:bg-gray-900 transition">
                   FAQs
                </button>
            </div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mt-2 text-center mb-8">Frequently Asked Questions</h2>
            <div class="max-w-3xl mx-auto text-left space-y-4">
                <div class="border-b pb-4 faq-item cursor-pointer">
                    <div class="flex justify-between items-center py-2">
                        <p class="text-gray-800 font-medium">What is a Time Calculator and how does it work?</p>
                        <span class="faq-icon text-[#56BE30] text-xl font-bold transition-transform duration-300">+</span>
                    </div>
                    <div class="faq-answer hidden text-gray-600 pb-2">
                        A Time Calculator is a tool designed to add or subtract time values (hours, minutes, seconds) and calculate the duration between two points in time. It works by converting all time inputs into a common unit, performing the math, and then formatting the result back into a readable time format.
                    </div>
                </div>
                <div class="border-b pb-4 faq-item cursor-pointer">
                    <div class="flex justify-between items-center py-2">
                        <p class="text-gray-800 font-medium">Can I calculate a time that was hours ago?</p>
                        <span class="faq-icon text-[#56BE30] text-xl font-bold transition-transform duration-300">+</span>
                    </div>
                    <div class="faq-answer hidden text-gray-600 pb-2">
                         Yes! Our calculator allows you to subtract hours, minutes, or days from the current time to find out exactly what time it was in the past. This is useful for tracking historical data or calculating elapsed intervals.
                    </div>
                </div>
                <div class="border-b pb-4 faq-item cursor-pointer">
                    <div class="flex justify-between items-center py-2">
                        <p class="text-gray-800 font-medium">Is it possible to calculate time into the future?</p>
                        <span class="faq-icon text-[#56BE30] text-xl font-bold transition-transform duration-300">+</span>
                    </div>
                    <div class="faq-answer hidden text-gray-600 pb-2">
                         Absolutely. You can add specific amounts of time to any date or the current time to determine future points in time. This is ideal for project planning, deadline management, or simple scheduling.
                    </div>
                </div>
                <div class="border-b pb-4 faq-item cursor-pointer">
                    <div class="flex justify-between items-center py-2">
                        <p class="text-gray-800 font-medium">Does this calculator adjust for different time zones?</p>
                        <span class="faq-icon text-[#56BE30] text-xl font-bold transition-transform duration-300">+</span>
                    </div>
                    <div class="faq-answer hidden text-gray-600 pb-2">
                         Most of our standard duration calculators use local time, but we also provide specialized tools for time zone conversion. These tools handle UTC offsets and Daylight Saving Time (DST) automatically to ensure accuracy across the globe.
                    </div>
                </div>
                <div class="border-b pb-4 faq-item cursor-pointer">
                    <div class="flex justify-between items-center py-2">
                        <p class="text-gray-800 font-medium">Can I use negative numbers to subtract time?</p>
                        <span class="faq-icon text-[#56BE30] text-xl font-bold transition-transform duration-300">+</span>
                    </div>
                    <div class="faq-answer hidden text-gray-600 pb-2">
                         While our calculators typically use specific "add" or "subtract" modes, entering negative values in subtraction-based calculations will effectively add time, and vice-versa, depending on the specific tool's logic.
                    </div>
                </div>
                <div class="border-b pb-4 faq-item cursor-pointer">
                    <div class="flex justify-between items-center py-2">
                        <p class="text-gray-800 font-medium">Is this tool free to use?</p>
                        <span class="faq-icon text-[#56BE30] text-xl font-bold transition-transform duration-300">+</span>
                    </div>
                    <div class="faq-answer hidden text-gray-600 pb-2">
                         Yes, TheTime-Calculator.com is 100% free for everyone. We support our site through subtle advertisements so that we can keep providing high-precision tools at no cost to our users.
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Benefits Section --}}
    <div class="container-fluid mx-auto mt-[20px]">
        <div class="text-center">
            <div class="my-8">
                <button class="bg-black text-white px-6 py-3 rounded-full text-sm font-semibold shadow-md hover:bg-gray-900 transition">
                    Featured In
                </button>
            </div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mt-2 text-center">Benefits of Using Our Calculator</h2>
            <div class="w-full flex justify-center mt-8">
                <div class="flex md:w-[70%] justify-center">
                    <img src="https://thetime-calculator.com/images/feature.png" 
                         alt="Benefits of Using Our Calculator" 
                         width="1240" 
                         height="502" 
                         loading="lazy" 
                         class="w-full h-auto object-cover">
                </div>
            </div>
        </div>
    </div>

   
   
   
   
@endsection
@push('calculatorJS')
    {{-- home page search  --}}
    <script>
        function autocomplete(inp, arr) {
            arr = Object.entries(arr);
            var currentFocus;
            inp.addEventListener("input", function(e) {
                var a, b, i, val = this.value;
                closeAllLists();
                if (!val) {
                    return false;
                }
                currentFocus = -1;
                a = document.createElement("div");
                a.setAttribute("id", this.id + "autocomplete-list");
                a.setAttribute("class",
                    "absolute autosearchcomplete-items space-y-1 max-h-80 overflow-y-auto text-start bg-white rounded-lg shadow-inner mt-[28px] w-full top-[20px]"
                    );
                this.parentNode.appendChild(a);
                for (i = 0; i < arr.length; i++) {
                    if (arr[i][1][0].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                        // if (arr[i][1][0].toUpperCase().indexOf(val.toUpperCase()) !== -1) {
                        b = document.createElement("div");
                        b.innerHTML = " <a href='" + window.location.origin + '/' + arr[i][1][1] +
                            "' class='block items-center py-2 rounded  border-bb   group hover:shadow-sm hover:bg-gray-50'> <strong class=' ms-3 whitespace-nowrap' >" +
                            arr[i][1][0].substr(0, val.length) + "</strong>" + arr[i][1][0].substr(val.length) +
                            ' </a>';

                        b.addEventListener("click", function(e) {
                            closeAllLists();
                            var href = this.querySelector('a').getAttribute('href');
                            window.location.href = href;
                        });
                        a.appendChild(b);
                    }
                }
                document.querySelectorAll('.suggestion').forEach(function(element) {
                    element.style.display = 'none';
                });
            });
            inp.addEventListener("keydown", function(e) {
                var x = document.getElementById(this.id + "autocomplete-list");
                if (x) x = x.getElementsByTagName("div");
                if (e.keyCode == 40) {
                    // console.log('keydown');
                    currentFocus++;
                    addActive(x);
                } else if (e.keyCode == 38) {
                    currentFocus--;
                    addActive(x);
                } else if (e.keyCode == 13) {
                    // e.preventDefault();
                    if (currentFocus > -1) {
                        if (x) x[currentFocus].click();
                    }
                }
                document.querySelectorAll('.recently_calculators').forEach(function(element) {
                    element.style.display = 'none';
                });

            });

            function addActive(x) {
                if (!x) return false;
                console.log('keydown');

                removeActive(x);
                if (currentFocus >= x.length) currentFocus = 0;
                if (currentFocus < 0) currentFocus = (x.length - 1);
                x[currentFocus].classList.add("autosearch-activeclass");
            }

            function removeActive(x) {
                for (var i = 0; i < x.length; i++) {
                    x[i].classList.remove("autosearch-activeclass");
                }
            }

            function closeAllLists(elmnt) {
                var x = document.getElementsByClassName("autosearchcomplete-items");
                for (var i = 0; i < x.length; i++) {
                    if (elmnt != x[i] && elmnt != inp) {
                        x[i].parentNode.removeChild(x[i]);
                    }
                }
            }
            document.addEventListener("click", function(e) {
                closeAllLists(e.target);
            });
        }
        autocomplete(document.getElementById("search-bars"), searchCalculators);


        let searchimg_index = document.querySelector(".searchsvg");
        let searchinput = document.querySelector(".searchinput");
        if (searchimg_index) {
            searchimg_index.addEventListener("click", function() {
                searchinput.focus();
            });
        }
        // show_calculator
        function show_calculator(button) {
            const value = button.value;
            // You can use this value to perform specific actions
            if (value === "scientific") {
                $('#scientific_calculator').hide();
                $('#simple_calculator').show();
                $('#left_calulator').show();
                // Show scientific calculator
            } else if (value === "simple") {
                $('#scientific_calculator').show();
                $('#simple_calculator').hide();
                $('#left_calulator').hide();
                // Show simple calculator
            }
        }
    </script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const scrollLink = document.querySelector(".scroll-link");
        if (scrollLink) {
            scrollLink.addEventListener("click", function (e) {
                e.preventDefault(); // Prevent default anchor behavior
                const target = document.getElementById("targetDiv");
                if (target) {
                    target.scrollIntoView({ behavior: "smooth", block: "start" });
                }
            });
        }
    });

    // FAQ Accordion Logic
    document.querySelectorAll('.faq-item').forEach(item => {
        item.addEventListener('click', () => {
            const answer = item.querySelector('.faq-answer');
            const icon = item.querySelector('.faq-icon');
            
            // Toggle current answer
            if (answer.classList.contains('hidden')) {
                answer.classList.remove('hidden');
                icon.textContent = '-';
                icon.style.transform = 'rotate(180deg)';
            } else {
                answer.classList.add('hidden');
                icon.textContent = '+';
                icon.style.transform = 'rotate(0deg)';
            }
        });
    });
    </script>


    
    <script>
       const DAYS   = ['SUNDAY','MONDAY','TUESDAY','WEDNESDAY','THURSDAY','FRIDAY','SATURDAY'];
       const MONTHS = ['January','February','March','April','May','June','July','August','September','October','November','December'];
     
       function tick() {
         const now = new Date(new Date().toLocaleString('en-US', {timeZone:'Asia/Karachi'}));
         let h  = now.getHours();
         const m   = String(now.getMinutes()).padStart(2,'0');
         const ampm = h >= 12 ? 'PM' : 'AM';
         h = h % 12 || 12;
     
         const day  = String(now.getDate()).padStart(2,'0');
         const mon  = String(now.getMonth() + 1).padStart(2,'0');
         const year = now.getFullYear();
         const dayName = DAYS[now.getDay()];
         const monthName = MONTHS[now.getMonth()];
     
         // Update Time with blinking colon
         const colon = `<span style="opacity: ${now.getSeconds() % 2 === 0 ? '1' : '0.2'}; transition: opacity 0.2s;">:</span>`;
         document.getElementById('js-time').innerHTML = h + colon + m;
         
         document.getElementById('js-ampm').textContent   = `${ampm}-PAKISTAN`;
         document.getElementById('js-month').textContent  = monthName.toUpperCase().substring(0,3);
         document.getElementById('js-date').textContent   = `${day}/${mon}`;
         document.getElementById('js-daysub').textContent = `${year}-${dayName}`;
       }
     
       tick();
       setInterval(tick, 1000);
     </script>


@endpush
