const API_URL = "http://127.0.0.1:8000/api";

export const authProvider = {
    // Called when the user attempts to log in
    login: async ({ email, password }) => {
        const request = new Request(`${API_URL}/login`, {
            method: "POST",
            body: JSON.stringify({ email, password }),
            headers: new Headers({ "Content-Type": "application/json" }),
        });

        const response = await fetch(request);
        if (!response.ok) {
            throw new Error("Invalid email or password");
        }

        const data = await response.json();

        // Save the token in localStorage
        localStorage.setItem("authToken", data.token);
        localStorage.setItem("user", JSON.stringify(data.user));
    },

    // Called when the user clicks logout
    logout: () => {
        localStorage.removeItem("authToken");
        localStorage.removeItem("user");
        return Promise.resolve();
    },

    // Checks if the user is authenticated
    checkAuth: () => {
        return localStorage.getItem("authToken")
            ? Promise.resolve()
            : Promise.reject();
    },

    // Checks user permissions (optional)
    getPermissions: () => Promise.resolve(),

    // Called when API returns 401 or 403
    checkError: (error) => {
        const status = error.status;
        if (status === 401 || status === 403) {
            localStorage.removeItem("authToken");
            localStorage.removeItem("user");
            return Promise.reject();
        }
        return Promise.resolve();
    },
};