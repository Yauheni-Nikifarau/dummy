export default function useGetTrips () {
    const useGetTrips = async (url, variable) => { //TODO: вынести в тулы
        let response = await fetch(url),
            json = await response.json();
        variable.value = json.data;
    }
    return {
        useGetTrips
    }
}
