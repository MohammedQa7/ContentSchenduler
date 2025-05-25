<template>
    <CardFooter class="flex items-center justify-between p-4">
        <div class="text-sm text-muted-foreground">
            Showing <strong>{{ item.meta.from }}</strong> to <strong>{{ item.meta.to }}</strong> of
            <strong>{{ item.meta.total }}</strong> results
        </div>
        <div class="flex items-center space-x-2">

            <Link v-if="!isNull(item.links.prev)" :href="item.links.prev" preserve-scroll preserve-state>
            <Button variant="outline" size="sm" :disabled="isNull(item.links.prev)">Previous</Button>
            </Link>
            <Button v-else variant="outline" size="sm" :disabled="isNull(item.links.prev)">Previous</Button>


            <Link v-if="!isNull(item.links.next)" :href="item.links.next" preserve-scroll preserve-state>
            <Button variant="outline" size="sm" :disabled="isNull(item.links.next)">Next</Button>
            </Link>
            <Button v-else variant="outline" size="sm" :disabled="isNull(item.links.next)">Next</Button>

        </div>
    </CardFooter>
</template>

<script setup>
import Button from './ui/button/Button.vue';
import CardFooter from './ui/card/CardFooter.vue';
import { isNull } from 'lodash';
const propsData = defineProps({
    item: Object
});

</script>