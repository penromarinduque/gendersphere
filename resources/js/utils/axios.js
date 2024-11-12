import axiosLib from "axios";

const axios = axiosLib.create({
    // baseURL: "https://gendersphere.vercel.app/api",
    baseURL: "http://192.168.60.11:9001",
    headers: {
        Accept: "application/json",
    }
});

export default axios;