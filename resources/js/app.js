require('./bootstrap');

import {createApp} from 'vue';

import 'flowbite';
import CryptoProSetup from './components/tech/CryptoProSetup';
import StaffLogin from './components/login/Staff';
import ClientLogin from './components/login/Client';
import ClientLoginPage from './components/ClientLoginPage';
import ManagerLogo from "./components/manager/Logo";
import CompanyListPage from "./components/manager/CompanyListPage";
import Table from "./components/Table";

const app = createApp({});

app.component('crypto-pro-setup', CryptoProSetup);
app.component('staff-login', StaffLogin);
app.component('client-login', ClientLogin);
app.component('client-login-page', ClientLoginPage);
app.component('manager-logo', ManagerLogo);
app.component('company-list-page', CompanyListPage);
app.component('custom-table', Table);

app.mount('#app');
