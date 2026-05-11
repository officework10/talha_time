<div class="shadow radius-10 mt-3">
    <p class="py-2 px-3 font-s-18 bg-gray radius-t-10"><strong>{{ isset($lang['related_cal']) ? $lang['related_cal'] : 'Related Tools' }}</strong></p>
    <div class="related px-3">
        @if ((!empty($related) || count($related) === '0'))
            @foreach ($related as $key => $item)
                @if (is_numeric($key))
                    @php
                        if ($key==7) {
                            break;
                        }
                    @endphp
                    @php
                        if (strpos($item, '//') !== false) {
                            $value = explode('//', $item);
                            $name = $value[0];
                            $link = $value[1];
                        } else {
                            $value = explode('/', $item);
                            if (count($value) < 3) continue;
                            $name = $value[0];
                            $link = $value[2];
                        }

                        if ($link == 'age-calculator') {
                            $link = 'calculate-age';
                        }
                    @endphp
                    <div class="d-flex align-items-center">
                        <strong class="font-s-25">-</strong>
                        <p class="py-2 font-s-15 ms-2 border-bottom w-fit">
                            <a href="{{ url($link) }}/" class="text-back text-decoration-none">{{ $name }}</a>
                        </p>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
</div>

