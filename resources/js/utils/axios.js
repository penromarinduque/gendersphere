import axiosLib from "axios";

const axios = axiosLib.create({
    // baseURL: process.env.APP_URL,
    // baseURL: "http://192.168.60.11:9001",
    // baseURL: "https://gendersphere.vercel.app/api",
    // baseURL: "https://gendersphere.penromarinduque.gov.ph",
    baseURL: import.meta.env.VITE_API_URL,
    headers: {
        Accept: "application/json",
    }
});

export default axios;