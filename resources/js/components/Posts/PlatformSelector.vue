<template>
    <!-- Platform Selection -->
    <div class="space-y-3">
        <div class="flex justify-between items-center">
            <Label>Publishing Platforms</Label>
            <p class="text-xs text-muted-foreground">Select one or more platforms</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            <div v-for="platform in platforms" :key="platform.id" @click="togglePlatform(platform.type)" :class="[
                'cursor-pointer rounded-lg p-3 border transition-all duration-200',
                isPlatformSelected(platform.type)
                    ? 'border-primary bg-primary/10 shadow-sm'
                    : 'border-border hover:border-primary/20 hover:bg-muted/50'
            ]">
                <div class="flex flex-col items-center text-center">
                    <div class="h-10 w-10 rounded-full flex items-center justify-center mb-2 bg-muted">
                        <component :is="getPlatformIcon(platform.name)" class="h-5 w-5" />
                    </div>
                    <span class="text-sm font-medium">{{ platform.name }}</span>
                    <div class="mt-2">
                        <div :class="[
                            'h-4 w-4 rounded-full mx-auto',
                            isPlatformSelected(platform.type) ? 'bg-primary' : 'bg-muted'
                        ]"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</template>

<script setup>
import { computed, ref, watch } from 'vue';
import Label from '../ui/label/Label.vue';
import { Icon, InstagramIcon, LinkedinIcon, TwitterIcon } from 'lucide-vue-next';
const emit = defineEmits();
const selectedPlatforms = ref([]);
const propsData = defineProps({
    platforms: Array,
});


// Assiging icon dpending on platform
const getPlatformIcon = (platform) => {
    switch (platform) {
        case 'Instagram':
            return InstagramIcon;
            break;
        case 'Linkedin':
            return LinkedinIcon;
            break;
        case 'Twitter':
            return TwitterIcon;
            break;
        default:
            return Icon;
            break;
    }
}


// Check if a platform is selected
const isPlatformSelected = (platformType) => {
    return selectedPlatforms.value.includes(platformType);
};

// Toggle platform selection
const togglePlatform = (platformType) => {
    if (isPlatformSelected(platformType)) {
        // Remove platform if already selected
        selectedPlatforms.value = selectedPlatforms.value.filter(type => type !== platformType);

    } else {
        // Add platform if not selected
        selectedPlatforms.value.push(platformType);
    }
};

watch(selectedPlatforms, (value) => {
    emit('bindSelectedPlatforms', selectedPlatforms.value)
}, { deep: true })

</script>
<style scoped>
.animate-fadeIn {
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
