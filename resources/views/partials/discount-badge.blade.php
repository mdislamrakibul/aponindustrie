@if($prod['is_discounted'])
    <span class="{{ $badgeClass }}">
        @if($prod['discount_type'] == 'PERCENTAGE')
            {{ number_format($prod['discount_value'], 0) }}% Off
        @elseif($prod['discount_type'] == 'FLAT')
            ৳{{ number_format($prod['discount_value'], 0) }} Off
        @endif
    </span>
@endif
