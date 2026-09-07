import './bootstrap';
import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';

Alpine.plugin(collapse);

import accordion from './components/accordion';
import avatar from './components/avatar';
import carousel from './components/carousel';
import checkbox from './components/checkbox';
import collapsible from './components/collapsible';
import radiogroup from './components/radio-group';
import theme, { initializeTheme } from './theme';

initializeTheme();

Alpine.data('accordion', accordion);
Alpine.data('avatar', avatar);
Alpine.data('carousel', carousel);
Alpine.data('checkbox', checkbox);
Alpine.data('collapsible', collapsible);
Alpine.data('radiogroup', radiogroup);
Alpine.data('theme', theme);

Alpine.start();

// Entity modules — auto-discover and load per-entity CRUD modules.
// Uses the entity registry (modules/index.js) as Single Source of Truth.
// Each page declares data-entity="entityName"; app.js loads only what's needed.
import { entityRegistry } from './modules/index.js';

document.querySelectorAll('[data-entity]').forEach((container) => {
    const loader = entityRegistry[container.dataset.entity];
    if (loader) {
        loader(); // dynamic import — module self-initializes on load
    }
});
