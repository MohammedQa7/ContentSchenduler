<template>

    <!-- Instagram Mockup -->
    <section class="mb-12">
        <h2 class="text-2xl font-semibold mb-4 flex items-center gap-2">
            <Badge class="bg-gradient-to-r from-purple-500 to-pink-500 text-white">Instagram</Badge>
            Mockup
        </h2>

        <Card class="overflow-hidden border-gray-200">
            <!-- Instagram Post -->
            <CardHeader class="flex flex-row items-center gap-3 py-3">
                <Avatar class="w-8 h-8">
                    <AvatarImage src="https://i.pravatar.cc/150?img=1" />
                    <AvatarFallback>JS</AvatarFallback>
                </Avatar>
                <div>
                    <p class="text-sm font-semibold">{{ post.user.name }}</p>
                    <p class="text-xs text-muted-foreground">Venice Beach, California</p>
                </div>
                <Button variant="ghost" size="icon" class="ml-auto">
                    <MoreHorizontal class="h-5 w-5" />
                </Button>
            </CardHeader>

            <CardContent class="p-0">
                <img :src="post?.image" alt="Beach post" class="w-full h-[400px] object-cover" />
            </CardContent>

            <CardFooter class="flex flex-col items-start p-4 space-y-3">
                <div class="flex items-center justify-between w-full">
                    <div class="flex space-x-4">
                        <Button variant="ghost" size="sm" class="p-0 h-auto">
                            <Heart class="h-6 w-6" />
                        </Button>
                        <Button variant="ghost" size="sm" class="p-0 h-auto">
                            <MessageCircle class="h-6 w-6" />
                        </Button>
                        <Button variant="ghost" size="sm" class="p-0 h-auto">
                            <Send class="h-6 w-6" />
                        </Button>
                    </div>
                    <Button variant="ghost" size="sm" class="p-0 h-auto">
                        <Bookmark class="h-6 w-6" />
                    </Button>
                </div>

                <div>
                    <p class="text-sm font-semibold mb-1">1,243 likes</p>
                    <p class="text-sm">
                        <span class="font-semibold">{{ post.user.name }}</span>
                        {{ post.content }}
                    </p>
                    <div class="space-x-1">
                        <span v-for="(tag, index) in post.tags" :key="index" class="text-sm text-sky-500 mt-1">
                            #{{ tag }}
                        </span>
                    </div>

                    <p class="text-xs text-muted-foreground mt-2">View all 42 comments</p>
                    <p class="text-xs text-muted-foreground mt-2">{{ post.publishedAt }}</p>
                </div>

            </CardFooter>
        </Card>
    </section>

</template>

<script setup>
import {
    Send,
    MoreHorizontal,
} from 'lucide-vue-next'

import { Card } from '@/components/ui/card'
import { CardHeader } from '@/components/ui/card'
import { CardContent } from '@/components/ui/card'
import { Avatar } from '@/components/ui/avatar'
import { AvatarImage } from '@/components/ui/avatar'
import { AvatarFallback } from '@/components/ui/avatar'
import { Badge } from '@/components/ui/badge'
import Button from '@/components/ui/button/Button.vue'
import PostsTable from './PostsTable.vue'
const propsData = defineProps({
    post: Object,
});
</script>