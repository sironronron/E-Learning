export default {
    state: {
        success: null,
        error: null
    },
    setSuccess(message) {
        this.state.success = message
        this.removeError() 
        setTimeout(() => {
            this.removeSuccess()
        }, 3000)
    },
    setError(message) {
        this.state.error = message
        this.removeSuccess()
        setTimeout(() => {
            this.removeError
        }, 3000)
    },
    removeSuccess() {
        this.state.success = null
    },
    removeError() {
        this.state.error = null
    }
}