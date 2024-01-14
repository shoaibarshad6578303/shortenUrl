import { ref } from 'vue'
import axios from 'axios'
 
export default function useUrls() {
    const url = ref('')
 
    const errors = ref('')
 
    const shortUrl = async (data) => {
        errors.value = ''
        try {
            let response = await axios.post('/api/shorten', data)
            url.value = response.data.shortUrl
        } catch (e) {
            if (e.response.status === 422) {
                for (const key in e.response.data.errors) {
                    errors.value = e.response.data.errors
                }
            }
        }
 
    }
 
    return {
        errors,
        shortUrl,
        url,
    }
}