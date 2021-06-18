export default function () {
    const getTrips = async (url, variable) => {
        //TODO: вынести в тулы
        const response = await fetch(url);
        const json = await response.json();
        variable.value = json.data;
    };
    return {
        getTrips,
    };
}
