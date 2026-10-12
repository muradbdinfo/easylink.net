<script setup>
import {
    BoltIcon,
    BuildingOfficeIcon,
    CalendarIcon,
    ChartBarIcon,
    ChatBubbleLeftRightIcon,
    CheckCircleIcon,
    CloudIcon,
    Cog6ToothIcon,
    CubeIcon,
    EnvelopeIcon,
    FaceSmileIcon,
    GlobeAltIcon,
    LifebuoyIcon,
    LockClosedIcon,
    MapIcon,
    MapPinIcon,
    NewspaperIcon,
    PhoneIcon,
    PhotoIcon,
    QuestionMarkCircleIcon,
    ServerIcon,
    ShieldCheckIcon,
    SignalIcon,
    SparklesIcon,
    Squares2X2Icon,
    StarIcon,
    TvIcon,
    UserGroupIcon,
    UsersIcon,
    WifiIcon,
    WrenchScrewdriverIcon,
} from '@heroicons/vue/24/outline';
import { computed } from 'vue';

const props = defineProps({
    name: { type: String, default: 'sparkles' },
    class: { type: String, default: 'h-6 w-6' },
});

const map = {
    wifi: WifiIcon,
    'building-office': BuildingOfficeIcon,
    phone: PhoneIcon,
    server: ServerIcon,
    signal: SignalIcon,
    'shield-check': ShieldCheckIcon,
    tv: TvIcon,
    'chat-bubble-left-right': ChatBubbleLeftRightIcon,
    calendar: CalendarIcon,
    users: UsersIcon,
    map: MapIcon,
    'map-pin': MapPinIcon,
    headset: LifebuoyIcon,
    bolt: BoltIcon,
    cloud: CloudIcon,
    lock: LockClosedIcon,
    globe: GlobeAltIcon,
    check: CheckCircleIcon,
    star: StarIcon,
    envelope: EnvelopeIcon,
    smile: FaceSmileIcon,
    sparkles: SparklesIcon,
    squares: Squares2X2Icon,
    cube: CubeIcon,
    wrench: WrenchScrewdriverIcon,
    newspaper: NewspaperIcon,
    'question-mark-circle': QuestionMarkCircleIcon,
    'chart-bar': ChartBarIcon,
    cog: Cog6ToothIcon,
    photo: PhotoIcon,
    'user-group': UserGroupIcon,
};

const component = computed(() => map[props.name] ?? SparklesIcon);
</script>

<template>
    <component :is="component" :class="props.class" />
</template>
