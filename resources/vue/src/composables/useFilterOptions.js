export function buildQuery (options) {
    const queries = {};
    if (options.hotel) {
        queries.hotel = options.hotel;
    }
    if (options.tag) {
        queries.tag = options.tag;
    }
    if (options.discount) {
        queries.discount = options.discount;
    }

    if (options.minPrice) {
        queries.min_price = options.minPrice;
    }
    if (options.maxPrice) {
        queries.max_price = options.maxPrice;
    }
    if (options.people) {
        queries.people = options.people;
    }
    if (options.meal) {
        queries.meal = options.meal;
    }

    if (options.minDateIn) {
        queries.min_date_in =
            Math.trunc(Date.parse(options.minDateIn) / 1000);
    }
    if (options.minDateOut) {
        queries.min_date_out =
            Math.trunc(Date.parse(options.minDateOut) / 1000);
    }
    if (options.maxDateIn) {
        queries.max_date_in =
            Math.trunc(Date.parse(options.maxDateIn) / 1000) + 3600 * 24 - 1;
    }

    if (options.maxDateOut) {
        queries.max_date_out =
            Math.trunc(Date.parse(options.maxDateOut) / 1000) + 3600 * 24 - 1;
    }
    let queryString = "";
    for (let key in queries) {
        queryString += `&${key}=${queries[key]}`;
    }
    if (queryString) {
        queryString = queryString.substring(1);
    }
    return queryString;
}
