<x-mail::message>
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Ôi không!')
@else
# @lang('Xin chào!')
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Nút hành động --}}
@isset($actionText)
<?php
    $color = match ($level) {
        'success', 'error' => $level,
        default => 'primary',
    };
?>
<x-mail::button :url="$actionUrl" :color="$color">
{{ $actionText }}
</x-mail::button>
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Lời chào kết --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('Trân trọng,')<br>
{{ config('app.name') }}
@endif


{{-- Phần phụ giải thích --}}
@isset($actionText)
<x-slot:subcopy>
Nếu bạn gặp sự cố khi nhấn nút "{{ $actionText }}", hãy sao chép và dán URL dưới đây vào trình duyệt web của bạn:<br>
<span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
</x-slot:subcopy>
@endisset
</x-mail::message>
