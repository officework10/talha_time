<div class="lg:max-w-[70%] md:max-w-[80%] max-w-[100%] mx-auto   mb-10 px-5">
    <h2 class="text-3xl font-bold text-center">FAQs</h2>
    <p class="text-center text-gray-600 mt-2">Have Any Question? You Got Answer Here.</p>
    <div class="mt-8 space-y-4">
        <!-- FAQ Item -->
        <div class="border-b">
            <div class="w-full text-left py-4 flex justify-between items-center focus:outline-none faq-toggle">
                <span class="text-lg font-medium">Lorem ipsum dolor sit amet consectetur elementum ut?</span>
                <div
                    class="text-xl px-2 text-blue-500 bg-blue-200 rounded-full transition-transform transform rotate-0 faq-icon">+</div>
            </div>
            <div class="faq-content hidden text-gray-600 pb-4">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et
                dolore magna aliqua.
            </div>
        </div>
        <!-- Another FAQ Item -->
        <div class="border-b">
            <div class="w-full text-left py-4 flex justify-between items-center focus:outline-none faq-toggle">
                <span class="text-lg font-medium">Lorem ipsum dolor sit amet consectetur?</span>
                <div
                    class="text-xl px-2 text-blue-500 bg-blue-200 rounded-full transition-transform transform rotate-0 faq-icon">+</div>
            </div>


            <div class="faq-content hidden text-gray-600 pb-4">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et
                dolore magna aliqua.
            </div>
        </div>
        <!-- Another FAQ Item -->
        <div class="border-b">
            <div class="w-full text-left py-4 flex justify-between items-center focus:outline-none faq-toggle">
                <span class="text-lg font-medium">Lorem ipsum dolor sit amet consectetur?</span>
                <div
                    class="text-xl px-2 text-blue-500 bg-blue-200 rounded-full transition-transform transform rotate-0 faq-icon">+</div>
            </div>
            <div class="faq-content hidden text-gray-600 pb-4">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et
                dolore magna aliqua.
            </div>
        </div>
        <!-- Another FAQ Item -->
        <div class="border-b">
            <div class="w-full text-left py-4 flex justify-between items-center focus:outline-none faq-toggle">
                <span class="text-lg font-medium">Lorem ipsum dolor sit amet consectetur?</span>
                <div
                    class="text-xl px-2 text-blue-500 bg-blue-200 rounded-full transition-transform transform rotate-0 faq-icon">+</div>
            </div>
            <div class="faq-content hidden text-gray-600 pb-4">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et
                dolore magna aliqua.
            </div>
        </div>
        <!-- Another FAQ Item -->
        <div class="border-b">
            <div class="w-full text-left py-4 flex justify-between items-center focus:outline-none faq-toggle">
                <span class="text-lg font-medium">Lorem ipsum dolor sit amet consectetur?</span>
                <div
                    class="text-xl  px-2 text-blue-500 bg-blue-200 rounded-full transition-transform transform rotate-0 faq-icon">+</div>
            </div>
            <div class="faq-content hidden text-gray-600 pb-4">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et
                dolore magna aliqua.
            </div>
        </div>
        <!-- Another FAQ Item -->
        <div class="border-b">
            <div class="w-full text-left py-4 flex justify-between items-center focus:outline-none faq-toggle">
                <span class="text-lg font-medium">Lorem ipsum dolor sit amet consectetur?</span>
                <div
                    class="text-xl  px-2 text-blue-500 bg-blue-200 rounded-full transition-transform transform rotate-0 faq-icon">+</div>
            </div>
            <div class="faq-content hidden text-gray-600 pb-4">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et
                dolore magna aliqua.
            </div>
        </div>
        <!-- Additional FAQ items as needed -->
    </div>
</div>

<script>
    let activeFAQ = null; // Track the currently active FAQ

    document.querySelectorAll('.faq-toggle').forEach((div) => {
        div.addEventListener('click', () => {
            const currentFaqContent = div.nextElementSibling;
            const currentFaqIcon = div.querySelector('.faq-icon');

            // Close the currently active FAQ if it exists and is not the one clicked
            if (activeFAQ && activeFAQ !== currentFaqContent) {
                activeFAQ.classList.add('hidden');
                activeFAQ.previousElementSibling.querySelector('.faq-icon').classList.remove(
                    'rotate-45');
            }

            // Toggle the clicked FAQ
            if (currentFaqContent !== activeFAQ) {
                currentFaqContent.classList.remove('hidden');
                currentFaqIcon.classList.add('rotate-25');
                activeFAQ = currentFaqContent;
            } else {
                // If the clicked FAQ is already open, close it
                currentFaqContent.classList.add('hidden');
                currentFaqIcon.classList.remove('rotate-25');
                activeFAQ = null;
            }
        });
    });
</script>
