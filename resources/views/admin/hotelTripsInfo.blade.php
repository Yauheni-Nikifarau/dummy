<div class="show-hotelTrips-container">
    <h2>Trips of {{ $hotelName }} hotel</h2>
    <div>{!! $hotelDescription !!}</div>
    <div class="show-hotelTrips-list">
        @foreach($trips as $trip)
            <div class="show-hotelTrips-list_item">
                <img src="/storage/{{ $trip->image }}" alt="Trip image" class="show-hotelTrips-image">
                <p class="show-hotelTrips-name"><span>Name:</span> {{ $trip->name }}</p>
                <p class="show-hotelTrips-dates"><span>Dates:</span> {{ $trip->date_in }} - {{ $trip->date_out }}</p>
                <p class="show-hotelTrips-price"><span>Start price:</span> ${{ $trip->price }}</p>
                <a href="trips/{{ $trip->id }}/edit" class="show-hotelTrips-link">Edit</a>
            </div>
        @endforeach
    </div>
</div>

