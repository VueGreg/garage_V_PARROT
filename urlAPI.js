import axios from "axios";

const api = axios.create({
 baseURL: "https://gregory-wolff.com/api",
});

export default api;