<template>
  <div class="min-h-screen bg-gradient-to-br from-background to-muted flex items-center justify-center p-4">
    <Card class="w-full max-w-2xl">
      <CardHeader>
        <CardTitle class="text-2xl font-bold">Create New Post</CardTitle>
      </CardHeader>
      <CardContent>
        <form @submit.prevent="handleSubmit" class="space-y-6">
          <!-- Title Input -->
          <div class="space-y-2">
            <Label for="title">Post Title</Label>
            <Input 
              id="title" 
              v-model="post.title" 
              placeholder="Enter post title"
              required
            />
            <p v-if="errors.title" class="text-sm text-destructive">{{ errors.title }}</p>
          </div>
          
          <!-- Content Input -->
          <div class="space-y-2">
            <Label for="content">Post Content</Label>
            <Textarea 
              id="content" 
              v-model="post.content" 
              rows="6" 
              placeholder="Write your post content here..."
              required
            />
            <p v-if="errors.content" class="text-sm text-destructive">{{ errors.content }}</p>
          </div>
          
          <!-- Platform Selection -->
          <div class="space-y-3">
            <div class="flex justify-between items-center">
              <Label>Publishing Platforms</Label>
              <p class="text-xs text-muted-foreground">Select one or more platforms</p>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
              <div 
                v-for="platform in availablePlatforms" 
                :key="platform.id"
                @click="togglePlatform(platform.id)"
                :class="[
                  'cursor-pointer rounded-lg p-3 border transition-all duration-200',
                  isPlatformSelected(platform.id) 
                    ? 'border-primary bg-primary/10 shadow-sm' 
                    : 'border-border hover:border-primary/20 hover:bg-muted/50'
                ]"
              >
                <div class="flex flex-col items-center text-center">
                  <div class="h-10 w-10 rounded-full flex items-center justify-center mb-2" :class="platform.bgColor">
                    <component :is="platform.icon" class="h-5 w-5" :class="platform.iconColor" />
                  </div>
                  <span class="text-sm font-medium">{{ platform.name }}</span>
                  <div class="mt-2">
                    <div 
                      :class="[
                        'h-4 w-4 rounded-full mx-auto', 
                        isPlatformSelected(platform.id) ? 'bg-primary' : 'bg-muted'
                      ]"
                    ></div>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Selected Platforms Summary -->
            <div v-if="selectedPlatforms.length > 0" class="flex flex-wrap gap-2 mt-2">
              <Badge
                v-for="platform in selectedPlatforms" 
                :key="platform.id"
                variant="secondary"
                class="px-3 py-1"
              >
                {{ platform.name }}
              </Badge>
            </div>
            
            <p v-if="errors.platforms" class="text-sm text-destructive mt-1">{{ errors.platforms }}</p>
          </div>
          
          <!-- Publishing Options with RadioGroup -->
          <div class="space-y-3">
            <Label id="publish-option-label">Publishing Options</Label>
            <RadioGroup
              v-model="post.publishOption" 
              class="grid grid-cols-3 gap-3"
              aria-labelledby="publish-option-label"
            >
              <!-- Publish Now Option -->
              <Label 
                :for="'publish-option-publish'"
                :class="[
                  'cursor-pointer rounded-lg p-4 border transition-all duration-200',
                  post.publishOption === 'publish' 
                    ? 'border-primary bg-primary/10 shadow-sm' 
                    : 'border-border hover:border-primary/20 hover:bg-muted/50'
                ]"
              >
                <RadioGroupItem
                  id="publish-option-publish" 
                  value="publish" 
                  class="sr-only"
                />
                <div class="flex flex-col items-center text-center">
                  <div class="h-10 w-10 rounded-full bg-primary/20 flex items-center justify-center mb-2">
                    <ArrowRightIcon class="h-5 w-5 text-primary" />
                  </div>
                  <span class="font-medium">Publish Now</span>
                  <p class="text-xs text-muted-foreground mt-1">Go live immediately</p>
                  <div class="mt-2">
                    <div 
                      :class="[
                        'h-4 w-4 rounded-full mx-auto', 
                        post.publishOption === 'publish' ? 'bg-primary' : 'bg-muted'
                      ]"
                    ></div>
                  </div>
                </div>
              </Label>
              
              <!-- Schedule Option -->
              <Label 
                :for="'publish-option-schedule'"
                :class="[
                  'cursor-pointer rounded-lg p-4 border transition-all duration-200',
                  post.publishOption === 'schedule' 
                    ? 'border-primary bg-primary/10 shadow-sm' 
                    : 'border-border hover:border-primary/20 hover:bg-muted/50'
                ]"
              >
                <RadioGroupItem 
                  id="publish-option-schedule" 
                  value="schedule" 
                  class="sr-only"
                />
                <div class="flex flex-col items-center text-center">
                  <div class="h-10 w-10 rounded-full bg-primary/20 flex items-center justify-center mb-2">
                    <ClockIcon class="h-5 w-5 text-primary" />
                  </div>
                  <span class="font-medium">Schedule</span>
                  <p class="text-xs text-muted-foreground mt-1">Set future date & time</p>
                  <div class="mt-2">
                    <div 
                      :class="[
                        'h-4 w-4 rounded-full mx-auto', 
                        post.publishOption === 'schedule' ? 'bg-primary' : 'bg-muted'
                      ]"
                    ></div>
                  </div>
                </div>
              </Label>
              
              <!-- Draft Option -->
              <Label 
                :for="'publish-option-draft'"
                :class="[
                  'cursor-pointer rounded-lg p-4 border transition-all duration-200',
                  post.publishOption === 'draft' 
                    ? 'border-primary bg-primary/10 shadow-sm' 
                    : 'border-border hover:border-primary/20 hover:bg-muted/50'
                ]"
              >
                <RadioGroupItem 
                  id="publish-option-draft" 
                  value="draft" 
                  class="sr-only"
                />
                <div class="flex flex-col items-center text-center">
                  <div class="h-10 w-10 rounded-full bg-primary/20 flex items-center justify-center mb-2">
                    <PencilIcon class="h-5 w-5 text-primary" />
                  </div>
                  <span class="font-medium">Save Draft</span>
                  <p class="text-xs text-muted-foreground mt-1">Edit later before publishing</p>
                  <div class="mt-2">
                    <div 
                      :class="[
                        'h-4 w-4 rounded-full mx-auto', 
                        post.publishOption === 'draft' ? 'bg-primary' : 'bg-muted'
                      ]"
                    ></div>
                  </div>
                </div>
              </Label>
            </RadioGroup>
          </div>
          
          <!-- Schedule Date/Time (conditionally shown) -->
          <div 
            v-if="post.publishOption === 'schedule'" 
            class="p-5 bg-muted/50 rounded-lg border border-border animate-fadeIn space-y-4"
          >
            <h4 class="text-sm font-medium">Schedule Details</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="space-y-2">
                <Label for="scheduleDate">Date</Label>
                <Input 
                  id="scheduleDate" 
                  v-model="post.scheduleDate" 
                  type="date" 
                  :min="minDate"
                  required
                />
              </div>
              
              <div class="space-y-2">
                <Label for="scheduleTime">Time</Label>
                <Input 
                  id="scheduleTime" 
                  v-model="post.scheduleTime" 
                  type="time" 
                  required
                />
              </div>
            </div>
            <p v-if="errors.schedule" class="text-sm text-destructive">{{ errors.schedule }}</p>
          </div>
          
          <!-- Tags (optional feature) -->
          <div class="space-y-2">
            <Label for="tags">Tags (optional)</Label>
            <Input 
              id="tags" 
              v-model="post.tags" 
              placeholder="Enter tags separated by commas"
            />
            <p class="text-xs text-muted-foreground">Add relevant tags to help categorize your post</p>
          </div>
          
          <!-- Submit Button -->
          <div class="flex justify-end pt-2">
            <Button
              type="submit" 
              class="bg-primary text-primary-foreground hover:bg-primary/90"
            >
              {{ submitButtonText }}
            </Button>
          </div>
        </form>
      </CardContent>
    </Card>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { 
  ArrowRightIcon, 
  ClockIcon, 
  PencilIcon,
  TwitterIcon,
  FacebookIcon,
  InstagramIcon,
  LinkedinIcon,
  YoutubeIcon,
  TwitchIcon,
  GithubIcon
} from 'lucide-vue-next';
import Card from '@/components/ui/card/Card.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import Label from '@/components/ui/label/Label.vue';
import Input from '@/components/ui/input/Input.vue';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import Badge from '@/components/ui/badge/Badge.vue';
import RadioGroup from '@/components/ui/radio-group/RadioGroup.vue';
import RadioGroupItem from '@/components/ui/radio-group/RadioGroupItem.vue';
import Button from '@/components/ui/button/Button.vue';

