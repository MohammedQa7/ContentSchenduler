<template>

    <!-- Publishing Options with RadioGroup -->
    <div class="space-y-3">
        <div>
            <Label id="publish-option-label">Publishing Options</Label>
        </div>
        <RadioGroup v-model="selectedPublishOption" class="grid grid-cols-3 gap-3"
            aria-labelledby="publish-option-label">
            <!-- Publish Now Option -->
            <Label :for="'publish-option-publish'" :class="[
                'cursor-pointer rounded-lg p-4 border transition-all duration-200',
                selectedPublishOption === 'published'
                    ? 'border-primary bg-primary/10 shadow-sm'
                    : 'border-border hover:border-primary/20 hover:bg-muted/50'
            ]">
                <RadioGroupItem id="publish-option-publish" value="published" class="sr-only" />
                <div class="flex flex-col items-center text-center">
                    <div class="h-10 w-10 rounded-full bg-primary/20 flex items-center justify-center mb-2">
                        <ArrowRightIcon class="h-5 w-5 text-primary" />
                    </div>
                    <span class="font-medium">Publish Now</span>
                    <p class="text-xs text-muted-foreground mt-1">Go live immediately</p>
                    <div class="mt-2">
                        <div :class="[
                            'h-4 w-4 rounded-full mx-auto',
                            selectedPublishOption === 'published' ? 'bg-primary' : 'bg-muted'
                        ]"></div>
                    </div>
                </div>
            </Label>

            <!-- Schedule Option -->
            <Label :for="'publish-option-schedule'" :class="[
                'cursor-pointer rounded-lg p-4 border transition-all duration-200',
                selectedPublishOption === 'scheduled'
                    ? 'border-primary bg-primary/10 shadow-sm'
                    : 'border-border hover:border-primary/20 hover:bg-muted/50'
            ]">
                <RadioGroupItem id="publish-option-schedule" value="scheduled" class="sr-only" />
                <div class="flex flex-col items-center text-center">
                    <div class="h-10 w-10 rounded-full bg-primary/20 flex items-center justify-center mb-2">
                        <ClockIcon class="h-5 w-5 text-primary" />
                    </div>
                    <span class="font-medium">Schedule</span>
                    <p class="text-xs text-muted-foreground mt-1">Set future date & time</p>
                    <div class="mt-2">
                        <div :class="[
                            'h-4 w-4 rounded-full mx-auto',
                            selectedPublishOption === 'scheduled' ? 'bg-primary' : 'bg-muted'
                        ]"></div>
                    </div>
                </div>
            </Label>

            <!-- Draft Option -->
            <Label :for="'publish-option-draft'" :class="[
                'cursor-pointer rounded-lg p-4 border transition-all duration-200',
                selectedPublishOption === 'draft'
                    ? 'border-primary bg-primary/10 shadow-sm'
                    : 'border-border hover:border-primary/20 hover:bg-muted/50'
            ]">
                <RadioGroupItem id="publish-option-draft" value="draft" class="sr-only" />
                <div class="flex flex-col items-center text-center">
                    <div class="h-10 w-10 rounded-full bg-primary/20 flex items-center justify-center mb-2">
                        <PencilIcon class="h-5 w-5 text-primary" />
                    </div>
                    <span class="font-medium">Save Draft</span>
                    <p class="text-xs text-muted-foreground mt-1">Edit later before publishing</p>
                    <div class="mt-2">
                        <div :class="[
                            'h-4 w-4 rounded-full mx-auto',
                            selectedPublishOption === 'draft' ? 'bg-primary' : 'bg-muted'
                        ]"></div>
                    </div>
                </div>
            </Label>
        </RadioGroup>
    </div>


</template>

<script setup>
import { computed, onMounted, ref, watch } from 'vue';
import Label from '../ui/label/Label.vue';
import { ArrowRightIcon, ClockIcon, PencilIcon } from 'lucide-vue-next';
import RadioGroup from '../ui/radio-group/RadioGroup.vue';
import RadioGroupItem from '../ui/radio-group/RadioGroupItem.vue';
const selectedPublishOption = ref(null);
const emit = defineEmits();
const propsData = defineProps({
    publishOption: Array,
    selectedOption: String,
});

watch(selectedPublishOption, (value) => {
    emit('bindSelectedOption', value);
})

onMounted(() => {

    propsData.selectedOption
        ? selectedPublishOption.value = propsData.selectedOption
        : '';

        
})
</script>
