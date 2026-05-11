{{-- Top Header Category Ad (Category-specific header ad) --}}
<div class="w-full mt-4 hidden md:flex justify-center mb-3">
    <div class="text-center ad_text px-2" style="min-height: 125px; width: 728px; margin: 0 auto;">
        <span style="font-size: 12px; display: block;" class="ad_text">
            ADVERTISEMENT
        </span>
        <ins class="adsbygoogle"
             style="display:block; max-height: 100px;"
             data-ad-client="ca-pub-7193082976988035"
             data-ad-slot="1832116442"
             data-ad-format="horizontal"
             data-full-width-responsive="true">
        </ins>
    </div>
</div>

@once
@push('scripts')
<script>
    (adsbygoogle = window.adsbygoogle || []).push({});
    
    // Click protection for category header ads
    (function() {
        let lastClickTime = 0;
        const adElements = document.querySelectorAll('.adsbygoogle');
        
        adElements.forEach(function(adEl) {
            adEl.addEventListener('click', function(e) {
                const now = Date.now();
                
                // Block multiple clicks within 10 seconds
                if (now - lastClickTime < 10000) {
                    e.preventDefault();
                    console.warn('Multiple clicks blocked!');
                    return false;
                }
                
                lastClickTime = now;
            });
        });
    })();
</script>
@endpush
@endonce
