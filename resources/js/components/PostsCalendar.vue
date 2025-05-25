<template>
    <div class="flex items-center justify-between mb-6 p-4">
        <h2 class="text-2xl font-bold">Posts Calendar</h2>
    </div>

    <FullCalendar :posts="posts" />

</template>

<script setup>
import FullCalendar from './FullCalendar.vue';
const propsData = defineProps({
    posts: Array,
});
</script>
