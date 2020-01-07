export default ({ store, redirect }) => {
    const user = store.getters['auth/user']
    if (user.role_id === 3) {
        return redirect('/instructor/courses')
    }
}