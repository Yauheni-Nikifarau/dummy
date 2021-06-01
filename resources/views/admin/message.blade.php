<div style="margin: 0 auto; width: 50%">
    <p><span style="font-weight:bold;">{{ $way }}:</span> {{ $opponent }}</p>
    <p><span style="font-weight:bold;">Subject:</span> {{ $subject }}</p>
    <p><span style="font-weight:bold;">Text:</span> {{ $text }}</p>

    @if(isset($opponent_id))
        <a href="write/{{ $opponent_id }}">Write an answer</a>
    @endif

</div>





