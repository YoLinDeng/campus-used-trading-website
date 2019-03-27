export default {
  install (Vue) {
    const bus = new Vue()

    Object.defineProperties(bus, {
      on: {
        get: function () {
          return this.$on
        }
      },
      emit: {
        get: function () {
          return this.$emit
        }
      },
      off: {
        get: function () {
          return this.$off
        }
      },
      once: {
        get: function () {
          return this.$once
        }
      }
    })
    if (!Vue.prototype.$business) {
      Object.defineProperty(Vue.prototype, '$business', {
        get: function () {
          return bus
        }
      })
    }
  }
}
