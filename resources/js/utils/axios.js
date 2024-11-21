import axiosLib from "axios";

const axios = axiosLib.create({
    // baseURL: process.env.APP_URL,
    // baseURL: "http://192.168.60.11:9001",
    baseURL: "https://gendersphere.vercel.app/api",
    headers: {
        Accept: "application/json",
    }
});

export default axios;