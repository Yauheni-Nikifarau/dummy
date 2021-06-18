import { createRouter, createWebHistory } from "vue-router";
import Account from "./pages/Account/Account";
import MePage from "./pages/Account/MePage";
import OrdersPage from "./pages/Account/OrdersPage/OrdersPage";
import MessagesPage from "./pages/Account/MessagesPage/MessagesPage";
import Site from "./pages/Site/Site";
import AboutPage from "./pages/Site/AboutPage";
import ContactsPage from "./pages/Site/ContactsPage";
import MainPage from "./pages/Site/MainPage/MainPage";
import TripsPage from "./pages/Site/TripsPage/TripsPage";
import HotelsPage from "./pages/Site/HotelsPage/HotelsPage";


export const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: "/account",
            component: Account,
            children: [
                { path: "", component: MePage },
                { path: "orders", component: OrdersPage },
                { path: "messages", component: MessagesPage },
            ],
        },
        {
            path: "/",
            component: Site,
            children: [
                { path: "/", component: MainPage },
                { path: "trips", component: TripsPage },
                { path: "hotels", component: HotelsPage },
                { path: "contacts", component: ContactsPage },
                { path: "about", component: AboutPage },
            ],
        },
    ],
});
