import { ref } from 'vue'
// import axios from 'axios'
import axios from '../utils/axios'
import { useRouter } from 'vue-router'
import { createToaster } from '@meforma/vue-toaster'

export default function useCommittees() {
    const committee = ref([])
    const committees = ref([])
    const personinfos = ref([])
    const committeepositions = ref([])
    const yearlist = ref([]);
    const loading  = ref(false);
    const committeeSummary = ref({});
    let curr_year = new Date().getFullYear()
    const years = Array.from({length: 7}, (value, index) => curr_year - index)
    const selectedYear = ref(curr_year);

    const errors = ref('')
    const router = useRouter();

    const toaster = createToaster({ 
        position: "top"
        // max:
    });

    const getCommittees = async (page = 1, year = null, emp_status = 'all', gender = 'all') => {
        let response = await axios.get('/api/committees', {params: { page:page, year:year, employment_status:emp_status, gender:gender } });
        committees.value = response.data;
        await getCommitteeSummary();
    }
 
    const getCommittee = async (id) => {
        let response = await axios.get(`/api/committees/${id}`)
        committee.value = response.data.data;
        // console.log(response.data);
    }

    const storeCommittee = async (data) => {
        loading.value = true;
        errors.value = '';
        try {
            await axios.post('/api/committees', data);
            await router.push({ name: 'committees.index' });
            toaster.success(`Successfully Saved!`);
            loading.value = false;
        } catch (e) {
            console.log(e);
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value = e.response.data.errors
                }
            }
            loading.value = false;
        }
    }
 
    const updateCommittee = async (id) => {
        // console.log(committee);
        loading.value = true;
        errors.value = ''
        try {
            await axios.patch(`/api/committees/${id}`, committee.value)
            await router.push({ name: 'committees.index' })
            toaster.success(`Successfully Updated!`);
            loading.value = false;
        } catch (e) {
            console.log(e);
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value = e.response.data.errors
                }
            }
            loading.value = false;
        }
    }

    const destroyCommittee = async (id) => {
        loading.value = true;
        try {
            await axios.delete(`/api/committees/${id}`)
            toaster.info(`Deleted!`);
            loading.value = false;
        } catch (e) {
            // console.log(e);
            toaster.info(`Oops! Something went wrong please try again.`);
            loading.value = false;
        }
    }

    const getPersonInfos = async () => {
        let response = await axios.get('/api/personinfos/all/persons')
        personinfos.value = response.data.data
    }

    const getCommitteePositions = async () => {
        let response = await axios.get('/api/committeepositions')
        // console.log(response)
        committeepositions.value = response.data.data
    }

    const getYearlist = async () => {
        let response = await axios.get('/api/yearlist')
        console.log(response.data)
        yearlist.value = response.data
    }

    const getCommitteeSummary = async () => {
        const response = await axios.get(`/api/committees/summary` , { params: { year: selectedYear.value} });
        console.log(response.data);
        committeeSummary.value = response.data;
    }

    return {
        errors,
        committee,
        committees,
        personinfos,
        committeepositions,
        yearlist,
        loading,
        committeeSummary,
        selectedYear,
        getCommittee,
        getCommittees,
        storeCommittee,
        updateCommittee,
        destroyCommittee,
        getPersonInfos,
        getCommitteePositions,
        getYearlist,
        getCommitteeSummary
    }
}