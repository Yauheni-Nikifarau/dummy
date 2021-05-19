console.log('trips')
let trip_list = document.querySelector('#trip-list');

function createElementWithClasses (tag, classes = []) {
    let element = document.createElement(tag);
    for (let className of classes) {
        element.classList.add(className);
    }
    return element;
}

axios.get('/api/trips').then(res => {
    let data = res.data.data;
    for (let trip of data) {
        console.log(trip);

        let container = createElementWithClasses('div', ['w-1/4']),
            image = createElementWithClasses('img'),
            title = createElementWithClasses('h3'),
            hotel = createElementWithClasses('p'),
            price = createElementWithClasses('p');

        image.setAttribute('src', trip.image);
        title.textContent = trip.name;
        hotel.textContent = trip.hotel.name;
        price.textContent = trip.price;

        container.appendChild(image);
        container.appendChild(title);
        container.appendChild(hotel);
        container.appendChild(price);

        trip_list.appendChild(container);
    }

    //trip_list.textContent = res.data[0].id;
})