// Available platforms
const availablePlatforms = [
  { 
    id: 'twitter', 
    name: 'Twitter', 
    icon: TwitterIcon,
    bgColor: 'bg-blue-100', 
    iconColor: 'text-blue-500' 
  },
  { 
    id: 'facebook', 
    name: 'Facebook', 
    icon: FacebookIcon,
    bgColor: 'bg-indigo-100', 
    iconColor: 'text-indigo-500' 
  },
  { 
    id: 'instagram', 
    name: 'Instagram', 
    icon: InstagramIcon,
    bgColor: 'bg-pink-100', 
    iconColor: 'text-pink-500' 
  },
  { 
    id: 'linkedin', 
    name: 'LinkedIn', 
    icon: LinkedinIcon,
    bgColor: 'bg-blue-100', 
    iconColor: 'text-blue-700' 
  },
  { 
    id: 'youtube', 
    name: 'YouTube', 
    icon: YoutubeIcon,
    bgColor: 'bg-red-100', 
    iconColor: 'text-red-600' 
  },
  { 
    id: 'github', 
    name: 'GitHub', 
    icon: GithubIcon,
    bgColor: 'bg-gray-100', 
    iconColor: 'text-gray-900' 
  },
  { 
    id: 'twitch', 
    name: 'Twitch', 
    icon: TwitchIcon,
    bgColor: 'bg-purple-100', 
    iconColor: 'text-purple-600' 
  },
  { 
    id: 'medium', 
    name: 'Medium', 
    icon: PencilIcon,
    bgColor: 'bg-gray-100', 
    iconColor: 'text-gray-700' 
  }
];

