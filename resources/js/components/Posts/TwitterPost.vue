<template>

    <!-- Twitter Mockup -->
    <section class="mb-12">
        <h2 class="text-2xl font-semibold mb-4 flex items-center gap-2">
            <Badge class="bg-sky-500 text-white">Twitter</Badge>
            Mockup
        </h2>
        <Card class="overflow-hidden border-gray-200">
            <CardHeader class="flex flex-row items-start gap-3 pb-2">
                <Avatar class="w-10 h-10">
                    <AvatarImage src="https://i.pravatar.cc/150?img=3" />
                    <AvatarFallback>TE</AvatarFallback>
                </Avatar>
                <div class="flex-1">
                    <div class="flex items-center">
                        <p class="font-semibold text-sm ml-1">{{ post.user.name }} · <span
                                class="text-muted-foreground">{{ post.publishedAt }}</span></p>
                        <Button variant="ghost" size="icon" class="ml-auto h-8 w-8">
                            <MoreHorizontal class="h-4 w-4" />
                        </Button>
                    </div>

                    <div class="mt-1">
                        <p class="text-sm">
                            {{ post.content }}
                        </p>
                        <div class="space-x-1">
                            <span v-for="(tag, index) in post.tags" :key="index" class="text-sm text-sky-500 mt-1">
                                #{{ tag }}
                            </span>
                        </div>


                        <img v-if="post.image" :src="post?.image" alt="Team working" class="w-full h-auto rounded-md" />
                    </div>

                    <div class="flex justify-between mt-3">
                        <Button variant="ghost" size="sm" class="flex items-center gap-1 text-xs h-8">
                            <MessageCircle class="h-4 w-4" />
                            <span>12</span>
                        </Button>
                        <Button variant="ghost" size="sm" class="flex items-center gap-1 text-xs h-8">
                            <Repeat class="h-4 w-4" />
                            <span>24</span>
                        </Button>
                        <Button variant="ghost" size="sm" class="flex items-center gap-1 text-xs h-8">
                            <Heart class="h-4 w-4" />
                            <span>89</span>
                        </Button>
                        <Button variant="ghost" size="sm" class="flex items-center gap-1 text-xs h-8">
                            <BarChart2 class="h-4 w-4" />
                            <span>1.2K</span>
                        </Button>
                        <Button variant="ghost" size="sm" class="flex items-center gap-1 text-xs h-8">
                            <Share class="h-4 w-4" />
                        </Button>
                    </div>
                </div>
            </CardHeader>
        </Card>

    </section>

</template>

<script setup>
import {
    Repeat,
    MoreHorizontal,
    CheckCircle,
    Share,
    BarChart2,
    Heart,
    MessageCircle,
} from 'lucide-vue-next'

import { Card } from '@/components/ui/card'
import { CardHeader } from '@/components/ui/card'
import { Avatar } from '@/components/ui/avatar'
import { AvatarImage } from '@/components/ui/avatar'
import { AvatarFallback } from '@/components/ui/avatar'
import { Badge } from '@/components/ui/badge'
import Button from '@/components/ui/button/Button.vue'
const propsData = defineProps({
    post: Object,
});
</script>