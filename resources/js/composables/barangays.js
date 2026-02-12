
import { ref } from "vue";
import axios from '../utils/axios'

export default function useBarangays() {
    const barangays = ref([]);

    const getAllBarangays = async () => {
        let response = await axios.get('/api/barangays/all');
        barangays.value = response.data;
        return response.data;
    }

    const searchBarangays = async (name) => {
        let response = await axios.get(`/api/barangays/search/${name}`);
        barangays.value = response.data.data;
        console.log(response.data.data)
        return response.data.data;
    }

    return {
        barangays,
        getAllBarangays,
        searchBarangays
    }
}