import * as React from "react";
import { Admin, Resource, fetchUtils } from "react-admin";
import simpleRestProvider from "ra-data-simple-rest";

import { UserList } from "./users";
import { PostList } from "./posts";
import { authProvider } from "./authProvider";
import LoginPage from "./LoginPage";

const httpClient = (url, options = {}) => {
    if (!options.headers) {
        options.headers = new Headers({ Accept: "application/json" });
    }
    const token = localStorage.getItem("authToken");
    if (token) {
        options.headers.set("Authorization", `Bearer ${token}`);
    }
    return fetchUtils.fetchJson(url, options);
};

const dataProvider = simpleRestProvider("http://127.0.0.1:8000/api", httpClient);


function App() {
    return (
        <Admin
            dataProvider={dataProvider}
            authProvider={authProvider}
            loginPage={LoginPage}   // ← IMPORTANT
        >
            <Resource name="users" list={UserList} />
            <Resource name="posts" list={PostList} />
        </Admin>
    );
}

export default App;
