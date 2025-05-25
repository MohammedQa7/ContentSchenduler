<template>
  <div class="p-4">

    <header class="mb-8">
      <div class="flex items-center space-x-2 mb-2">
        <div class="size-8 rounded-md bg-primary flex items-center justify-center">
          <ServerIcon class="size-4 text-primary-foreground" />
        </div>
        <h1 class="text-3xl font-bold tracking-tight">Platform Manager</h1>
      </div>
      <p class="text-muted-foreground">Select the platforms you want to integrate with your project.</p>
    </header>

    <div class="relative">
      <Transition>
        <div v-if="isLoading"
          class="w-full h-full rounded bg-muted/60 absolute z-50 flex justify-center items-center transition-all">
          <Loader2 class="animate-spin size-12" />
        </div>
      </Transition>
      <Card class="mb-8">
        <CardHeader>
          <CardTitle>Available Platforms</CardTitle>
          <CardDescription>
            Toggle the platforms you want to add to your project. You can add or remove them at any time.
          </CardDescription>
        </CardHeader>
        <CardContent>
          <div class="grid gap-6">
            <div v-for="platform in platforms.data" :key="platform.id"
              class="flex items-center justify-between space-x-4 rounded-lg border p-4">
              <div class="flex items-center space-x-4">
                <div class="size-10 rounded-md flex items-center justify-center" :class="platform.bgColor">
                  <component :is="LucideIcons[getPlatformIcon(platform.type)]" />
                </div>
                <div>
                  <p class="text-sm font-medium leading-none mb-1">{{ platform.name }}</p>
                </div>
              </div>
              <Switch :model-value="platform.enabled" @update:model-value="togglePlatform(platform)" />
            </div>
          </div>
        </CardContent>
      </Card>

      <Card>
        <CardHeader>
          <CardTitle>Selected Platforms</CardTitle>
          <CardDescription>
            These are the platforms currently integrated with your project.
          </CardDescription>
        </CardHeader>
        <CardContent>
          <div v-if="enabledPlatforms?.data?.length === 0" class="text-center py-6">
            <ServerCrashIcon class="size-12 mx-auto text-muted-foreground mb-3" />
            <p class="text-muted-foreground">No platforms selected yet</p>
            <p class="text-sm text-muted-foreground">Toggle a platform above to add it to your project</p>
          </div>
          <div v-else class="grid gap-3">
            <Badge v-for="platform in enabledPlatforms.data" :key="platform.id" variant="outline"
              class="flex items-center justify-between px-3 py-1.5">
              <div class="flex items-center gap-2">
                <component :is="LucideIcons[getPlatformIcon(platform.type)]" />
                <span>{{ platform.name }}</span>
              </div>
              <Button variant="ghost" size="icon"
                class="size-5 rounded-full -mr-1.5 hover:bg-red-500 hover:text-red-500"
                @click="togglePlatform(platform)">
                <XIcon class="size-3" />
                <span class="sr-only">Remove {{ platform.name }}</span>
              </Button>
            </Badge>
          </div>
        </CardContent>
      </Card>
    </div>

  </div>

</template>

<script setup>
import { ref, computed } from 'vue'
import {
  Card,
  CardHeader,
  CardTitle,
  CardDescription,
  CardContent
} from '@/components/ui/card'
import { Badge } from '@/components/ui/badge'
import { Button } from '@/components/ui/button'
import {
  ServerIcon,
  ServerCrashIcon,
  XIcon,
  Loader2
} from 'lucide-vue-next'
import * as LucideIcons from 'lucide-vue-next';
import AppLayout from '@/layouts/AppLayout.vue'
import Switch from '@/components/ui/switch/Switch.vue'
import getPlatformIcon from '@/composables/getPlatformIcon'
import { router } from '@inertiajs/vue3'
const isLoading = ref(false);
const propsData = defineProps({
  platforms: Object,
  enabledPlatforms: Object,
});

const togglePlatform = (platform) => {
  isLoading.value = true;
  router.post(route('platform.toggle'), { platform: platform.type }, {
    onSuccess: () => {
      isLoading.value = false;
    }
  });
}

defineOptions({
  layout: AppLayout
});
</script>

<style>
.v-enter-active,
.v-leave-active {
  transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
}
</style>