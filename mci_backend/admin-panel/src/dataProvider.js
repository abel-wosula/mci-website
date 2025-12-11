import { fetchUtils } from "react-admin";

const apiUrl = "http://127.0.0.1:8000/api";
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

const dataProvider = {
    getList: async (resource, params) => {
        const url = `${apiUrl}/${resource}`;
        const { json, headers } = await httpClient(url);

        // React-admin expects: { data: [...], total: n }
        const total =
            headers.has("Content-Range")
                ? parseInt(headers.get("Content-Range").split("/")[1])
                : json.data.length;

        return {
            data: json.data,
            total: total,
        };
    },

    getOne: async (resource, params) => {
        const { json } = await httpClient(`${apiUrl}/${resource}/${params.id}`);
        return { data: json.data };
    },

    create: async (resource, params) => {
        const { json } = await httpClient(`${apiUrl}/${resource}`, {
            method: "POST",
            body: JSON.stringify(params.data),
        });
        return { data: json.data };
    },

    update: async (resource, params) => {
        const { json } = await httpClient(`${apiUrl}/${resource}/${params.id}`, {
            method: "PUT",
            body: JSON.stringify(params.data),
        });
        return { data: json.data };
    },

    delete: async (resource, params) => {
        await httpClient(`${apiUrl}/${resource}/${params.id}`, {
            method: "DELETE",
        });
        return { data: { id: params.id } };
    },
};

export default dataProvider;
