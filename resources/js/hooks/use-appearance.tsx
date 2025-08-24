// resources/js/hooks/use-appearance.tsx
import { useState, useEffect } from 'react';

export type Appearance = 'light' | 'dark' | 'system';

export const useAppearance = () => {
    const [appearance, setAppearance] = useState<Appearance>(
        (localStorage.getItem('appearance') as Appearance) || 'light'
    );

    useEffect(() => {
        const root = document.documentElement;
        if (appearance === 'system') {
            const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            root.classList.toggle('dark', systemPrefersDark);
            localStorage.setItem('appearance', 'system');
        } else {
            root.classList.toggle('dark', appearance === 'dark');
            localStorage.setItem('appearance', appearance);
        }
    }, [appearance]);

    const updateAppearance = (newAppearance: Appearance) => {
        setAppearance(newAppearance);
    };

    return { appearance, updateAppearance };
};