declare module "@vue/runtime-core" {
  export interface GlobalComponents {
    "NuxtNotifications": typeof import('@kyvg/vue3-notification')['Notifications']
  }
}

declare global {
  const useNotification: typeof import('@kyvg/vue3-notification')['useNotification']
}

import { UnwrapRef } from 'vue';
declare module 'vue' {
  interface ComponentCustomProperties {
    readonly useNotification: typeof import('@kyvg/vue3-notification')['useNotification']
  }
}

declare module '@vue/runtime-core' {
  interface ComponentCustomProperties {
    readonly useNotification: typeof import('@kyvg/vue3-notification')['useNotification']
  }
}

export const NuxtNotifications: typeof import('@kyvg/vue3-notification')['Notifications']
