<template>
    <CreatePostDialog v-if="isCreatePostDialogOpened" :is-open="isCreatePostDialogOpened" :platforms="platforms"
        @update:open="isCreatePostDialogOpened = $event" />

    <div class="container mx-auto p-4 max-w-4xl space-y-8">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold ">Published Posts</h1>

            <Button @click.prevent="toggleCreatePostDialog">
                <Plus />
                New Post
            </Button>

        </div>

        <!-- Posts -->
        <div class="posts">

            <div v-for="(post, index) in posts" :key="index">
                <InstagramPost v-if="post.platform == 'Instagram'" :post="post.post.data" />
                <TwitterPost v-if="post.platform == 'Twitter'" :post="post.post.data" />
                <LinkedinPost v-if="post.platform == 'Linkedin'" :post="post.post.data" />
            </div>
        </div>

    </div>

</template>

<script setup>
import { ref } from 'vue'
import {
    Share,
    Plus
} from 'lucide-vue-next'
import AppLayout from '@/layouts/AppLayout.vue'
import CreatePostDialog from '@/components/Posts/CreatePostDialog.vue'
import axios from 'axios'
import { toast } from 'vue-sonner'
import Button from '@/components/ui/button/Button.vue'
import InstagramPost from '@/components/Posts/InstagramPost.vue'
import TwitterPost from '@/components/Posts/TwitterPost.vue'
import LinkedinPost from '@/components/Posts/LinkedinPost.vue'
const isCreatePostDialogOpened = ref(false);
const platforms = ref();
const publishedOptions = ref([]);
const propsData = defineProps({
    posts: Object,
});
const toggleCreatePostDialog = () => {
    axios.get(route('posts.create'))
        .then((response) => {
            platforms.value = response.data.platforms;
            publishedOptions.value = response.data.publishedOptions;
            isCreatePostDialogOpened.value = true;
        })
        .catch(() => {
            isCreatePostDialogOpened.value = false;
            toast.error('Something Went Wrong, Please Try Again Later.');
        })
}

defineOptions({
    layout: AppLayout,
})
</script>