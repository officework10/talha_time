@extends('layouts.app')
@section('title', $meta_title)
@section('meta_des', $meta_des)

@section('content')

<!-- Main Container (with Share Modal integrated) -->
<div x-data="{ shareModalOpen: false }" @keydown.escape.window="shareModalOpen = false">
<div class="container-fluid mx-auto mt-[20px]">
      {{-- Category Header Ad --}}
        <!-- @include('components.ads.TimeTopHeaderCategoryAds') -->
    
    <!-- Page Header -->
    <div class="w-full max-w-7xl mx-auto rounded-lg text-center  mt-[40px]">
        <h1 class="text-2xl lg:text-4xl md:text-4xl font-semibold">Blogs </h1>
        <p class="text-gray-600 mt-2">{{ $post->post_title }}</p>
    </div>

    <!-- Main Content Area -->
    <div class="container mx-auto w-full max-w-screen-xl bg-white text-black">
        <div class="flex flex-wrap w-full">
            
            <!-- Left Column: Blog Content (70%) -->
            <div class="w-full lg:w-[70%] sm:w-full pt-4">
                
                <!-- Featured Image -->
                <div class="w-full p-4 rounded-md">
                    <img loading="lazy" 
                         class="rounded-t-lg w-full" 
                         src="{{ file_exists(public_path('images/' . $post->post_img)) ? url('images/' . $post->post_img) : url('images/blogs/' . $post->post_img) }}" 
                         alt="{{ $post->post_title }}" 
                         width="100%" 
                         height="auto">
                </div>

                    {{-- Category Header Ad --}}
                     <!-- @include('components.ads.TimeDescriptionAds') -->
                <!-- Blog Content -->
                <div class="w-full pt-4 px-4 mb-[20px] contentAll">
                    {!! $post->post_des !!}
                </div>

            </div>

            <!-- Right Column: Sidebar (30%) -->
            <div class="w-full lg:w-[30%] sm:w-full p-4">
                <!-- Recent Posts Widget -->
                <div class="mt-4 border border-gray-200 rounded-[10px] px-5 py-[10px]">
                    <div class="flex justify-between items-center mb-2">
                        <h2 class="text-lg font-semibold">Recent Posts</h2>
                    </div>
                    
                    <ul class="list-none list-inside max-h-full overflow-auto transition-all duration-500">
                        <hr class="border-gray-400">
                        @forelse($posts ?? [] as $recentPost)
                        <li class="py-2 flex items-center gap-4">
                            <img loading="lazy" 
                                 src="{{ file_exists(public_path('images/' . $recentPost->post_img)) ? url('images/' . $recentPost->post_img) : url('images/blogs/' . $recentPost->post_img) }}" 
                                 alt="{{ $recentPost->post_title }}" 
                                 class="w-16 h-16 rounded-md object-cover">
                            <a class="hover:underline hover:text-blue-600" 
                               href="{{ url('blog/' . $recentPost->post_url) }}" 
                               data-discover="true">
                                {{ \Illuminate\Support\Str::limit($recentPost->post_title, 50, $end = '...') }}
                            </a>
                        </li>
                        <hr class="border-gray-400">
                        @empty
                        <li class="py-2 text-center text-gray-500">No recent posts</li>
                        @endforelse
                    </ul>
                </div>
                  @include('components.ads.TimeRelatedBottomAds')

            </div>

        </div>
    </div>

    <!-- Share Article Section -->
    <section class="Blogs py-4 flex flex-col items-center justify-center">
        <div class="container lg:px-[40px] md:px-[40px] px-[15px]">
            <div class="row flex flex-col items-center justify-center">
                
                <!-- Share Title -->
                <div class="shareArticle text-center mx-auto">
                    <h2 class="text-gray-900 text-2xl font-bold">Share Article</h2>
                    
                    <!-- Social Media Icons -->
                    <ul class="flex justify-center items-center flex-wrap my-4 space-x-3">
                        <li class="lg:px-2 md:px-2">
                            <a href="mailto:?subject={{ urlencode($post->post_title) }}&body={{ urlencode(rtrim(url()->current(), '/') . '/') }}" target="_blank">
                                <img loading="lazy" 
                                     src="data:image/svg+xml,%3csvg%20width='48'%20height='49'%20viewBox='0%200%2048%2049'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3cpath%20d='M24%2048.2798C10.7452%2048.2798%200%2037.5346%200%2024.2798C0%2011.025%2010.7452%200.279785%2024%200.279785C37.2548%200.279785%2048%2011.025%2048%2024.2798C48%2037.5346%2037.2548%2048.2798%2024%2048.2798Z'%20fill='%232196F3'/%3e%3cpath%20d='M24.0056%2025.4648L36.6562%2019.1535V31.6935C36.6545%2032.3292%2036.4012%2032.9384%2035.9517%2033.388C35.5021%2033.8375%2034.8929%2034.0908%2034.2572%2034.0926H13.7428C13.1071%2034.0908%2012.4979%2033.8375%2012.0483%2033.388C11.5988%2032.9384%2011.3455%2032.3292%2011.3438%2031.6935V19.2857L24.0056%2025.4648Z'%20fill='white'/%3e%3cpath%20d='M23.9944%2023.0948L11.3438%2016.9204V16.866C11.3455%2016.2303%2011.5988%2015.6211%2012.0483%2015.1716C12.4979%2014.722%2013.1071%2014.4687%2013.7428%2014.467H34.2572C34.8783%2014.4682%2035.4749%2014.7096%2035.922%2015.1407C36.3692%2015.5718%2036.6323%2016.1591%2036.6562%2016.7798L23.9944%2023.0948Z'%20fill='white'/%3e%3c/svg%3e" 
                                     alt="Email" 
                                     class="w-12 h-12 cursor-pointer">
                            </a>
                        </li>
                        <li class="lg:px-2 md:px-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(rtrim(url()->current(), '/') . '/') }}" target="_blank">
                                <img loading="lazy" 
                                     src="data:image/svg+xml,%3csvg%20width='48'%20height='49'%20viewBox='0%200%2048%2049'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3cpath%20d='M48%2024.2798C48%2036.2592%2039.2231%2046.1882%2027.75%2047.9882V31.2173H33.3422L34.4062%2024.2798H27.75V19.7779C27.75%2017.8795%2028.68%2016.0298%2031.6613%2016.0298H34.6875V10.1235C34.6875%2010.1235%2031.9406%209.65479%2029.3147%209.65479C23.8331%209.65479%2020.25%2012.9773%2020.25%2018.9923V24.2798H14.1562V31.2173H20.25V47.9882C8.77688%2046.1882%200%2036.2592%200%2024.2798C0%2011.0254%2010.7456%200.279785%2024%200.279785C37.2544%200.279785%2048%2011.0254%2048%2024.2798Z'%20fill='%231877F2'/%3e%3cpath%20d='M33.3422%2031.2173L34.4062%2024.2798H27.75V19.7778C27.75%2017.8798%2028.6798%2016.0298%2031.6612%2016.0298H34.6875V10.1235C34.6875%2010.1235%2031.941%209.65479%2029.3152%209.65479C23.833%209.65479%2020.25%2012.9773%2020.25%2018.9923V24.2798H14.1562V31.2173H20.25V47.9881C21.4719%2048.1798%2022.7242%2048.2798%2024%2048.2798C25.2758%2048.2798%2026.5281%2048.1798%2027.75%2047.9881V31.2173H33.3422Z'%20fill='white'/%3e%3c/svg%3e" 
                                     alt="Facebook" 
                                     class="w-12 h-12 cursor-pointer">
                            </a>
                        </li>
                        <li class="lg:px-2 md:px-2">
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(rtrim(url()->current(), '/') . '/') }}&title={{ urlencode($post->post_title) }}" target="_blank">
                                <img loading="lazy" 
                                     src="data:image/svg+xml,%3csvg%20width='48'%20height='49'%20viewBox='0%200%2048%2049'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3cpath%20d='M24%2048.2798C37.2548%2048.2798%2048%2037.5346%2048%2024.2798C48%2011.025%2037.2548%200.279785%2024%200.279785C10.7452%200.279785%200%2011.025%200%2024.2798C0%2037.5346%2010.7452%2048.2798%2024%2048.2798Z'%20fill='%230B69C7'/%3e%3cpath%20d='M18.632%2015.5545C18.6326%2016.2031%2018.4408%2016.8373%2018.0809%2017.3768C17.7209%2017.9163%2017.209%2018.337%2016.6099%2018.5855C16.0108%2018.8339%2015.3515%2018.8991%2014.7154%2018.7727C14.0792%2018.6464%2013.4949%2018.3341%2013.0362%2017.8755C12.5776%2017.4169%2012.2654%2016.8325%2012.139%2016.1964C12.0126%2015.5602%2012.0778%2014.9009%2012.3263%2014.3018C12.5748%2013.7027%2012.9954%2013.1908%2013.5349%2012.8309C14.0745%2012.471%2014.7087%2012.2792%2015.3572%2012.2798C16.2255%2012.2806%2017.0579%2012.6259%2017.6719%2013.2399C18.2858%2013.8538%2018.6311%2014.6863%2018.632%2015.5545Z'%20fill='white'/%3e%3cpath%20d='M17.0823%2020.1965H13.6338C13.1856%2020.1965%2012.8223%2020.5599%2012.8223%2021.0081V35.4681C12.8223%2035.9163%2013.1856%2036.2797%2013.6338%2036.2797H17.0823C17.5305%2036.2797%2017.8938%2035.9163%2017.8938%2035.4681V21.0081C17.8938%2020.5599%2017.5305%2020.1965%2017.0823%2020.1965Z'%20fill='white'/%3e%3cpath%20d='M35.9211%2028.5334V35.5345C35.9211%2035.7321%2035.8425%2035.9217%2035.7028%2036.0614C35.563%2036.2012%2035.3734%2036.2797%2035.1758%2036.2797H31.4747C31.2771%2036.2797%2031.0875%2036.2012%2030.9478%2036.0614C30.808%2035.9217%2030.7295%2035.7321%2030.7295%2035.5345V28.7513C30.7295%2027.7376%2031.0232%2024.3302%2028.0832%2024.3302C25.8032%2024.3302%2025.3389%2026.6734%2025.2411%2027.725V35.5502C25.237%2035.7441%2025.1575%2035.9287%2025.0195%2036.0648C24.8816%2036.201%2024.696%2036.2781%2024.5021%2036.2797H20.9211C20.8231%2036.2801%2020.726%2036.2611%2020.6354%2036.2238C20.5448%2036.1865%2020.4624%2036.1317%2020.3931%2036.0624C20.3239%2035.9931%2020.269%2035.9108%2020.2317%2035.8201C20.1944%2035.7295%2020.1754%2035.6324%2020.1758%2035.5345V20.945C20.1754%2020.8468%2020.1943%2020.7496%2020.2316%2020.6588C20.2689%2020.568%2020.3237%2020.4855%2020.393%2020.416C20.4622%2020.3464%2020.5445%2020.2912%2020.6351%2020.2536C20.7257%2020.2159%2020.8229%2020.1966%2020.9211%2020.1966H24.5021C24.6014%2020.1949%2024.7001%2020.213%2024.7924%2020.2499C24.8847%2020.2867%2024.9687%2020.3416%2025.0395%2020.4113C25.1103%2020.4809%2025.1666%2020.564%2025.205%2020.6556C25.2434%2020.7473%2025.2632%2020.8456%2025.2632%2020.945V22.2081C26.1095%2020.945%2027.3663%2019.9597%2030.0411%2019.9597C35.9558%2019.9566%2035.9211%2025.4924%2035.9211%2028.5334Z'%20fill='white'/%3e%3c/svg%3e" 
                                     alt="LinkedIn" 
                                     class="w-12 h-12 cursor-pointer">
                            </a>
                        </li>
                        <li class="lg:px-2 md:px-2">
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(rtrim(url()->current(), '/') . '/') }}&text={{ urlencode($post->post_title) }}" target="_blank">
                                <img loading="lazy" 
                                     src="data:image/svg+xml,%3csvg%20width='48'%20height='49'%20viewBox='0%200%2048%2049'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3cpath%20d='M24%2048.2798C37.2548%2048.2798%2048%2037.5346%2048%2024.2798C48%2011.025%2037.2548%200.279785%2024%200.279785C10.7452%200.279785%200%2011.025%200%2024.2798C0%2037.5346%2010.7452%2048.2798%2024%2048.2798Z'%20fill='%2303A9F4'/%3e%3cpath%20d='M39.546%2014.6389C38.3767%2015.1496%2037.1397%2015.4889%2035.8734%2015.6462C37.2083%2014.8547%2038.2061%2013.6006%2038.6776%2012.122C37.4282%2012.8636%2036.0611%2013.3859%2034.6355%2013.6662C33.7619%2012.732%2032.6274%2012.0822%2031.3795%2011.8015C30.1317%2011.5207%2028.8282%2011.622%2027.6386%2012.0921C26.4491%2012.5622%2025.4285%2013.3793%2024.7097%2014.4373C23.9909%2015.4953%2023.6071%2016.7451%2023.6082%2018.0241C23.6037%2018.5123%2023.6534%2018.9995%2023.7566%2019.4768C21.2207%2019.3522%2018.7396%2018.6941%2016.4754%2017.5454C14.2112%2016.3967%2012.2148%2014.7832%2010.6166%2012.8104C9.79508%2014.2138%209.54057%2015.878%209.90507%2017.4628C10.2696%2019.0476%2011.2256%2020.4333%2012.5776%2021.3368C11.5684%2021.3096%2010.5806%2021.0399%209.69763%2020.5504V20.6199C9.70047%2022.091%2010.2096%2023.5162%2011.1396%2024.656C12.0695%2025.7958%2013.3634%2026.5807%2014.8039%2026.8789C14.2588%2027.0221%2013.697%2027.0922%2013.1334%2027.0873C12.7276%2027.0948%2012.3221%2027.0588%2011.9239%2026.9799C12.3366%2028.245%2013.1312%2029.3512%2014.1983%2030.1463C15.2654%2030.9414%2016.5526%2031.3863%2017.8829%2031.4199C15.6285%2033.182%2012.8494%2034.1391%209.98815%2034.1389C9.47834%2034.1432%208.96879%2034.1137%208.46289%2034.0504C11.3804%2035.9315%2014.7811%2036.9254%2018.2524%2036.9115C29.9839%2036.9115%2036.3976%2027.1947%2036.3976%2018.7726C36.3976%2018.4915%2036.3976%2018.2199%2036.3755%2017.9483C37.6246%2017.0469%2038.699%2015.9254%2039.546%2014.6389Z'%20fill='white'/%3e%3c/svg%3e" 
                                     alt="Twitter" 
                                     class="w-12 h-12 cursor-pointer">
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Copy URL Widget -->
                <div class="shareArticle w-[95%] lg:w-1/2 md:w-1/2">
                    <div class="col-lg-8 mx-auto">
                        <div class="relative">
                            <input type="text" 
                                   readonly="" 
                                   class="p-3 pr-20 w-full bg-gray-200 rounded-lg text-gray-900 placeholder-gray-900 font-semibold" 
                                   value="{{ rtrim(url()->current(), '/') }}/">
                            <button onclick="navigator.clipboard.writeText('{{ rtrim(url()->current(), '/') }}/').then(() => alert('Link copied!'))" class="absolute top-9 right-0 transform -translate-y-1/2 border-none cursor-pointer">
                                <img loading="lazy" 
                                     src="data:image/svg+xml,%3csvg%20width='21'%20height='24'%20viewBox='0%200%2021%2024'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3cpath%20d='M13.2042%2023.2798H3.89791C1.74854%2023.2798%200%2021.6677%200%2019.686V7.51221C0%205.53056%201.74854%203.91846%203.89791%203.91846H13.2042C15.3535%203.91846%2017.1021%205.53056%2017.1021%207.51221V19.686C17.1021%2021.6677%2015.3535%2023.2798%2013.2042%2023.2798ZM3.89791%205.71533C2.82332%205.71533%201.94896%206.52147%201.94896%207.51221V19.686C1.94896%2020.6768%202.82332%2021.4829%203.89791%2021.4829H13.2042C14.2788%2021.4829%2015.1531%2020.6768%2015.1531%2019.686V7.51221C15.1531%206.52147%2014.2788%205.71533%2013.2042%205.71533H3.89791ZM21%2017.4399V3.87354C21%201.89188%2019.2515%200.279785%2017.1021%200.279785H6.28538C5.74714%200.279785%205.3109%200.681976%205.3109%201.17822C5.3109%201.67447%205.74714%202.07666%206.28538%202.07666H17.1021C18.1767%202.07666%2019.051%202.8828%2019.051%203.87354V17.4399C19.051%2017.9362%2019.4873%2018.3384%2020.0255%2018.3384C20.5638%2018.3384%2021%2017.9362%2021%2017.4399Z'%20fill='%234177EB'/%3e%3c/svg%3e" 
                                     alt="Copy" 
                                     class="me-2" 
                                     width="21" 
                                     height="23">
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

