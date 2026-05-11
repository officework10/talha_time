<div>
  <style>
    #calculator{
        border-spacing: 0px;
    }
    .calculate{
        font-size: 15px !important;
        padding: 6px 10px !important;
    }
    fieldset {
        min-width: 0;
        padding: 0;
        margin: 0;
        border: 0;
        width: 60px;
    }
    .gray{
        color: gainsboro;
    }
    .bg-succes{
        background-color: #49987d;
        color:white;
    }
    .calculator-wrapper {
        background: #fff;
        border-radius: 4px;
        overflow-x: hidden;
    }
    #name-input,
    #date-input {
        border: 1px solid #53565a;
        color: #000;
        height: 40px;
        max-width: 100%;
        width: 100%;
        border-radius: 3px;
        padding: 0px 5px
    }

    input[type=number] , select {
        background: #fff;
        border: 1px solid #53565a;
        border-radius: 4px!important;
        color: #53565a;
        height: 30px;
        line-height: 1.2;
        outline: 0;
        padding: 0!important;
        text-align: center;
        width: 50px;
        margin: 0px 2px;
    }

    input[type=number]:focus {
        outline-color: #49987d !important;
    }

    #calculator tbody tr:nth-child(2n) {
        background: rgba(255, 255, 255, 0.819)!important;
    }

    #calculator tr td {
        border: none;
        padding: 10px;
        position: relative;
        display: inline-flex
;
    }

    #calculator tbody td:last-of-type {
        text-align: right;
    }

    .table-header {
        background: #49987d;
        color:white;
    }

    .table-footer {
        background: #ededed;
        border-radius: 0 0 4px 4px;
        color: #53565a;
        display: flex;
        line-height: 1;
        margin-bottom: 35px;
    }

    .total-hours {
        font-size: 22px;
        font-weight: 700;
        padding: 20px;
        /* text-align: right; */
    }
    span.colon-separator {
        padding: 0 5px;
    }

    /* div.flex {
        text-align: left;
        width: 100%;
    }
     */
    @media screen and (max-width: 920px) {
        #calculator tbody tr {
            display: flex;
            flex-direction: column;
        }
    }
    @media screen and (max-width: 920px) {
        #calculator tbody td {
            padding: 5px 0;
        }
    }
    .gap-2{
        gap: 5px;
    }
    .dowload_PDF_CSV {
        position: absolute;
        text-align: center;
        top: -39px;
        right: 41.5%;
        background-color: #49987d;
        color:white;
    }
    @media screen and (max-width : 550px){
        .table-header{
            display: none !important;
        }
        .text-start{
            text-align: start !important;
        }
    }
    .bg-result-blue{
        background-color: #49987d;
        color:white;
    }
</style>
@php
    $request = request();
@endphp

