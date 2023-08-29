@props(['date'])

<relative-time datetime="{{ $date->format(DateTime::ISO8601) }}">
    {{ $date->toFormattedDateString() }}
</relative-time>
