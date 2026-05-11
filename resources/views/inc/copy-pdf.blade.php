@push('pdf-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
@endpush

<div class="flex justify-between items-center pb-2 border-b-2 border-b-black">
    <p class="text-blue text-2xl font-semibold">{{ $lang['res'] ?? "Result" }}</p>

    <div class="flex items-center">
        <div class="flex justify-end items-center space-x-3 pb-2">
            <img src="{{ asset('assets/icons/copy.svg') }}" alt="Copy Result" title="Copy Result"
                class="w-5 h-5 cursor-pointer" onclick="copyResult()">

            <img src="{{ asset('assets/icons/printer.svg') }}" alt="Print Result" title="Print Result"
                class="w-5 h-5 cursor-pointer" onclick="printResult()">

            <img src="{{ asset('assets/icons/downloads.svg') }}" alt="Download PDF" title="Download PDF"
                class="w-5 h-5 cursor-pointer" onclick="downloadPDF()">
        </div>
    </div>
</div>


<div id="toast"
    class="fixed top-5 right-5 z-50 bg-black text-white px-4 py-2 rounded shadow-lg opacity-0 transition-opacity duration-300 text-sm"
    style="pointer-events: none;">
</div>
