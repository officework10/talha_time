<?php

namespace App\Livewire\Component;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class CalculatorResultActions extends Component
{
    public $detail;
    public $calculatorName;
    public $calculatorLink;
    public $show = false;
    public $pageUrl;

    public function mount($detail = null, $calculatorName = null, $calculatorLink = null, $pageUrl = null)
    {
        $this->detail = $detail;
        $this->calculatorName = $calculatorName;
        $this->calculatorLink = $calculatorLink;
        $this->pageUrl = $pageUrl;
    }

    public function submitFeedback($type)
    {
        // dd($this->calculatorName,$this->calculatorLink,$type);
        try {
            DB::table('user_responses')->insert([
                'feedback' => $type,
                'calculator_name' => $this->calculatorName,
                'page' => $this->calculatorLink,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $message = $type === 'like' ? '👍 Thanks for your feedback!' : '👍 Thanks for your feedback!';

            // Trigger success state
            $this->dispatch('feedbackSaved');

            // Show toast - USING THE CORRECT EVENT NAME
            $this->dispatch('showToast', message: $message);
        } catch (\Exception $e) {
            $this->dispatch('showToast', message: 'Failed to save feedback');
        }
    }



    public function openShareModal()
    {
        $this->show = true;
    }

    public function closeShareModal()
    {
        $this->show = false;
    }

    public function copyLink()
    {
        $this->dispatch('link-copied'); // emits a frontend event
    }


    public function share($platform)
    {
        $encodedUrl = urlencode($this->pageUrl);
        $shareLinks = [
            'facebook' => "https://www.facebook.com/sharer/sharer.php?u={$encodedUrl}",
            'twitter' => "https://twitter.com/intent/tweet?url={$encodedUrl}",
            'linkedin' => "https://www.linkedin.com/sharing/share-offsite/?url={$encodedUrl}",
            'email' => "mailto:?subject=Check this blog&body={$encodedUrl}",
        ];

        if (isset($shareLinks[$platform])) {
            $this->dispatch('open-share-link', url: $shareLinks[$platform]);
        }
    }


    public function render()
    {
        return view('livewire.component.calculator-result-actions');
    }
}
