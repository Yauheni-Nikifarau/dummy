<div class="show-trip-container">
    <img src="/storage/{{ $image }}" alt="Trip image" class="show-trip-image">
    <div class="show-trip-tags_container">
        @foreach($tags as $tag)
            <div class="show-trip-tag">{{ $tag->tag_name }}</div>
        @endforeach
    </div>
</div>
