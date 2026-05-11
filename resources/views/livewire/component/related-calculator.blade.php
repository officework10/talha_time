
<div class="border px-5 rounded-lg py-[10px]">
    <h2 class="text-lg font-semibold mb-2">Related</h2>
    <ul class="list-none list-inside pb-4">
        @php
            $relatedItems = is_string($relatedCal) ? json_decode($relatedCal, true) : $relatedCal;
         
        @endphp

        @if (!empty($relatedItems))
            @foreach ($relatedItems as $key => $item)
                @if (!is_numeric($key))
                    @continue
                @endif
                @php
                    if ($key >= 7) {
                        break;
                    }

                    $value = explode('/', $item);
                    if (count($value) < 3) {
                        continue;
                    }

                    $name = $value[0];
                    $img = $value[1];
                    $link = implode('/', array_slice($value, 2));

                    $excludedLinks = [
                        'markup-calculator',
                        'capm-calculator',
                        'bond-price-calculator',
                        'gematria-calculator',
                    ];
                    $link = str_replace('weight-loss-calculator', 'weightloss-calculator', $link);
                @endphp

                @if (!in_array($link, $excludedLinks) && $calName !== $name)
                    <li class="py-2">
                        <a href="{{ url($link) }}/" class="hover:underline hover:text-blue-600">{{ $name }}</a>
                    </li>
                    <hr class="border-gray-400">
                @endif
            @endforeach
        @else
            <li class="text-sm text-gray-500">No related calculators found.</li>
        @endif
    </ul>
</div>
