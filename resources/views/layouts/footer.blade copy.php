<footer>
    <div class="bg-white py-10 px-4 sm:px-8 md:px-12">
        <div class="max-w-7xl mx-auto relative">
            
            <!-- Main Title Area (Top Left) -->
            <div class="relative flex flex-col md:flex-row items-start">
                <div class="bg-white pr-8 pb-8 rounded-br-[80px] md:rounded-br-[120px] relative z-20">
                    <h2 class="text-[32px] sm:text-[50px] md:text-[80px] font-black text-black uppercase leading-none tracking-tighter p-2">
                        Time Calculator
                    </h2>
                    <!-- Concave fillers for Title Notch -->
                    <div class="absolute top-0 -right-[80px] md:-right-[120px] w-[80px] md:w-[120px] h-[80px] md:h-[120px] z-10" 
                         style="background: radial-gradient(circle at 100% 0%, transparent 100%, black 100%); background-color: white;">
                        <div class="w-full h-full bg-black rounded-tl-[80px] md:rounded-tl-[120px]"></div>
                    </div>
                    <div class="absolute -bottom-[80px] md:-bottom-[120px] left-0 w-[80px] md:w-[120px] h-[80px] md:h-[120px] z-10" 
                         style="background: radial-gradient(circle at 0% 100%, transparent 100%, black 100%); background-color: white;">
                        <div class="w-full h-full bg-black rounded-tl-[80px] md:rounded-tl-[120px]"></div>
                    </div>
                </div>
            </div>

            <!-- Main Black Body -->
            <div class="bg-black text-white rounded-[60px] md:rounded-[100px] -mt-[40px] md:-mt-[60px] p-8 md:p-20 pt-[100px] md:pt-[140px] pb-[100px] md:pb-[140px] relative z-0">
                
                <div class="flex flex-col lg:flex-row justify-between gap-12 lg:gap-20">
                    <!-- Left: Description -->
                    <div class="w-full lg:w-[45%]">
                        <p class="text-[#D1D1D1] text-[15px] md:text-[18px] leading-[1.6] font-medium">
                            Hey there! Want to manage your time like a total pro? Check out our awesome time calculator! It's a free online tool that's super handy for anyone looking to get a grip on their schedule, whether you're planning a fun event or just trying to juggle your daily tasks. Give it a try and make your life a little easier!
                        </p>
                    </div>

                    <!-- Right: Links -->
                    <div class="w-full lg:w-[50%] flex flex-col sm:flex-row gap-10 md:gap-16">
                        <!-- Quick Links -->
                        <div class="flex-1">
                            <h3 class="text-[#56BE30] text-[18px] md:text-[22px] font-black mb-6 uppercase tracking-tight">Quick Links</h3>
                            <ul class="space-y-4 text-[14px] md:text-[16px] text-white">
                                <li><a href="/" class="hover:text-[#56BE30] transition-colors duration-200">Home</a></li>
                                <li><a href="/about-us" class="hover:text-[#56BE30] transition-colors duration-200">About Us</a></li>
                                <li><a href="/blog" class="hover:text-[#56BE30] transition-colors duration-200">Blog</a></li>
                                <li><a href="/content-disclaimer" class="hover:text-[#56BE30] transition-colors duration-200">Content Disclaimer</a></li>
                                <li><a href="/terms-of-service" class="hover:text-[#56BE30] transition-colors duration-200">Terms and conditions</a></li>
                                <li><a href="/privacy-policy" class="hover:text-[#56BE30] transition-colors duration-200">Privacy policy</a></li>
                            </ul>
                        </div>

                        <!-- Get In Touch -->
                        <div class="flex-1">
                            <h3 class="text-[#56BE30] text-[18px] md:text-[22px] font-black mb-6 uppercase tracking-tight">Get Intouch</h3>
                            <ul class="space-y-4 text-[14px] md:text-[16px] text-white mb-8">
                                <li><a href="/contact-us" class="hover:text-[#56BE30] transition-colors duration-200">Contact Us</a></li>
                                <li><a href="/editorial-Policies" class="hover:text-[#56BE30] transition-colors duration-200">Editorial Policies</a></li>
                                <li><a href="/feedback" class="hover:text-[#56BE30] transition-colors duration-200">Feedback</a></li>
                            </ul>
                            
                            <div class="flex gap-3">
                                <a href="https://www.facebook.com/profile.php?id=61567834120590" target="_blank" class="bg-[#56BE30] p-2.5 rounded-xl hover:scale-110 transition-transform duration-200">
                                    <img src="{{asset('images/assets/images/faceboob.svg')}}" alt="Facebook" class="w-5 h-5 brightness-0 invert">
                                </a>
                                <a href="https://pin.it/7KFbu1yrf" target="_blank" class="bg-[#56BE30] p-2.5 rounded-xl hover:scale-110 transition-transform duration-200">
                                    <img src="{{asset('images/assets/images/imsta.svg')}}" alt="Instagram" class="w-5 h-5 brightness-0 invert">
                                </a>
                                <a href="https://www.linkedin.com/in/george-leo-822458337/" target="_blank" class="bg-[#56BE30] p-2.5 rounded-xl hover:scale-110 transition-transform duration-200">
                                    <img src="{{asset('images/assets/images/pin.svg')}}" alt="Pinterest" class="w-5 h-5 brightness-0 invert">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Copyright -->
                <div class="absolute bottom-8 left-0 right-0 text-center">
                    <p class="text-[#56BE30] text-[12px] md:text-[14px] font-bold uppercase tracking-[0.2em]">
                        © 2025 Calculator online All rights reserved.
                    </p>
                </div>
            </div>

            <!-- Start Button Area (Bottom Right) -->
            <div class="absolute bottom-10 right-0 flex items-end justify-end">
                <div class="bg-white pl-8 pt-8 rounded-tl-[80px] md:rounded-tl-[120px] relative z-20">
                    <div class="p-2 md:p-4">
                        <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" 
                                class="bg-white text-black font-black text-[35px] md:text-[75px] px-10 md:px-24 py-4 md:py-10 rounded-full hover:scale-105 transition-all duration-300 tracking-tighter leading-none border-none cursor-pointer shadow-xl">
                            START
                        </button>
                    </div>
                    <!-- Concave fillers for Start Notch -->
                    <div class="absolute bottom-0 -left-[80px] md:-left-[120px] w-[80px] md:w-[120px] h-[80px] md:h-[120px] z-10" 
                         style="background: radial-gradient(circle at 0% 100%, transparent 100%, black 100%); background-color: white;">
                        <div class="w-full h-full bg-black rounded-br-[80px] md:rounded-br-[120px]"></div>
                    </div>
                    <div class="absolute -top-[80px] md:-top-[120px] right-0 w-[80px] md:w-[120px] h-[80px] md:h-[120px] z-10" 
                         style="background: radial-gradient(circle at 100% 0%, transparent 100%, black 100%); background-color: white;">
                        <div class="w-full h-full bg-black rounded-br-[80px] md:rounded-br-[120px]"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</footer>
