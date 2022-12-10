import PageviewsFieldtype from './components/fieldtypes/Pageviews.vue';
import PopularWidget from './components/widgets/Popular.vue';

Statamic.booting(() => {
    Statamic.$components.register('pageviews-fieldtype', PageviewsFieldtype);
    Statamic.$components.register('popular-widget', PopularWidget);
});
