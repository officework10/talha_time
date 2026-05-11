<?php

namespace App\Livewire;

use Livewire\Component;

class GoogleAds extends Component
{
    public $adSlot;
    public $adFormat;
    public $adClient;
    public $fullWidthResponsive = true;
    public $adStyle = '';
    public $containerClass = '';

    /**
     * Mount the component with ad configuration
     * 
     * @param string $adSlot Google AdSense ad slot ID
     * @param string $adFormat Ad format (auto, rectangle, horizontal, vertical)
     * @param string $adClient Google AdSense client ID (optional, defaults to env)
     * @param bool $fullWidthResponsive Enable full width responsive ads
     * @param string $adStyle Custom inline styles for the ad
     * @param string $containerClass Additional CSS classes for the container
     */
    public function mount(
        $adSlot = '',
        $adFormat = 'auto',
        $adClient = null,
        $fullWidthResponsive = true,
        $adStyle = '',
        $containerClass = ''
    ) {
        $this->adSlot = $adSlot;
        $this->adFormat = $adFormat;
        $this->adClient = $adClient ?? config('services.google_adsense.client_id', '');
        $this->fullWidthResponsive = $fullWidthResponsive;
        $this->adStyle = $adStyle;
        $this->containerClass = $containerClass;
    }

    public function render()
    {
        return view('livewire.google-ads');
    }
}
