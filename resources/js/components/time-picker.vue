<template>
    <div class="flex items-center gap-2">
        <div class="flex flex-col items-center gap-1">
            <Label v-if="withLabels" for="hours" class="text-xs">Hours</Label>
            <TimePickerInput :picker="withPeriod ? '12hours' : 'hours'" :period="period" :date="internalDate"
                ref="hourRef" @rightFocus="focusMinuteRef" @update:date="updateDate" />
        </div>
        <div v-if="!withLabels">:</div>
        <div class="flex flex-col items-center gap-1">
            <Label v-if="withLabels" for="minutes" class="text-xs">Minutes</Label>
            <TimePickerInput picker="minutes" :date="internalDate" ref="minuteRef" @leftFocus="focusHourRef"
                @rightFocus="focusRightConditional" @update:date="updateDate" />
        </div>
        <div v-if="!withLabels && withSeconds">:</div>
        <div v-if="withSeconds" class="flex flex-col items-center gap-1">
            <Label v-if="withLabels" for="seconds" class="text-xs">Seconds</Label>
            <TimePickerInput picker="seconds" :date="internalDate" ref="secondRef" @leftFocus="focusMinuteRef"
                @rightFocus="focusPeriodRef" @update:date="updateDate" />
        </div>

        <div class="flex flex-col items-center gap-1">
            <Label v-if="withLabels" for="seconds" class="text-xs">Timeline</Label>
            <Select v-if="withPeriod" class="w-20" v-model="period">
                <SelectTrigger @keydown.arrow-left="focusLeftConditional" ref="periodRef">
                    <SelectValue />
                </SelectTrigger>
                <SelectContent>
                    <SelectGroup>
                        <SelectItem value="PM">
                            PM
                        </SelectItem>
                        <SelectItem value="AM">
                            AM
                        </SelectItem>
                    </SelectGroup>
                </SelectContent>
            </Select>
        </div>
    </div>
</template>

<script setup>
import { computed, ref } from 'vue';
import SelectContent from './ui/select/SelectContent.vue';
import SelectValue from './ui/select/SelectValue.vue';
import SelectTrigger from './ui/select/SelectTrigger.vue';
import Select from './ui/select/Select.vue';
import SelectItem from './ui/select/SelectItem.vue';
import Label from './ui/label/Label.vue';
import TimePickerInput from './ui/time-picker/time-picker-input.vue';

const props = defineProps({
    date: {
        type: Date,
        default: () => new Date(new Date().setHours(0, 0, 0, 0)),
    },
    withSeconds: {
        type: Boolean,
        default: false,
    },
    withPeriod: {
        type: Boolean,
        default: false,
    },
    withLabels: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['update:date']);

const internalDate = computed({
    get: () => props.date,
    set: (value) => emit('update:date', value),
});

const period = ref("PM");
const hourRef = ref(null);
const minuteRef = ref(null);
const secondRef = ref(null);
const periodRef = ref(null);

const focusMinuteRef = () => minuteRef.value?.$el.focus();
const focusHourRef = () => hourRef.value?.$el.focus();
const focusSecondRef = () => secondRef.value?.$el.focus();
const focusPeriodRef = () => periodRef.value?.$el.focus();

const focusLeftConditional = () => {
    if (props.withSeconds) {
        focusSecondRef();
    } else {
        focusMinuteRef();
    }
};
const focusRightConditional = () => {
    if (props.withSeconds) {
        focusSecondRef();
    } else {
        focusPeriodRef();
    }
};

const updateDate = (newDate) => {
    internalDate.value = newDate;
};
</script>