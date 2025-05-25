<template>
  <div class="min-h-screen bg-background p-6">
    <div class="max-w-7xl mx-auto space-y-6">
      <!-- Header -->
      <div class="space-y-2">
        <h1 class="text-3xl font-bold tracking-tight">Post Analytics</h1>
        <p class="text-muted-foreground">
          Track your content performance across platforms
        </p>
      </div>

      <!-- Overview Cards -->
      <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-lg border bg-card text-card-foreground shadow-sm p-6">
          <div class="flex flex-row items-center justify-between space-y-0 pb-2">
            <h3 class="tracking-tight text-sm font-medium">Total Posts</h3>
            <svg class="h-4 w-4 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
          </div>
          <div class="space-y-1">
            <div class="text-2xl font-bold">{{ totalPosts }}</div>
            <p class="text-xs text-muted-foreground">
              +12% from last month
            </p>
          </div>
        </div>

        <div class="rounded-lg border bg-card text-card-foreground shadow-sm p-6">
          <div class="flex flex-row items-center justify-between space-y-0 pb-2">
            <h3 class="tracking-tight text-sm font-medium">Published</h3>
            <svg class="h-4 w-4 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
          </div>
          <div class="space-y-1">
            <div class="text-2xl font-bold">{{ publishedPosts }}</div>
            <p class="text-xs text-muted-foreground">
              {{ Math.round((publishedPosts / totalPosts) * 100) }}% of total
            </p>
          </div>
        </div>

        <div class="rounded-lg border bg-card text-card-foreground shadow-sm p-6">
          <div class="flex flex-row items-center justify-between space-y-0 pb-2">
            <h3 class="tracking-tight text-sm font-medium">Scheduled</h3>
            <svg class="h-4 w-4 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <div class="space-y-1">
            <div class="text-2xl font-bold">{{ scheduledPosts }}</div>
            <p class="text-xs text-muted-foreground">
              {{ Math.round((scheduledPosts / totalPosts) * 100) }}% of total
            </p>
          </div>
        </div>

        <div class="rounded-lg border bg-card text-card-foreground shadow-sm p-6">
          <div class="flex flex-row items-center justify-between space-y-0 pb-2">
            <h3 class="tracking-tight text-sm font-medium">Platforms</h3>
            <svg class="h-4 w-4 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
          </div>
          <div class="space-y-1">
            <div class="text-2xl font-bold">{{ platforms.length }}</div>
            <p class="text-xs text-muted-foreground">
              Active platforms
            </p>
          </div>
        </div>
      </div>

      <div class="grid gap-6 lg:grid-cols-2">
        <!-- Posts by Platform -->
        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
          <div class="p-6 pb-2">
            <h3 class="text-lg font-semibold">Posts by Platform</h3>
            <p class="text-sm text-muted-foreground">Distribution across social media platforms</p>
          </div>
          <div class="p-6 pt-0">
            <div class="space-y-4">
              <div v-for="platform in platforms" :key="platform.name" class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                  <div class="w-3 h-3 rounded-full" :style="{ backgroundColor: platform.color }"></div>
                  <span class="font-medium">{{ platform.name }}</span>
                </div>
                <div class="text-right">
                  <div class="font-semibold">{{ platform.posts }}</div>
                  <div class="text-xs text-muted-foreground">
                    {{ Math.round((platform.posts / totalPosts) * 100) }}%
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Visual Bar Chart -->
            <div class="mt-6 space-y-3">
              <div v-for="platform in platforms" :key="platform.name" class="space-y-1">
                <div class="flex justify-between text-sm">
                  <span>{{ platform.name }}</span>
                  <span>{{ platform.posts }}</span>
                </div>
                <div class="w-full bg-muted rounded-full h-2">
                  <div 
                    class="h-2 rounded-full transition-all duration-500"
                    :style="{ 
                      width: `${(platform.posts / Math.max(...platforms.map(p => p.posts))) * 100}%`,
                      backgroundColor: platform.color 
                    }"
                  ></div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Scheduled vs Published -->
        <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
          <div class="p-6 pb-2">
            <h3 class="text-lg font-semibold">Scheduled vs Published</h3>
            <p class="text-sm text-muted-foreground">Content status breakdown by platform</p>
          </div>
          <div class="p-6 pt-0">
            <div class="space-y-6">
              <div v-for="platform in platforms" :key="platform.name" class="space-y-2">
                <div class="flex justify-between items-center">
                  <span class="font-medium">{{ platform.name }}</span>
                  <span class="text-sm text-muted-foreground">{{ platform.posts }} total</span>
                </div>
                
                <div class="grid grid-cols-2 gap-2">
                  <div class="text-center p-3 rounded-lg bg-green-50 border border-green-200">
                    <div class="text-lg font-semibold text-green-700">{{ platform.published }}</div>
                    <div class="text-xs text-green-600">Published</div>
                  </div>
                  <div class="text-center p-3 rounded-lg bg-orange-50 border border-orange-200">
                    <div class="text-lg font-semibold text-orange-700">{{ platform.scheduled }}</div>
                    <div class="text-xs text-orange-600">Scheduled</div>
                  </div>
                </div>
                
                <!-- Progress bars -->
                <div class="flex space-x-1 h-2">
                  <div 
                    class="bg-green-500 rounded-l"
                    :style="{ width: `${(platform.published / platform.posts) * 100}%` }"
                  ></div>
                  <div 
                    class="bg-orange-500 rounded-r"
                    :style="{ width: `${(platform.scheduled / platform.posts) * 100}%` }"
                  ></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Recent Activity -->
      <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
        <div class="p-6 pb-2">
          <h3 class="text-lg font-semibold">Recent Activity</h3>
          <p class="text-sm text-muted-foreground">Latest posts and scheduled content</p>
        </div>
        <div class="p-6 pt-0">
          <div class="space-y-4">
            <div v-for="activity in recentActivity" :key="activity.id" class="flex items-center space-x-4 p-3 rounded-lg border">
              <div class="w-2 h-2 rounded-full" :class="activity.status === 'published' ? 'bg-green-500' : 'bg-orange-500'"></div>
              <div class="flex-1">
                <div class="font-medium">{{ activity.title }}</div>
                <div class="text-sm text-muted-foreground">{{ activity.platform }} • {{ activity.date }}</div>
              </div>
              <div class="text-sm">
                <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium" 
                      :class="activity.status === 'published' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700'">
                  {{ activity.status }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

// Sample data
const platforms = [
  { name: 'Twitter', posts: 45, published: 32, scheduled: 13, color: '#1DA1F2' },
  { name: 'Instagram', posts: 38, published: 28, scheduled: 10, color: '#E4405F' },
  { name: 'LinkedIn', posts: 22, published: 18, scheduled: 4, color: '#0077B5' },
  { name: 'Facebook', posts: 15, published: 12, scheduled: 3, color: '#1877F2' },
  { name: 'TikTok', posts: 12, published: 8, scheduled: 4, color: '#000000' }
]

const recentActivity = [
  {
    id: 1,
    title: 'New product launch announcement',
    platform: 'Twitter',
    status: 'published',
    date: '2 hours ago'
  },
  {
    id: 2,
    title: 'Behind the scenes video',
    platform: 'Instagram',
    status: 'scheduled',
    date: 'Tomorrow at 3:00 PM'
  },
  {
    id: 3,
    title: 'Industry insights article',
    platform: 'LinkedIn',
    status: 'published',
    date: '5 hours ago'
  },
  {
    id: 4,
    title: 'Weekly team update',
    platform: 'Facebook',
    status: 'scheduled',
    date: 'Friday at 10:00 AM'
  },
  {
    id: 5,
    title: 'Quick tutorial video',
    platform: 'TikTok',
    status: 'published',
    date: '1 day ago'
  }
]

// Computed properties
const totalPosts = computed(() => platforms.reduce((sum, platform) => sum + platform.posts, 0))
const publishedPosts = computed(() => platforms.reduce((sum, platform) => sum + platform.published, 0))
const scheduledPosts = computed(() => platforms.reduce((sum, platform) => sum + platform.scheduled, 0))
</script>

<style scoped>
/* Additional custom styles if needed */
.transition-all {
  transition: all 0.3s ease;
}
</style>