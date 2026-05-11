{{-- Result Button Ad (Near action buttons, hidden on mobile) --}}
<div class="w-full mt-1 hidden md:block">
    <div class="text-center" style="min-height: 125px; width: 728px; margin: 0 auto;">
        <span style="font-size: 12px; display: block;">ADVERTISEMENT</span>
        <ins class="adsbygoogle"
             style="display:inline-block; width:728px; height:90px"
             data-ad-client="ca-pub-7193082976988035"
             data-ad-slot="6892871433"
             data-ad-format="horizontal"
             data-full-width-responsive="true">
        </ins>
    </div>
</div>

@once
@push('scripts')
<script>
    (adsbygoogle = window.adsbygoogle || []).push({});
    
    // Click protection for result button ads
    (function() {
        let lastClickTime = 0;
        const adElements = document.querySelectorAll('.adsbygoogle');
        
        adElements.forEach(function(adEl) {
            adEl.addEventListener('click', function(e) {
                const now = Date.now();
                
                // Prevent multiple clicks within 10 seconds
                if (now - lastClickTime < 10000) {
                    e.preventDefault();
                    console.warn('Blocked multiple rapid ad clicks!');
                    return false;
                }
                
                lastClickTime = now;
            });
        });
    })();
</script>
@endpush
@endonce
