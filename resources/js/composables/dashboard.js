import { ref } from 'vue'
// import axios from 'axios'
import axios from '../utils/axios'

export default function useDashboard() {
    const summary = ref(null);

    const getSummary = async (year) => {
        let response = await axios.get('/api/dashboard/summary', {
            params: {
                year: year
            }
        });
        summary.value = response.data
    }

    return {
        summary,
        getSummary
    }
}