<div class="container-fluid mx-auto  container-fluid  ">
    <div class="w-full max-w-5xl mx-auto bg-white  p-3 md:px-10 lg:px-10 rounded-3xl">
        <!-- Heading -->
        <div class="w-full max-w-4xl mx-auto   rounded-3xl">
      @if (isset($error))
        <p class="text-red-500 text-lg font-semibold w-full">{{ $error }}</p>
       @endif

                    <div class="lg:w-[100%] md:w-[100%] w-full mx-auto ">
                   
                            
                            <div class="grid grid-cols-12 mt-3   gap-2 md:gap-4 lg:gap-4">
                                
                                <div class=" col-span-12 printable-content row relative">
                                    <div class="col-lg-12 mx-auto result ">
                                        <div class="row">
                                            <div class="grid grid-cols-12 mt-3   gap-2 md:gap-4 lg:gap-4">

                                                <div class="col-span-12 md:col-span-6 lg:col-span-6 header-input-fields">
                                                    {{$lang['1n'] ?? "Name"}}
                                                    <input type="text" class="input py-2" id="name" wire:model.live="name" placeholder="Jhon" onfocus="this.placeholder=''" onblur="this.placeholder=placeholder || 'Jhon'" >
                                                </div>
                                                <div class="col-span-12 md:col-span-6 lg:col-span-6 header-input-fields" id="date-input-wrapper">
                                                    {{$lang['2n'] ?? "Date"}}
                                                    <input type="date"  class="input py-2" id="date" wire:model.live="date">
                                                </div>

                                            </div>
                                            {{-- table --}} 
                                            <table id="calculator" class="responsive text-[14px] mt-2 w-full">
                                                <tbody class="grid grid-cols-12">
                                                    <tr class="table-header col-span-12 p-2 radius-2 mt-2 ">
                                                        <td width="12%">{{$lang['3n'] ?? "Day"}}</td>
                                                        <td width="25%">{{$lang['4n'] ?? "Starting Time"}}</td>
                                                        <td width="25%">{{$lang['5n'] ?? "Ending Time"}}</td>
                                                        <td width="20%"> {{$lang['6n'] ?? "Break Deduction"}} </td>
                                                        <td width="">{{$lang['7n'] ?? "Total"}}</td>
                                                    </tr>
                                                    @foreach($rows as $index => $row)
                                                    <tr class="col-span-12">
                                                        <td width="12%"  class="flex">{{ $row['day'] }}</td>
                                                        <td class="flex">
                                                            <input type="number" wire:model.live="rows.{{$index}}.start_h" min="0" max="12" placeholder="00"/>
                                                            <span class="colon-separator">:</span>
                                                            <input type="number" wire:model.live="rows.{{$index}}.start_m" min="0" max="59" placeholder="00"/>
                                                            <div class="form-group-calculator d-inline">
                                                                <select wire:model.live="rows.{{$index}}.start_p">
                                                                    <option value="AM">AM</option>
                                                                    <option value="PM">PM</option>
                                                                </select>
                                                            </div>
                                                            <span class="mobile-only mobile-label lg:hidden d-inline-block">Starting Time</span>
                                                        </td>
                                                        <td class="flex">
                                                            <input type="number" wire:model.live="rows.{{$index}}.end_h" min="0" max="12" placeholder="00"/>
                                                            <span class="colon-separator">:</span>
                                                            <input type="number" wire:model.live="rows.{{$index}}.end_m" min="0" max="59" placeholder="00">
                                                            <div class="form-group-calculator d-inline">
                                                                <select wire:model.live="rows.{{$index}}.end_p">
                                                                    <option value="AM" >AM</option>
                                                                    <option value="PM">PM</option>
                                                                </select>
                                                            </div>
                                                            <span class="mobile-only mobile-label lg:hidden d-inline-block">Ending Time</span>
                                                        </td>
                                                        <td class="flex">
                                                            <input type="number" wire:model.live="rows.{{$index}}.break_h" placeholder="00">
                                                            <span class="colon-separator">:</span>
                                                            <input type="number" wire:model.live="rows.{{$index}}.break_m" placeholder="00">
                                                            <span class="mobile-only mobile-label lg:hidden d-inline-block">Break Deduction</span>
                                                        </td>
                                                        <td class="text-start  {{$device == 'mobile' ? 'flex gap-2' : ''}}">
                                                            <span class="mobile-only mobile-label lg:hidden d-inline-block mobile-label-total">Total Hours: </span>
                                                            <div class="fw-bold {{ $row['total_minutes'] > 0 ? '' : 'gray' }}">{{ $row['total'] }}</div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            {{-- result --}}
                                            <div class="rounded-lg p-2 d-m flex bg-result-blue mb-2 text-[16px]">
                                                <div class="grid grid-cols-12 mt-3   gap-2 md:gap-4 lg:gap-4">
                                                    <div class="col-span-12 md:col-span-3 lg:col-span-3 px-1 d-block  mt-md-0 mt-1"> 
                                                        <span class="mb-0">{{$lang['8n'] ?? "Total Hours"}}: </span>
                                                        <span class="mb-0" id="finalTime">{{ $total_hours_display }}</span>
                                                    </div>
                                                    @if($working_hr)
                                                    <div class="col-span-12 md:col-span-3 lg:col-span-3 px-1 overtime  mt-md-0 mt-1"> 
                                                        <span class="mb-0">{{$lang['9n'] ?? "Overtime Pay" }}: </span>
                                                        <span class="mb-0" id="overtime_pay">${{ number_format($overtime_pay, 2) }}</span>
                                                    </div>
                                                    <div class="col-span-12 md:col-span-3 lg:col-span-3 px-1 overtime  mt-md-0 mt-1"> 
                                                        <span class="mb-0">{{$lang['10n'] ?? "Overtime Hours"}}: </span>
                                                        <span class="mb-0" id="overtime_hours">{{ $overtime_hours_display }}</span>
                                                    </div>
                                                    @endif
                                                    @if($cal_gross)
                                                    <div class="col-span-12 md:col-span-3 lg:col-span-3 px-1 gross  mt-md-0 mt-1"> 
                                                        <span class="mb-0">{{$lang['11n'] ?? "Total Gross Pay"}}: </span>
                                                        <span class="mb-0" id="GrosPrice">${{ number_format($total_gross_pay, 2) }}</span>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- advance option --}}
                                <div class=" col-span-12 row border rounded-lg py-2 text-[14px]">
                                    <div class="grid grid-cols-12 mt-3   gap-2 md:gap-4 lg:gap-4">
                                        <div class="col-span-12 md:col-span-4 lg:col-span-4 flex items-center gap-2">
                                            <input type="checkbox" wire:model.live="cal_gross" id="cal_gross">
                                            <label for="cal_gross">{{$lang['12n'] ?? "Calculate Total Gross Wages"}}</label>
                                        </div>
                                        @if($device == 'mobile')
                                            <div class="col-md ps-3 mt-1">
                                                @if($cal_gross)
                                                <div class="my-2 gross flex items-center gap-2">
                                                $ <input type="number" wire:model.live="price" size="6" maxlength="8" value="" style="width: 65px"> /hour
                                                </div>
                                                @endif
                                            </div>
                                        @endif
                                        <div class="col-span-12 md:col-span-4 lg:col-span-4 flex items-center gap-2">
                                            <input type="checkbox" wire:model.live="working_hr" id="working_hr">
                                            <label for="working_hr">{{$lang['13n'] ?? "Include Gross Overtime Wages"}}</label>
                                        </div>
                                        @if($device == 'mobile')
                                            @if($working_hr)
                                            <div class="w-full ps-3 my-1 shows">
                                                <div class="grid grid-cols-12 mt-3   gap-2 md:gap-4  items-center">
                                                    <div class="col-span-12 md:col-span-6 lg:col-span-6 gap-2 mt-5">
                                                        <input type="number" wire:model.live="working_hours" value="8" placeholder="8" class="my-2">
                                                        <select wire:model.live="working_period" class="border-dark my-2" style="width:120px;">
                                                            <option value="day">{{$lang['14n'] ?? "Hours per day"}}</option>
                                                            <option value="week">{{$lang['15n'] ?? "Hours per week"}}</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-span-12 md:col-span-6 lg:col-span-6 ps-3 my-1 overtime">
                                                        <label for="bi_weekly">{{$lang['16n'] ?? "Overtime rate"}}:</label>
                                                        <div>    
                                                            <input type="number" wire:model.live="overtime_rate" value="1.5" placeholder="1.5" class="my-2"> times base rate
                                                        </div>
                                                    </div>
                                                </div>
                                                <p>{{$lang['overtime_key'] ?? 'Overtime: Reg. x 1.5 after 09 hrs/day'}}</p>
                                            </div>
                                            @endif
                                        @endif
                                        <div class="col-span-12 md:col-span-4 lg:col-span-4 ps-md-3 my-1 flex items-center gap-2">
                                            <input type="checkbox" wire:model.live="bi_weekly" id="bi_weekly">
                                            <label for="bi_weekly">{{$lang['17n'] ?? "Switch to Bi-Weekly"}} </label>
                                        </div>
                                    </div>
                                    @if($device == 'desktop')
                                    <div class="grid grid-cols-12 mt-3   gap-2 md:gap-4 lg:gap-4">
                                        <div class="col-span-12 md:col-span-4 lg:col-span-4 ps-3 my-1">
                                            @if($cal_gross)
                                            <div class="my-2 gross flex items-center gap-2">
                                            $ <input type="number" wire:model.live="price" size="6" maxlength="8" value="" style="width: 65px"> /hour
                                            </div>
                                            @endif
                                        </div>
                                        @if($working_hr)
                                        <div class="col-span-12 md:col-span-8 lg:col-span-8 ps-3 my-1 shows">
                                            <div class="flex items-center">
                                                <div class="gap-2 mt-5">
                                                    <input type="number" wire:model.live="working_hours" value="8" placeholder="8" class="my-2">
                                                    <select wire:model.live="working_period" class="border-dark my-2" style="width:120px;">
                                                        <option value="day">{{$lang['14n'] ?? "Hours per day"}}</option>
                                                        <option value="week">{{$lang['15n'] ?? "Hours per week"}}</option>
                                                    </select>
                                                </div>
                                                <div class="col-md ps-3 my-1 overtime">
                                                    <label for="bi_weekly">{{$lang['16n'] ?? "Overtime rate"}}:</label>
                                                    <div>    
                                                        <input type="number" wire:model.live="overtime_rate" value="1.5" placeholder="1.5" class="my-2"> times base rate
                                                    </div>
                                                </div>
                                            </div>
                                            <p>{{$lang['overtime_key'] ?? 'Overtime: Reg. x 1.5 after 09 hrs/day'}}</p>
                                        </div>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                                <div class="col-span-12 text-center me-2 mt-4 relative">
                                    {{-- <button type="button" class="calculate bg-black text-[#ffffff] rounded-lg" id="printpage">{{$lang['18n'] ?? "Print"}}</button> --}}
                                    <button type="button" class="calculate bg-black text-[#ffffff] rounded-lg" id="save">{{$lang['19n'] ?? "download"}}
                                        <div class="dowload_PDF_CSV px-2 py-1 rounded-lg hidden">
                                            <p class="cursor-pointer text-[14px] d-block text-white py-1" id="downloadCSV" onclick="generateExcel()">{{$lang['19csv'] ?? "download CSV"}}</p>
                                            {{-- <p class="cursor-pointer text-[14px] d-block text-black border-b-dark py-1" onclick="downloadPDF()">{{$lang['19pdf'] ?? "download PDF"}}</p> --}}
                                        </div>
                                    </button>
                                    <button type="button" class="calculate bg-[#49987d] text-white rounded-lg" wire:click="initializeRows">{{$lang['20n'] ?? "Rest"}}</button>
                                </div>
                        </div>
                    </div>


                </div>
    
        @if ($request->get('type') == 'widget')
        @include('inc.widget-button')
        @endif
        </div>
    </div>
        
    @if ($request->get('type') == 'widget')
    @include('inc.widget-button')
     @endif
 </div>

