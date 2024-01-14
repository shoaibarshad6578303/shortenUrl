<template>
    <div v-if="errors">
        <div v-for="(v, k) in errors" :key="k" class="bg-red-400 text-white rounded font-bold mb-4 shadow-lg py-2 px-4 pr-0">
            <p v-for="error in v" :key="error" class="text-sm">
                {{ error }}
            </p>
        </div>
    </div>
 
    <form class="space-y-6" @submit.prevent="shortenUrl">
        <div class="space-y-4 rounded-md shadow-sm">
            <div>
                <label for="url" class="block text-sm font-medium text-gray-700">Url</label>
                <div class="mt-1">
                    <input type="text" name="url" id="url"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="form.url">
                </div>
            </div>

        </div>
 
        <button type="submit"
                class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md ring-gray-300 hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring disabled:opacity-25">
            Shorten the url
        </button>
    </form>
    <br>

    <div v-if="url" class="space-y-4 rounded-md shadow-sm mt-5">
        <div>
          <b>Short Url: </b>  {{ url }}
        </div>
    </div>
</template>
 
<script setup>
import useUrls from '../../composables/urls'
import { reactive } from 'vue'
 
const form = reactive({
    url: '',
    
})
 
const { errors, shortUrl, url } = useUrls()
 
const shortenUrl = async () => {
    await shortUrl({ ...form })
}
</script>