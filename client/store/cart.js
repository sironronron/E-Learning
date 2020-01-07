import axios from 'axios'
import Cookies from 'js-cookie'

// State
export const state = () => ({
    cart: null
})

// Getters
export const getters = {
    cart: state => state.cart,
    check: state => state.cart !== null
}

// Mutations
export const mutations = {

    FETCH_CART_SUCCESS (state, cart) {
        state.cart = cart
    },

    UPDATE_CART (state, { cart }) {
        state.cart = cart
    }

}