@push('calculatorJS')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Keep any necessary UI initialization if needed
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.2/xlsx.full.min.js"></script>
    <script src="{{ url('js/html2pdf.bundle.js') }}"></script>
    <script>
        document.getElementById('save').addEventListener('click',function(){
            document.querySelector('.dowload_PDF_CSV').classList.toggle('hidden');
        });
        function downloadPDF(){
            var n = document.querySelector('.result');
            html2pdf().from(n).set({
                margin: [15, 5, 5, 5],
                filename: "Time Card Calculator Result by thetime-calculator.com.pdf",
                image: {
                    type: "jpeg",
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2,
                    logging: !0,
                    dpi: 192,
                    letterRendering: !0,
                },
                jsPDF: {
                    unit: "mm",
                    format: "a4",
                    orientation: "p"
                },
                pagebreak: {
                    before: ".page-break",
                    avoid: "table"
                },
            }).toPdf().get("pdf").then(function(e) {
                var t = e.internal.getNumberOfPages();
                for (let pageNumber = 1; pageNumber <= t; pageNumber++) {
                    e.setPage(pageNumber);
                    e.setFontSize(8);
                    e.setTextColor(150);
                    e.text(15, 15, "Results from");
                    e.setTextColor(0, 0, 255);
                    e.textWithLink(" thetimecalculator.org", 31, 15, {
                        url: "https://thetimecalculator.org/"
                    });
                    var allMathText = "thetimecalculator.og " + pageNumber + "/" + t;
                    var allMathTextWidth = e.getStringUnitWidth(allMathText) * 8;
                    e.textWithLink(allMathText, e.internal.pageSize.getWidth() - 65 - allMathTextWidth, e.internal.pageSize.getHeight() - 8, {
                        url: "https://thetimecalculator.org/"
                    });
                }
            }).save().catch((e)=>{});
        };
        
        document.getElementById('printpage').addEventListener('click', function() {
            var contentToPrint = document.querySelector('.printable-content').cloneNode(true);
            contentToPrint.querySelectorAll('input').forEach(function(input) {
                input.setAttribute('value', input.value);
            });

            var mywindow = window.open('', 'PRINT', 'height=1000,width=auto');
            mywindow.document.write('<html><head><title></title>');
            mywindow.document.write(
                `<style>
                    body * {
                        visibility: hidden;
                    }
                    .result, .result * {
                        visibility: visible;
                    }
                    .mobile-label {
                        display: none;
                    }
                    .mobile-label-total {
                        display: none;
                    }
                    #calculator {
                        width: 100% !important;
                        border-spacing: 0px;
                    }
                    #calculator tr, td {
                        border: 1px solid black !important;
                        color: black !important;
                        text-align: center !important;
                        padding: 8px;
                    }
                    .table-header {
                        background-color: white !important;
                    }
                    .bg-gradient {
                        background-color: white !important;
                    }
                    input[type="number"]::-webkit-inner-spin-button,
                    input[type="number"]::-webkit-outer-spin-button {
                        -webkit-appearance: none; /* Hides the up/down buttons */
                        margin: 0; /* Ensures no extra space is left */
                    }
                    .flex {
                        display: flex;
                    }
                    .justify-between {
                        justify-content: space-between;
                    }
                    input[type=number] {
                        width: 40px;
                        border: 0px;
                    }
                    .d-inline {
                        display: inline;
                    }
                    .mt-2 {
                        margin-top: 1rem;
                    }
                    .hidden {
                        display: none;
                    }
                    .d-block {
                        display: block;
                    }
                    .bg-gradient div {
                        border: 1px solid black;
                        padding: 5px;
                    }
                    .bg-gradient {
                        margin-top: 10px;
                    }
                    .col-md {
                        flex: 1 0 0%;
                    }
                </style>`
            );
            mywindow.document.write('</head><body>');
            mywindow.document.write(contentToPrint.outerHTML);
            mywindow.document.write(
                '<p>This Report is generated by <span style="color: #4277ac;"> <a href="{{ url()->current() }}">{{ url()->current() }}</a></span></p>'
            );
            mywindow.document.write('</body></html>');
            mywindow.document.close();
            mywindow.print();
            mywindow.close();
        });

        function generateExcel() {
            var workbook = XLSX.utils.book_new();
                var worksheet_data = [];
                worksheet_data.push([
                    "Name: ", document.getElementById('name').value, "Date: ", document.getElementById('date').value
                ]);
                worksheet_data.push([
                    "Day", "Starting Time", "Ending Time", "Break Deduction", "Total"
                ]);
                
                // Fetch data from Livewire component to generate excel
                // Note: Since this is purely client-side Excel generation, 
                // we might need to rely on the DOM or sync data.
                // For now, using query selectors.

                var rows = document.querySelectorAll('#calculator tbody tr:not(.table-header)');
                rows.forEach(function(row, index) {
                    var day = row.cells[0].innerText;
                    var inputs = row.querySelectorAll('input[type=number]');
                    var selects = row.querySelectorAll('select');
                    
                    var start = inputs[0].value + ":" + inputs[1].value + " " + selects[0].value;
                    var end = inputs[2].value + ":" + inputs[3].value + " " + selects[1].value;
                    var breakTime = inputs[4].value + ":" + inputs[5].value;
                    var total = row.querySelector('.fw-bold').innerText;

                    worksheet_data.push([day, start, end, breakTime, total]);
                });

                var finalTime = document.getElementById("finalTime").innerText.trim();
                var overtimePay = document.getElementById("overtime_pay") ? document.getElementById("overtime_pay").innerText.trim() : "N/A";
                var overtimeHours = document.getElementById("overtime_hours") ? document.getElementById("overtime_hours").innerText.trim() : "N/A";
                var grosPrice = document.getElementById("GrosPrice") ? document.getElementById("GrosPrice").innerText.trim() : "N/A";

                worksheet_data.push(["Total Hours = "+ finalTime,"Overtime Pay = "+ overtimePay,"Overtime Hours = "+ overtimeHours,"Total Gross Pay = "+ grosPrice]);

                var worksheet = XLSX.utils.aoa_to_sheet(worksheet_data);

                XLSX.utils.book_append_sheet(workbook, worksheet, "Sheet1");
                XLSX.writeFile(workbook, "WorkHours.xlsx");
        }
    </script>
@endpush
</div>
