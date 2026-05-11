@extends('layouts.app')
@section('title', $meta_title)
@section('meta_des', $meta_des)

@section('content')

<!-- Main Container -->
<div class="container-fluid mx-auto container-fluid mt-[20px]">
    
  {{-- Category Header Ad --}}
        @include('components.ads.TimeTopHeaderCategoryAds')
    <!-- Header Section -->
    <div class="w-full max-w-6xl mx-auto rounded-lg text-center mt-5">
        <!-- Page Title -->
        <h1 class="text-2xl lg:text-4xl md:text-4xl font-semibold">Blogs</h1>
        <p class="text-1xl lg:text-2xl md:text-2xl mt-2">Read and get your concept strong</p>
    </div>

    <!-- Blog Grid Section -->
    <div class="flex flex-col items-center py-8">
        <div class="w-full max-w-6xl mx-auto rounded-lg">
            <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">

                <!-- Blog Card 1: Remote Work Time Management Tips -->
                    @if($posts)
                @forelse ($posts as $post)
                <a href="{{ rtrim(url('blog/' . $post->post_url), '/') }}/" data-discover="true">
                    <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition-shadow duration-300 h-full flex flex-col">
                        <div class="rounded-t-2xl overflow-hidden p-4">
                            <img loading="lazy" 
                                 src="{{ file_exists(public_path('images/' . $post->post_img)) ? url('images/' . $post->post_img) : url('images/blogs/' . $post->post_img) }}" 
                                 alt="{{ $post->post_title }}" 
                                 class="w-full h-48 object-cover transform hover:scale-105 transition-transform duration-300">
                        </div>
                        <div class="p-4">
                            <h2 class="font-bold text-lg mb-2" style="min-height: 60px;"> {{ \Illuminate\Support\Str::limit($post->post_title, 50, $end = '...') }} </h2>
                            <p class="text-gray-600 text-sm" style="min-height: 50px;"> {{ \Illuminate\Support\Str::limit($post->short_des, 68, $end = '...') }} </p>
                        </div>
                    </div>
                </a>
                   @empty
                <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 max-w-5xl mx-auto text-center">
                   <p class="text-center text-red-900"> Not Available</p>
                </div>
                @endforelse
                @endif


            </div>
        </div>
    </div>
</div>

@endsection
