<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <meta name="description" content="@yield('meta_des')">
    <link rel="canonical" href="{{ url($page) }}/" />
    <link href="{{ url('favicon.webp') }}" rel="icon" type="image/x-icon"/>
    {{-- <link rel="stylesheet" href="{{ url('css/style.css?v=1.0.9') }}"> --}}
    <link href="{{ asset('css/style1.css')}}?v=0.0.2" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <meta name="robots" content="noindex">
    
</head>
<body>

    @section('content')
    @show
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script>
        let appLang = document.getElementById('appLang')
        if (appLang) {
            appLang.addEventListener('click', function() {
                document.querySelectorAll('.language').forEach(function(langElement) {
                    langElement.classList.toggle('d-none');
                });
            });
            document.addEventListener("click", function(event) {
                let appLang = document.getElementById('appLang');
                let languageElements = document.querySelectorAll('.language');
                
                let targetElement = event.target;
                let isClickInsideAppLang = appLang.contains(targetElement);
    
                if (!isClickInsideAppLang) {
                    languageElements.forEach(function(langElement) {
                        langElement.classList.add("d-none");
                    });
                }
            });
        }

        let scrollTo = document.querySelector('.result');
        if (scrollTo) {
            let container = document.documentElement || document.body; 
            let scrollAmount = scrollTo.offsetTop - container.getBoundingClientRect().top + container.scrollTop;
            container.scrollTo({
                top: scrollAmount,
                behavior: 'smooth'
            });
        }
        function copyElementText(className) {
            let text = document.querySelector(className).innerText;
            let elem = document.createElement("textarea");
            document.body.appendChild(elem);
            elem.value = text;
            elem.select();
            document.execCommand("copy");
            document.body.removeChild(elem);
        }
        function copyResult(){
            copyElementText('.result');
            var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
        }
        function printDiv(divId) {
            var printContents = document.querySelector(divId).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }

        let input_unit = document.querySelectorAll('.input-unit')
        if (input_unit) {
            input_unit.forEach(function(element) {
                element.addEventListener('click', function() {
                    let forAttr = this.getAttribute('for');
                    document.querySelector('.' + forAttr).classList.toggle('d-none');
                });
            });
        }
        let units = document.querySelectorAll('.units p')
        if (units) {
            units.forEach(function(element) {
                element.addEventListener('click', function() {
                    let toAttr = this.closest('.units').getAttribute('to');
                    let val = this.getAttribute('value');
                    document.querySelector('[for="' + toAttr + '"]').textContent = val + ' ▾';
                    document.getElementById(toAttr).value = val;
                    document.querySelector('.' + toAttr).classList.toggle('d-none');
                });
            });
        }
        function toggleMenu(){
            document.querySelector('.mobile-menu').classList.toggle('left-0');
            document.querySelector('.sidenav-overlay').classList.toggle('show-overlay');
            document.body.classList.toggle('overflow-hidden');
        }
        document.addEventListener("click", function(event) {
            let units = document.querySelectorAll('.units');
            let inputUnits = document.querySelectorAll('.input-unit');
            let inputHidden = document.querySelectorAll('input.d-none');
            let target = event.target;
            let isClickedInsideUnits = false;
            let isClickedInsideInputUnits = false;

            inputHidden.forEach(function(d_none) {
                if (d_none.contains(target)) {
                    isClickedInsideUnits = true;
                }
            });

            inputUnits.forEach(function(inputUnit) {
                if (inputUnit.contains(target)) {
                    isClickedInsideInputUnits = true;
                }
            });

            if (!isClickedInsideUnits && !isClickedInsideInputUnits) {
                units.forEach(function(unit) {
                    unit.classList.add('d-none');
                });
            }
        });
    </script>

    
<script>
    function toggleDropdown(id) {
        const dropdown = document.getElementById(id);
        dropdown.classList.toggle('hidden');
    }
    
    function setUnit(inputId, value) {
        document.getElementById(inputId).value = value;
        document.querySelector(`label[for="${inputId}"]`).textContent = value + ' ▾';
        toggleDropdown(inputId + '_dropdown');
    }
    
    // Close all open dropdowns when clicking outside
    document.addEventListener('click', function (event) {
        // Get all dropdowns
        const dropdowns = document.querySelectorAll('.dropdown');
    
        dropdowns.forEach(dropdown => {
            // If the click is outside the dropdown and the input, close the dropdown
            if (!dropdown.contains(event.target) && !dropdown.previousElementSibling.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });
    });
</script>


    @stack('calculatorJS')
</body>
</html>