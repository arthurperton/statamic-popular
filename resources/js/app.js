import MostPopularWidget from './components/MostPopularWidget.vue';
 
Statamic.booting(() => {
    Statamic.$components.register('most-popular-widget', MostPopularWidget);
});
