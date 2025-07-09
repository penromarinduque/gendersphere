
import { ref } from "vue";
import axios from '../utils/axios'

export default function useRegions() {
    const regions = ref([]);

    const getAllRegions = async () => {
        let response = await axios.get('/api/regions/all');
        regions.value = response.data;
        return response.data;
    }

    return {
        regions,
        getAllRegions
    }
}