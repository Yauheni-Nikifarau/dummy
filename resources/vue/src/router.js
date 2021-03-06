import { createRouter, createWebHistory } from "vue-router";
import Account from "./pages/Account/Account";
import MePage from "./pages/Account/MePage";
import OrdersPage from "./pages/Account/OrdersPage/OrdersPage";
import Site from "./pages/Site/Site";
import AboutPage from "./pages/Site/AboutPage";
import ContactsPage from "./pages/Site/ContactsPage";
import MainPage from "./pages/Site/MainPage/MainPage";
import TripsPage from "./pages/Site/TripsPage/TripsPage";
import HotelsPage from "./pages/Site/HotelsPage/HotelsPage";
import HotelPage from "./pages/Site/HotelPage/HotelPage";
import TripPage from "./pages/Site/TripPage";
import OrderPage from "./pages/Account/OrderPage";
import ConversationsPage from "./pages/Account/ConversationsPage/ConversationsPage";
import ConversationPage from "./pages/Account/ConversationPage";


export const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: "/account",
            component: Account,
            children: [
                { path: "", component: MePage },
                { path: "orders", component: OrdersPage },
                { path: "orders/:id", component: OrderPage },
                { path: "conversations", component: ConversationsPage },
                { path: "conversations/:id", component: ConversationPage },
            ],
        },
        {
            path: "/",
            component: Site,
            children: [
                { path: "/", component: MainPage },
                { path: "login", component: MainPage },
                { path: "trips", component: TripsPage },
                { path: "trips/:slug", component: TripPage },
                { path: "hotels", component: HotelsPage },
                { path: "hotels/:slug", component: HotelPage },
                { path: "contacts", component: ContactsPage },
                { path: "about", component: AboutPage },
            ],
        },
    ],
});
