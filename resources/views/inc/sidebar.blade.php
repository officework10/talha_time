



<div class="mt-4 border px-5 rounded-lg py-[10px]">
    <h2 class="text-lg font-semibold mb-2">Related</h2>
    <ul class="list-none list-inside pb-4">

@if ((!empty($related) || count($related) === '0'))
@foreach ($related as $key => $item)
    @if (is_numeric($key))
        @php
            if ($key==7) {
                break;
            }
        @endphp
        @php
            $value = explode('/', $item);
            if (count($value)<3) {
                continue;
            }
            $name = $value[0];
            $img = $value[1];
            $link = $value[2];
            if (count($value)>3) {
                $link = '';
                foreach ($value as $key => $value1) {
                    if ($key<2) {
                        continue;
                    }
                    $link .= '/'.$value1;
                }
            }
        @endphp
        @if ($link == "markup-calculator" || $link == "capm-calculator" || $link == "bond-price-calculator")
            @php
                continue;
            @endphp
        @endif
        @if($cal_name !== $name && $link !== "gematria-calculator")
            @php $link = str_replace('weight-loss-calculator','weightloss-calculator',$link); @endphp
            <li class="py-2">
                <a href="{{ url($link) }}/" class="hover:underline hover:text-blue-600">{{ $name }}</a>
                </li>
                <hr class="border-gray-400">


        @endif
    @endif
@endforeach
@else
@if ((!empty($auto_related) || count($auto_related) === '0'))
    @foreach ($auto_related as $key => $item)
        @if (is_numeric($key))
            @php
                $name = $item['cal_title'];
                $link = $item['cal_link'];
            @endphp
            @if ($link == "markup-calculator" || $link == "capm-calculator" || $link == "bond-price-calculator")
                @php
                    continue;
                @endphp
            @endif
            @if($cal_name !== $name  && $link !== "gematria-calculator")
                @php $link = str_replace('weight-loss-calculator','weightloss-calculator',$link); @endphp
                <div class=" justify-between px-2 py-5  border-[#DEDEDE] bg-white hover_border cursor-pointer items-center">
                    <a href="{{ url($link) }}/" class="flex justify-between items-center px-1">
                        <h3>{{ $name }}</h3>
                        <svg width="6" height="11" viewBox="0 0 6 11" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 10L6 5.5L1 1" stroke="#55be30" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>

            @endif
        @endif
    @endforeach
@endif
@endif

</ul>
</div>