</div>

    <!-- Share Modal -->
    <div x-show="shareModalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50" style="display: none;">
        <div @click.outside="shareModalOpen = false" class="relative bg-white rounded-lg shadow-lg p-6 max-w-md w-full">
            <button @click="shareModalOpen = false" class="absolute top-3 right-3 text-gray-500 hover:text-black">×</button>
            <p class="text-xl font-bold text-center mb-4">Share the Blog</p>
            <div class="flex justify-center space-x-4 mb-6">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(rtrim(url()->current(), '/') . '/') }}" target="_blank" class="bg-blue-600 rounded-full p-2 text-white hover:bg-blue-700">FB</a>
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(rtrim(url()->current(), '/') . '/') }}&text={{ urlencode($post->post_title) }}" target="_blank" class="bg-blue-400 rounded-full p-2 text-white hover:bg-blue-500">TW</a>
                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(rtrim(url()->current(), '/') . '/') }}" target="_blank" class="bg-blue-500 rounded-full p-2 text-white hover:bg-blue-600">IN</a>
            </div>
            <div class="flex items-center bg-gray-100 p-3 rounded-lg">
                <input type="text" value="{{ rtrim(url()->current(), '/') }}/" class="flex-grow bg-transparent border-none text-gray-600 px-4" readonly>
                <button onclick="navigator.clipboard.writeText('{{ rtrim(url()->current(), '/') }}/');alert('Copied!')" class="ml-2 text-white bg-green-500 rounded-lg px-2 py-1">Copy</button>
            </div>
        </div>
    </div>

</div> <!-- Close x-data div -->

@endsection

@push('calculatorJS')
  
@endpush
