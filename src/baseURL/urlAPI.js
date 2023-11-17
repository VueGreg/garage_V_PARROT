import axios from "axios";

const api = axios.create({
 baseURL: "http://localhost/src/api",
});

export default api;