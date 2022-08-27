import {createStore} from 'vuex'

const store = createStore({
    state() {
        return {
            user: {
                data: {},
                token: null,
            }
        }
    },
})

export default store;
