import { createStore } from 'vuex';

const store = createStore({
    state: {
        selectedSalon: null,
        selectedService: null,
    },
    mutations: {
        setSelectedSalon(state, salon) {
            state.selectedSalon = salon;
        },

        setSelectedService(state, service) {
            state.selectedService = service;
        },
    },
    actions: {
        selectSalon({ commit }, salon) {
            commit('setSelectedSalon', salon);
        },

        selectService({ commit }, service) {
            commit('setSelectedService', service);
        },
    },
    getters: {
        selectedSalon(state) {
            return state.selectedSalon;
        },

        selectedService(state) {
            return state.selectedService;
        },
    },
});

export default store;
