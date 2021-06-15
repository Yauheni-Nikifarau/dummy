import { createRouter, createWebHistory } from 'vue-router'
import Account from "./components/account/common/Account";
import MePage from "./components/account/me/MePage";
import OrdersPage from "./components/account/orders/OrdersPage";
import MessagesPage from "./components/account/messages/MessagesPage";
import Site from "./components/site/common/Site";
import MainPage from "./components/site/main/MainPage";
import TripsPage from "./components/site/trips/TripsPage";
import HotelsPage from "./components/site/hotels/HotelsPage";
import ContactsPage from "./components/site/contacts/ContactsPage";
import AboutPage from "./components/site/about/AboutPage";

export const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/account',
            component: Account,
            children: [
                { path: '', component: MePage },
                { path: 'orders', component: OrdersPage },
                { path: 'messages', component: MessagesPage },
            ],
        },
        {
            path: '',
            component: Site,
            children: [
                { path: '', component: MainPage },
                { path: 'trips', component: TripsPage },
                { path: 'hotels', component: HotelsPage },
                { path: 'contacts', component: ContactsPage },
                { path: 'about', component: AboutPage },
            ],
        },
    ],
})
