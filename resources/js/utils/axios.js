import axiosLib from "axios";

const axios = axiosLib.create({
    // baseURL: import.meta.env.APP_API_URL,
    baseURL: "http://192.168.60.11:9001",
    // baseURL: "https://gendersphere.vercel.app/api",
    // baseURL: "https://gendersphere.penromarinduque.gov.ph",
    headers: {
        Accept: "application/json",
    }
});

export default axios;