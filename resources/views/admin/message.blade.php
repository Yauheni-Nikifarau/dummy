<div class="show-message-container">
    <p class="show-message-container-block-text"><span class="show-message-container-block-title">{{ $way }}:</span> {{ $opponent }}</p>
    <p class="show-message-container-block-text"><span class="show-message-container-block-title">Subject:</span> {{ $subject }}</p>
    <p class="show-message-container-block-text"><span class="show-message-container-block-title">Text:</span> {{ $text }}</p>

    @if(isset($opponent_id))
        <a href="write/{{ $opponent_id }}?subject={{ $subject }}" class="show-message-container-link">Write an answer</a>
    @endif

</div>



