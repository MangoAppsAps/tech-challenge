import Vue from 'vue'

Vue.mixin({
    methods: {
        clearErrors() {
            let elems = document.getElementsByClassName('is-invalid')

            if (elems.length > 0) {
                Object.entries(elems).forEach((v) => {
                    let elem = v[1]

                    elem.classList.remove('is-invalid')

                    let messageContainer = elem.nextElementSibling
                    if (messageContainer) messageContainer.textContent = ''
                })
            }
        },
        displayErrors(err) {
            if (err.response.data.hasOwnProperty('error')) {
                if (err.response.status === 422 && err.response.data.hasOwnProperty('errorDetails')) {
                    this.$toasted.error(err.response.data.message)
                    Object.entries(err.response.data.errorDetails).forEach((v) => {
                        let elem = document.getElementById(v[0])

                        if (elem) {
                            elem.classList.add('is-invalid')

                            let messageContainer = elem.nextElementSibling
                            if (messageContainer) messageContainer.textContent = v[1][0]
                        }
                    })
                } else {
                    this.$toasted.error(err.response.data.message)
                }
            }
        },
        notEmptyObject(Obj){
            return Object.keys(Obj).length
        },
    }
})
