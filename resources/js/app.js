import './bootstrap';
import Alpine from 'alpinejs';

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
