require('./bootstrap');

import {createApp} from 'vue';

import 'flowbite';
import CryptoProSetup from './components/tech/CryptoProSetup';
import StaffLogin from './components/login/Staff';
import ClientLogin from './components/login/Client';
import ClientLoginPage from './components/ClientLoginPage';
import CompanyListPage from "./components/manager/CompanyListPage";
import Table from "./components/Table";
import Pagination from "./components/Pagination";
import Skeleton from "./components/Skeleton";
import Logo from "./components/Logo";
import TemplatesPage from "./components/manager/TemplatesPage";

const app = createApp({});

app.component('crypto-pro-setup', CryptoProSetup);
app.component('staff-login', StaffLogin);
app.component('client-login', ClientLogin);
app.component('client-login-page', ClientLoginPage);
app.component('company-list-page', CompanyListPage);
app.component('custom-table', Table);
app.component('skeleton', Skeleton);
app.component('pagination', Pagination);
app.component('logo', Logo);
app.component('templates-page', TemplatesPage);

app.mount('#app');