// Form data
const post = ref({
  title: '',
  content: '',
  publishOption: 'publish', // Default to publish now
  scheduleDate: '',
  scheduleTime: '',
  tags: '',
  selectedPlatformIds: [] // Array to store selected platform IDs
});

// Form validation errors
const errors = ref({});

// Get today's date in YYYY-MM-DD format for min date attribute
const minDate = computed(() => {
  const today = new Date();
  const year = today.getFullYear();
  const month = String(today.getMonth() + 1).padStart(2, '0');
  const day = String(today.getDate()).padStart(2, '0');
  return `${year}-${month}-${day}`;
});

// Dynamic submit button text based on selected option
const submitButtonText = computed(() => {
  switch (post.value.publishOption) {
    case 'publish':
      return 'Publish Now';
    case 'schedule':
      return 'Schedule Post';
    case 'draft':
      return 'Save as Draft';
    default:
      return 'Submit';
  }
});

// Computed property to get selected platforms based on IDs
const selectedPlatforms = computed(() => {
  return availablePlatforms.filter(platform => 
    post.value.selectedPlatformIds.includes(platform.id)
  );
});

// Check if a platform is selected
const isPlatformSelected = (platformId) => {
  return post.value.selectedPlatformIds.includes(platformId);
};

// Toggle platform selection
const togglePlatform = (platformId) => {
  if (isPlatformSelected(platformId)) {
    // Remove platform if already selected
    post.value.selectedPlatformIds = post.value.selectedPlatformIds.filter(id => id !== platformId);
  } else {
    // Add platform if not selected
    post.value.selectedPlatformIds.push(platformId);
  }
};

// Form submission handler
const handleSubmit = () => {
  // Reset errors
  errors.value = {};
  
  // Validate form
  if (!post.value.title.trim()) {
    errors.value.title = 'Post title is required';
  }
  
  if (!post.value.content.trim()) {
    errors.value.content = 'Post content is required';
  }
  
  // Validate platforms
  if (post.value.selectedPlatformIds.length === 0) {
    errors.value.platforms = 'Please select at least one platform';
  }
  
  // Validate schedule if that option is selected
  if (post.value.publishOption === 'schedule') {
    if (!post.value.scheduleDate || !post.value.scheduleTime) {
      errors.value.schedule = 'Please select both date and time for scheduling';
    } else {
      // Validate that the scheduled time is in the future
      const scheduledDateTime = new Date(`${post.value.scheduleDate}T${post.value.scheduleTime}`);
      if (scheduledDateTime <= new Date()) {
        errors.value.schedule = 'Scheduled time must be in the future';
      }
    }
  }
  
  // If there are no errors, submit the form
  if (Object.keys(errors.value).length === 0) {
    // Prepare data for submission
    const formData = {
      title: post.value.title,
      content: post.value.content,
      publishOption: post.value.publishOption,
      scheduledFor: post.value.publishOption === 'schedule' 
        ? new Date(`${post.value.scheduleDate}T${post.value.scheduleTime}`) 
        : null,
      tags: post.value.tags ? post.value.tags.split(',').map(tag => tag.trim()) : [],
      platforms: selectedPlatforms.value.map(platform => ({
        id: platform.id,
        name: platform.name
      }))
    };
    
    // Here you would typically send the data to your API
    console.log('Submitting post:', formData);
    
    // Show success message (in a real app, you'd wait for API response)
    alert(`Post ${getStatusMessage(post.value.publishOption)} to ${selectedPlatforms.value.length} platform(s)`);
    
    // Reset form after successful submission
    resetForm();
  }
};

// Helper function to get status message
const getStatusMessage = (option) => {
  switch (option) {
    case 'publish':
      return 'published successfully';
    case 'schedule':
      return 'scheduled successfully';
    case 'draft':
      return 'saved as draft';
    default:
      return 'submitted successfully';
  }
};

// Reset form to initial state
const resetForm = () => {
  post.value = {
    title: '',
    content: '',
    publishOption: 'publish',
    scheduleDate: '',
    scheduleTime: '',
    tags: '',
    selectedPlatformIds: []
  };
};
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