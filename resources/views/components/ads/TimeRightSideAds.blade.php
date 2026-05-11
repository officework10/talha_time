{{-- Right Side Ad (Sidebar ad, hidden on mobile) --}}
<div class="w-full mt-4 justify-center mb-3 hidden md:flex">
    <div class="w-full text-center ad_text px-2" style="min-height: 280px;">
        <span style="font-size: 12px; display: block;">ADVERTISEMENT</span>
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-client="ca-pub-7193082976988035"
             data-ad-slot="3424222100"
             data-ad-format="auto"
             data-full-width-responsive="true">
        </ins>
    </div>
</div>

@once
@push('scripts')
<script>
    (adsbygoogle = window.adsbygoogle || []).push({});
    
    // Click protection for right side ads
    (function() {
        let lastClickTime = 0;
        const adElements = document.querySelectorAll('.adsbygoogle');
        
        adElements.forEach(function(adEl) {
            adEl.addEventListener('click', function(e) {
                const now = Date.now();
                
                // Prevent multiple clicks within 10 seconds
                if (now - lastClickTime < 10000) {
                    e.preventDefault();
                    console.warn('Multiple ad clicks blocked!');
                    return false;
                }
                
                lastClickTime = now;
            });
        });
    })();
</script>
@endpush
@endonce