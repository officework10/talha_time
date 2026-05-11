{{-- Top Header Ad (728x90 banner, hidden on mobile) --}}
<div class="w-full mt-4 justify-center mb-3 hidden md:flex">
    <div class="text-center ad_text px-2" style="min-height: 125px; width: 728px;">
        <span style="font-size: 12px; display: block;">ADVERTISEMENT</span>
        <ins class="adsbygoogle"
             style="display:inline-block; width:728px; height:90px"
             data-ad-client="ca-pub-7193082976988035"
             data-ad-slot="2953626420">
        </ins>
    </div>
</div>

@once
@push('scripts')
<script>
    (adsbygoogle = window.adsbygoogle || []).push({});
    
    // Click protection for top header ads
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
