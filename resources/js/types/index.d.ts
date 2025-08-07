import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
}

export type AppPageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
};

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export interface Promotion {
    title: string;
    image: string;
    description: string | null;
    category: string | null;
    start_date: string;
    end_date: string;
}

export interface BusinessPromotion {
    id: number;
    name: string;
    address: string;
    longitude: number;
    latitude: number;
    promotion: Promotion;
}

export type BreadcrumbItemType = BreadcrumbItem;
