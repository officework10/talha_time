{{-- Related Top Ad (Top section ad with click protection) --}}
<div class="w-full  mt-4">
    <div class="w-full text-center" style="min-height: 280px;">
        <span style="font-size: 12px; display: block;" class="ad_text">
            ADVERTISEMENT
        </span>
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-client="ca-pub-7193082976988035"
             data-ad-slot="1832116442"
             data-ad-format="auto"
             data-full-width-responsive="true">
        </ins>
    </div>
</div>

@once
@push('scripts')
<script>
    (adsbygoogle = window.adsbygoogle || []).push({});
    
    // Click protection for related top ads
    (function() {
        let lastClickTime = 0;
        const adElements = document.querySelectorAll('.adsbygoogle');
        
        adElements.forEach(function(adEl) {
            adEl.addEventListener('click', function(e) {
                const now = Date.now();
                
                // Prevent clicks within 10 seconds
                if (now - lastClickTime < 10000) {
                    e.preventDefault();
                    console.warn('⚠️ Multiple ad clicks blocked!');
                    return false;
                }
                
                lastClickTime = now;
            });
        });
    })();
</script>
@endpush
@endonce
