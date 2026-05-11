
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap');
    * { font-family: 'Space Grotesk', sans-serif; }
  </style>
</head>

<footer>
    <div class="bg-white py-10 px-4 sm:px-8 md:px-12">
        <div class="max-w-7xl mx-auto relative">

    <!-- Title top-left (white bg, overlaps dark card) -->
    <div class="absolute top-0 left-0 z-10 my-7 mx-10">
      <h1 class="text-5xl font-bold tracking-widest text-white uppercase leading-tight">
        TIME CALCULATOR
      </h1>
    </div>

    <!-- Main dark card -->
    <div class="bg-black rounded-3xl mt-[80px] p-10 relative overflow-visible">

      <!-- Grid: 3 columns -->
      <div class="grid grid-cols-3 gap-8 mt-9">

        <!-- LEFT: Description -->
        <div class="col-span-1 pt-2">
          <p class="text-white text-sm leading-relaxed">
            Hey there! Want to manage your time like a total pro? Check out our awesome time calculator! It's a free online tool that's super handy for anyone looking to get a grip on their schedule, whether you're planning a fun event or just trying to juggle your daily tasks. Give it a try and make your life a little easier!
          </p>
        </div>

        <!-- MIDDLE: Quick Links -->
        <div class="col-span-1 pt-2">
          <h2 class="text-[#4ade80] font-bold text-base mb-4">Quick Links</h2>
          <ul class="space-y-3">
            <li><a href="#" class="text-white text-sm hover:text-[#4ade80] transition-colors">Home</a></li>
            <li><a href="#" class="text-white text-sm hover:text-[#4ade80] transition-colors">About Us</a></li>
            <li><a href="#" class="text-white text-sm hover:text-[#4ade80] transition-colors">Blog</a></li>
            <li><a href="#" class="text-white text-sm hover:text-[#4ade80] transition-colors">Content Disclaimer</a></li>
            <li><a href="#" class="text-white text-sm hover:text-[#4ade80] transition-colors">Terms and conditions</a></li>
            <li><a href="#" class="text-white text-sm hover:text-[#4ade80] transition-colors">Privacy policy</a></li>
          </ul>
        </div>

        <!-- RIGHT: Get Intouch -->
        <div class="col-span-1 pt-2 relative">
          <h2 class="text-[#4ade80] font-bold text-base mb-4">Get Intouch</h2>
          <ul class="space-y-3 mb-5">
            <li><a href="#" class="text-white text-sm hover:text-[#4ade80] transition-colors">Contact Us</a></li>
            <li><a href="#" class="text-white text-sm hover:text-[#4ade80] transition-colors">Feedback</a></li>
          </ul>

          <!-- Social Icons -->
          <div class="flex gap-2 mt-2">
            <!-- Facebook -->
            <a href="#" class="bg-[#4ade80] rounded-md w-9 h-9 flex items-center justify-center hover:bg-[#22c55e] transition-colors">
              <svg class="w-5 h-5 text-black fill-current" viewBox="0 0 24 24">
                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
              </svg>
            </a>
            <!-- Instagram -->
            <a href="#" class="bg-[#4ade80] rounded-md w-9 h-9 flex items-center justify-center hover:bg-[#22c55e] transition-colors">
              <svg class="w-5 h-5 text-black fill-none stroke-current stroke-2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                <circle cx="12" cy="12" r="4"/>
                <circle cx="17.5" cy="6.5" r="0.5" fill="currentColor" stroke="none"/>
              </svg>
            </a>
            <!-- Pinterest -->
            <a href="#" class="bg-[#4ade80] rounded-md w-9 h-9 flex items-center justify-center hover:bg-[#22c55e] transition-colors">
              <svg class="w-5 h-5 text-black fill-current" viewBox="0 0 24 24">
                <path d="M12 0C5.373 0 0 5.373 0 12c0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738a.36.36 0 0 1 .083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.632-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0z"/>
              </svg>
            </a>
          </div>
        </div>
      </div>

      <!-- Copyright -->
      <div class="mt-10 text-center">
        <p class="text-[#4ade80] text-sm font-medium">© 2025 Calculator online All rights reserved.</p>
      </div>

    </div>

    <!-- START button — bottom right, overlaps the card -->
    <div class="absolute -bottom-5 top-[200px] -right-4">
      <button class="bg-white text-black font-bold text-3xl tracking-widest uppercase px-10 py-5 rounded-3xl shadow-lg hover:bg-gray-100 transition-colors">
        START
      </button>
    </div>

  </div>
  </div>

</footer>