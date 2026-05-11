<?php

namespace App\Livewire\Blog;

use Livewire\Component;

class ShareModal extends Component
{
    public $show = false;
    public $pageUrl;
    public $post_id, $post_title, $post_des, $post_cat, $post_time, $post_url, $meta_title, $meta_des, $post_img, $short_des, $show_hide;

    public function mount($post_id, $post_title, $post_des, $post_cat, $post_time, $post_url, $meta_title, $meta_des, $post_img, $short_des, $show_hide, $pageUrl)
    {
        $this->post_id = $post_id;
        $this->post_title = $post_title;
        $this->post_des = $post_des;
        $this->post_cat = $post_cat;
        $this->post_time = $post_time;
        $this->post_url = $post_url;
        $this->meta_title = $meta_title;
        $this->meta_des = $meta_des;
        $this->post_img = $post_img;
        $this->short_des = $short_des;
        $this->show_hide = $show_hide;
        $this->pageUrl = $pageUrl;
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
        return view('livewire.blog.share-modal');
    }
}
