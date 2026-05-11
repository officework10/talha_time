<div class="max-w-[730px] mx-auto lg:py-1 md:py-1  mt-6 relative  px-5" >
    <div class="bordercalculator xl:p-4 lg:p-4 p-3  bg-white xl:rounded-[25px] lg:rounded-[20px] rounded-[16px] w-full"
        style="box-shadow: 0px 0px 40px 4px #0000001a">
        <div class="flex lg:flex-row flex-col gap-x-5 lg:gap-y-[22px] md:gap-y-[22px] w-full">
            <div class="lg:w-[50%] w-full">
                <p class="text-[16px] leading-[20.85px] font-[700] px-3">Input</p>
                <div id="showInput"
                    class="bg-[#FAFAFA] min-h-[40px] max-h-[100px] border border-[#E3E3E3] rounded-[12px] px-3 pt-2 my-3">
                    &nbsp;
                </div>
            </div>
            <div class="lg:w-[50%] w-full">
                <p class="text-[16px] leading-[20.85px] font-[700] px-3">Answer</p>
                <div
                    class="bg-[#FAFAFA] flex items-center justify-end min-h-[40px] max-h-[100px] border border-[#E3E3E3] rounded-[12px] px-3 pt-2 my-3">
                    <p id="showOutput" class="text-[#818181] text-right text-[28px] leading-[36.46px] font-[500]">
                    </p>
                </div>
            </div>
            <div class="w-full text-center lg:hidde md:hidden block"> 
                <button onclick="show_calculator(this)" id="scientific_calculator" value="scientific" class="bg-[#55be30] w-full mb-3 mt-1 lg:hidden text-[#fff] hover:bg-[#1A1A1A] hover:text-white duration-200 font-[600] text-[14px] rounded-[25px] px-4 py-3">
                    Scientific Calculator
                </button>
                <button onclick="show_calculator(this)" id="simple_calculator" value="simple" class="bg-[#55be30] w-full mb-3 mt-1 hidden text-[#fff] hover:bg-[#1A1A1A] hover:text-white duration-200 font-[600] text-[14px] rounded-[25px] px-4 py-3">
                    Simple Calculator
                </button>
            </div>
        </div>

        <div class="grid lg:grid-cols-10  gap-x-2  gap-y-2">
            <div class="col-span-5 lg:block md:block hidden"  id="left_calulator">
                <div class="grid grid-cols-5  gap-x-2  gap-y-2">
                    <div onclick="calculator('sin')"
                        class="bg-[#F4F4F4] cursor-pointer hover:bg-black duration text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500]">sin</p>
                    </div>
                    <div onclick="calculator('cos')"
                        class="bg-[#F4F4F4] cursor-pointer hover:bg-black duration text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500]">cos</p>
                    </div>
                    <div onclick="calculator('tan')"
                        class="bg-[#F4F4F4] cursor-pointer hover:bg-black duration text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500]">tan</p>
                    </div>
                    <div
                        class="bg-[#F4F4F4] cursor-pointer hover:bg-black duration text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <label for="scirdsettingd" class="cursor-pointer">
                            <p class="flex items-center gap-x-1 text-[12px] font-[500] hover:text-white">
                                <input id="scirdsettingd" class="with-gap" type="radio" name="scirdsetting"
                                    value="deg" onclick="DegorRad='degree';" checked aria-label="input field">
                                Deg
                            </p>
                        </label>
                    </div>
                    <div
                        class="bg-[#F4F4F4] cursor-pointer hover:bg-black duration text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <label for="scirdsettingr" class="cursor-pointer">
                            <p class="flex items-center gap-x-1 text-[12px] font-[500] hover:text-white">
                                <input id="scirdsettingr" class="with-gap" type="radio" name="scirdsetting"
                                    value="deg" onclick="DegorRad='radians';" checked aria-label="input field">
                                Rad
                            </p>
                        </label>
                    </div>
                    <div onclick="calculator('asin')"
                        class="bg-[#F4F4F4] hover:bg-black duration text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500] cursor-pointer">
                            <span>sin<sup>-1</sup></span>
                        </p>
                    </div>
                    <div onclick="calculator('acos')"
                        class="bg-[#F4F4F4] hover:bg-black duration text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500] cursor-pointer">
                            <span>cos<sup>-1</sup></span>
                        </p>
                    </div>
                    <div onclick="calculator('atan')"
                        class="bg-[#F4F4F4] hover:bg-black duration text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500] cursor-pointer">
                            <span>tan<sup>-1</sup></span>
                        </p>
                    </div>
                    <div onclick="calculator('pi')"
                        class="bg-[#F4F4F4] cursor-pointer hover:bg-black duration text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500]">π</p>
                    </div>
                    <div onclick="calculator('e')"
                        class="bg-[#F4F4F4] cursor-pointer hover:bg-black duration text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500]">e</p>
                    </div>
                    <div
                        class="bg-[#F4F4F4] cursor-pointer  hover:bg-black duration text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p onclick="calculator('pow')" class="text-[18px] font-[500]">
                            <span>x<sup>y</sup></span>
                        </p>
                    </div>

                    <div onclick="calculator('x3')"
                        class="bg-[#F4F4F4] cursor-pointer hover:bg-black duration text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500] cursor-pointer">
                            <span>x<sup>3</sup></span>
                        </p>
                    </div>
                    <div onclick="calculator('x2')"
                        class="bg-[#F4F4F4] cursor-pointer hover:bg-black duration text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500] cursor-pointer">
                            <span>x<sup>2</sup></span>
                        </p>
                    </div>
                    <div onclick="calculator('ex')"
                        class="bg-[#F4F4F4] hover:bg-black duration text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500] cursor-pointer">
                            <span>e<sup>x</sup></span>
                        </p>
                    </div>
                    <div onclick="calculator('10x')"
                        class="bg-[#F4F4F4] cursor-pointer hover:bg-black duration text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500] cursor-pointer">
                            <span>10<sup>x</sup></span>
                        </p>
                    </div>

                    <div onclick="calculator('apow')"
                        class="bg-[#F4F4F4] cursor-pointer hover:bg-black duration text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500]">
                            <span><sup>y</sup>√x</span>
                        </p>
                    </div>

                    <div onclick="calculator('3x')"
                        class="bg-[#F4F4F4] cursor-pointer hover:bg-black duration text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500]">
                            <span><sup>3</sup>√x</span>
                        </p>
                    </div>
                    <div onclick="calculator('sqrt')"
                        class="bg-[#F4F4F4] cursor-pointer hover:bg-black duration text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500]">
                            <span class="grey_color">√x</span>
                        </p>
                    </div>
                    <div onclick="calculator('ln')"
                        class="bg-[#F4F4F4] cursor-pointer hover:bg-black duration text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500]">In</p>
                    </div>
                    <div onclick="calculator('log')"
                        class="bg-[#F4F4F4] cursor-pointer hover:bg-black duration text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500]">Log</p>
                    </div>

                    <div onclick="calculator('(')"
                        class="bg-[#F4F4F4] cursor-pointer hover:bg-black duration text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500]">(</p>
                    </div>
                    <div onclick="calculator(')')"
                        class="bg-[#F4F4F4] cursor-pointer hover:bg-black duration text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500]">)</p>
                    </div>
                    <div onclick="calculator('1/x')"
                        class="bg-[#F4F4F4] cursor-pointer hover:bg-black duration text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500]">1/x</p>
                    </div>
                    <div onclick="calculator('n!')"
                        class="bg-[#F4F4F4] cursor-pointer hover:bg-black duration text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500]">n!</p>
                    </div>
                    <div onclick="calculator('pc')"
                        class="bg-[#F4F4F4] cursor-pointer hover:bg-black duration text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500]">%</p>
                    </div>
                </div>
            </div>
            <div class="col-span-5" >
                <div class="grid grid-cols-5  gap-x-2  gap-y-2">
                    <div onclick="calculator(1)"
                        class="bg-[#F4F4F4] hover:bg-black duration cursor-pointer text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500] cursor-pointer">1</p>
                    </div>
                    <div onclick="calculator(2)"
                        class="bg-[#F4F4F4] hover:bg-black duration cursor-pointer text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500] cursor-pointer">2</p>
                    </div>

                    <div onclick="calculator(3)"
                        class="bg-[#F4F4F4] hover:bg-black duration cursor-pointer text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500] cursor-pointer">3</p>
                    </div>

                    <div onclick="calculator('-')"
                        class="bg-[#F4F4F4] hover:bg-black duration text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500] cursor-pointer">-</p>
                    </div>
                    <div onclick="calculator('bk')"
                        class="bg-[#55be30] hover:bg-black duration text-white hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500] cursor-pointer">
                            <svg width="34" height="22" viewBox="0 0 34 22" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M16.75 15.428L19.972 10.964L16.75 6.5H19.072L21.376 9.758L23.68 6.5H26.002L22.78 10.964L26.002 15.428H23.68L21.376 12.17L19.072 15.428H16.75Z"
                                    fill="white"></path>
                                <path
                                    d="M10.7855 2.37868C11.3481 1.81607 12.1112 1.5 12.9069 1.5H29.25C30.9069 1.5 32.25 2.84315 32.25 4.5V17.5C32.25 19.1569 30.9069 20.5 29.25 20.5H12.9069C12.1112 20.5 11.3481 20.1839 10.7855 19.6213L4.28553 13.1213C3.11396 11.9497 3.11396 10.0503 4.28553 8.87868L10.7855 2.37868Z"
                                    stroke="white" stroke-width="2"></path>
                            </svg>
                        </p>
                    </div>
                    <div onclick="calculator(4)"
                        class="bg-[#F4F4F4] cursor-pointer hover:bg-black duration text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500]">4</p>
                    </div>

                    <div onclick="calculator(5)"
                        class="bg-[#F4F4F4] cursor-pointer hover:bg-black duration text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500]">5</p>
                    </div>
                    <div onclick="calculator(6)"
                        class="bg-[#F4F4F4] cursor-pointer hover:bg-black duration text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500]">6</p>
                    </div>
                    <div onclick="calculator('+')"
                        class="bg-[#F4F4F4] cursor-pointer hover:bg-black duration text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500]">+</p>
                    </div>
                    <div onclick="calculator('ans')"
                        class="bg-[#55be30] cursor-pointer hover:bg-black duration text-white hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500]">Ans</p>
                    </div>
                    <div onclick="calculator(7)"
                        class="bg-[#F4F4F4] cursor-pointer hover:bg-black duration text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500]">7</p>
                    </div>
                    <div onclick="calculator(8)"
                        class="bg-[#F4F4F4] cursor-pointer hover:bg-black duration text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500]">8</p>
                    </div>
                    <div onclick="calculator(9)"
                        class="bg-[#F4F4F4] cursor-pointer hover:bg-black duration text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500]">9</p>
                    </div>
                    <div onclick="calculator('/')"
                        class="bg-[#F4F4F4] cursor-pointer hover:bg-black duration text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500]">÷</p>
                    </div>
                    <div onclick="calculator('M+')"
                        class="bg-[#F4F4F4] cursor-pointer hover:bg-black duration text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500]">M+</p>
                    </div>

                    <div onclick="calculator(0)"
                        class="bg-[#F4F4F4] cursor-pointer hover:bg-black duration text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500]">0</p>
                    </div>
                    <div onclick="calculator('.')"
                        class="bg-[#F4F4F4] cursor-pointer hover:bg-black duration text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500]">.</p>
                    </div>
                    <div onclick="calculator('=')"
                        class="bg-[#55be30] cursor-pointer hover:bg-black duration text-white hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500]">=</p>
                    </div>
                    <div onclick="calculator('*')"
                        class="bg-[#F4F4F4] cursor-pointer hover:bg-black duration text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500]">x</p>
                    </div>
                    <div onclick="calculator('M-')"
                        class="bg-[#F4F4F4] cursor-pointer hover:bg-black duration text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500]">M-</p>
                    </div>

                    <div onclick="calculator('+/-')"
                        class="bg-[#F4F4F4] cursor-pointer hover:bg-black duration text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500]">
                            <span class="grey_color">±</span>
                        </p>
                    </div>
                    <div onclick="calculator('RND')"
                        class="bg-[#F4F4F4] cursor-pointer hover:bg-black duration text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500]">RND</p>
                    </div>
                    <div onclick="calculator('C')"
                        class="bg-[#55be30] cursor-pointer hover:bg-black duration text-white hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500]">AC</p>
                    </div>
                    <div onclick="calculator('EXP')"
                        class="bg-[#55be30] cursor-pointer hover:bg-black duration text-white hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p class="text-[18px] font-[500]">EXP</p>
                    </div>
                    <div
                        class="bg-[#F4F4F4] cursor-pointer hover:bg-black duration text-black hover:text-white rounded-[7px] flex justify-center items-center lg:w-[50px]  w-auto h-[35px]">
                        <p onclick="calculator('MR')" id="scimrc" class="text-[18px] font-[500]">MR</p>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>