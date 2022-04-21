"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_views_clients_Show_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ClientShow.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ClientShow.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  name: 'ClientShow',
  props: ['client'],
  data: function data() {
    return {
      currentTab: 'bookings',
      filterBookings: 'all',
      journalData: {
        client_id: this.$route.params.id,
        journal_content: ''
      }
    };
  },
  methods: _objectSpread(_objectSpread({}, (0,vuex__WEBPACK_IMPORTED_MODULE_0__.mapActions)({
    BOOKINGS_DESTROY_HANDLE: 'clients/BOOKINGS_DESTROY_HANDLE',
    JOURNALS_STORE_HANDLE: 'clients/JOURNALS_STORE_HANDLE',
    JOURNALS_DESTROY_HANDLE: 'clients/JOURNALS_DESTROY_HANDLE'
  })), {}, {
    switchTab: function switchTab(newTab) {
      this.currentTab = newTab;
    },
    deleteBooking: function deleteBooking(id) {
      var _this = this;

      this.BOOKINGS_DESTROY_HANDLE(id).then(function (res) {
        _this.$toasted.success(res.data.message);

        _this.$emit('refreshData', _this.filterBookings);
      })["catch"](function (err) {
        _this.displayErrors(err);
      });
    },
    deleteJournal: function deleteJournal(id) {
      var _this2 = this;

      this.JOURNALS_DESTROY_HANDLE(id).then(function (res) {
        _this2.$toasted.success(res.data.message);

        _this2.$emit('refreshData', _this2.filterBookings);
      })["catch"](function (err) {
        _this2.displayErrors(err);
      });
    },
    createJournal: function createJournal() {
      var _this3 = this;

      this.clearErrors();
      this.JOURNALS_STORE_HANDLE(this.journalData).then(function (res) {
        _this3.$toasted.success(res.data.message);

        _this3.$emit('refreshData', _this3.filterBookings);
      })["catch"](function (err) {
        _this3.displayErrors(err);
      });
    },
    refreshData: function refreshData() {
      this.$emit('refreshData', this.filterBookings);
    }
  })
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/clients/Show.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/clients/Show.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
/* harmony import */ var _components_ClientShow_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../components/ClientShow.vue */ "./resources/js/components/ClientShow.vue");
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { _defineProperty(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

//
//
//
//
//
//


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  components: {
    ClientShow: _components_ClientShow_vue__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  data: function data() {
    return {
      client: {}
    };
  },
  beforeMount: function beforeMount() {
    this.getClient();
  },
  methods: _objectSpread(_objectSpread({}, (0,vuex__WEBPACK_IMPORTED_MODULE_1__.mapActions)({
    CLIENTS_SHOW_HANDLE: 'clients/CLIENTS_SHOW_HANDLE'
  })), {}, {
    getClient: function getClient(filter) {
      var _this = this;

      if (!filter) filter = 'all';
      this.CLIENTS_SHOW_HANDLE({
        id: this.$route.params.id,
        filter: filter
      }).then(function (res) {
        _this.client = res.data.data;
      })["catch"](function (err) {
        _this.$router.push({
          name: 'clients'
        });

        _this.displayErrors(err);
      });
    }
  })
});

/***/ }),

/***/ "./resources/js/components/ClientShow.vue":
/*!************************************************!*\
  !*** ./resources/js/components/ClientShow.vue ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _ClientShow_vue_vue_type_template_id_7ffe1e13___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./ClientShow.vue?vue&type=template&id=7ffe1e13& */ "./resources/js/components/ClientShow.vue?vue&type=template&id=7ffe1e13&");
/* harmony import */ var _ClientShow_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ClientShow.vue?vue&type=script&lang=js& */ "./resources/js/components/ClientShow.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _ClientShow_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _ClientShow_vue_vue_type_template_id_7ffe1e13___WEBPACK_IMPORTED_MODULE_0__.render,
  _ClientShow_vue_vue_type_template_id_7ffe1e13___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/ClientShow.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/views/clients/Show.vue":
/*!*********************************************!*\
  !*** ./resources/js/views/clients/Show.vue ***!
  \*********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Show_vue_vue_type_template_id_6afd7d7a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Show.vue?vue&type=template&id=6afd7d7a& */ "./resources/js/views/clients/Show.vue?vue&type=template&id=6afd7d7a&");
/* harmony import */ var _Show_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Show.vue?vue&type=script&lang=js& */ "./resources/js/views/clients/Show.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Show_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Show_vue_vue_type_template_id_6afd7d7a___WEBPACK_IMPORTED_MODULE_0__.render,
  _Show_vue_vue_type_template_id_6afd7d7a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/clients/Show.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/components/ClientShow.vue?vue&type=script&lang=js&":
/*!*************************************************************************!*\
  !*** ./resources/js/components/ClientShow.vue?vue&type=script&lang=js& ***!
  \*************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ClientShow_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ClientShow.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ClientShow.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_ClientShow_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/clients/Show.vue?vue&type=script&lang=js&":
/*!**********************************************************************!*\
  !*** ./resources/js/views/clients/Show.vue?vue&type=script&lang=js& ***!
  \**********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Show_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Show.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/clients/Show.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Show_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/ClientShow.vue?vue&type=template&id=7ffe1e13&":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/ClientShow.vue?vue&type=template&id=7ffe1e13& ***!
  \*******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ClientShow_vue_vue_type_template_id_7ffe1e13___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ClientShow_vue_vue_type_template_id_7ffe1e13___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_ClientShow_vue_vue_type_template_id_7ffe1e13___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./ClientShow.vue?vue&type=template&id=7ffe1e13& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ClientShow.vue?vue&type=template&id=7ffe1e13&");


/***/ }),

/***/ "./resources/js/views/clients/Show.vue?vue&type=template&id=6afd7d7a&":
/*!****************************************************************************!*\
  !*** ./resources/js/views/clients/Show.vue?vue&type=template&id=6afd7d7a& ***!
  \****************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Show_vue_vue_type_template_id_6afd7d7a___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Show_vue_vue_type_template_id_6afd7d7a___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Show_vue_vue_type_template_id_6afd7d7a___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./Show.vue?vue&type=template&id=6afd7d7a& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/clients/Show.vue?vue&type=template&id=6afd7d7a&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ClientShow.vue?vue&type=template&id=7ffe1e13&":
/*!**********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/components/ClientShow.vue?vue&type=template&id=7ffe1e13& ***!
  \**********************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _c("h1", { staticClass: "mb-6" }, [
      _vm._v(_vm._s("Clients") + " -> " + _vm._s(_vm.client.name)),
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "flex" }, [
      _c("div", { staticClass: "w-1/3 mr-5" }, [
        _c("div", { staticClass: "w-full bg-white rounded p-4" }, [
          _c("h2", [_vm._v(_vm._s("Client Info"))]),
          _vm._v(" "),
          _c("table", [
            _c("tbody", [
              _c("tr", [
                _c("th", { staticClass: "text-gray-600 pr-3" }, [
                  _vm._v(_vm._s("Name")),
                ]),
                _vm._v(" "),
                _c("td", [_vm._v(_vm._s(_vm.client.name))]),
              ]),
              _vm._v(" "),
              _c("tr", [
                _c("th", { staticClass: "text-gray-600 pr-3" }, [
                  _vm._v(_vm._s("Email")),
                ]),
                _vm._v(" "),
                _c("td", [_vm._v(_vm._s(_vm.client.email))]),
              ]),
              _vm._v(" "),
              _c("tr", [
                _c("th", { staticClass: "text-gray-600 pr-3" }, [
                  _vm._v(_vm._s("Phone")),
                ]),
                _vm._v(" "),
                _c("td", [_vm._v(_vm._s(_vm.client.phone))]),
              ]),
              _vm._v(" "),
              _c("tr", [
                _c("th", { staticClass: "text-gray-600 pr-3" }, [
                  _vm._v(_vm._s("Address")),
                ]),
                _vm._v(" "),
                _c("td", [
                  _vm._v(_vm._s(_vm.client.address)),
                  _c("br"),
                  _vm._v(_vm._s(_vm.client.postcode + " " + _vm.client.city)),
                ]),
              ]),
            ]),
          ]),
        ]),
      ]),
      _vm._v(" "),
      _c("div", { staticClass: "w-2/3" }, [
        _c("div", [
          _c(
            "button",
            {
              staticClass: "btn",
              class: {
                "btn-primary": _vm.currentTab == "bookings",
                "btn-default": _vm.currentTab != "bookings",
              },
              on: {
                click: function ($event) {
                  return _vm.switchTab("bookings")
                },
              },
            },
            [_vm._v(_vm._s("Bookings"))]
          ),
          _vm._v(" "),
          _c(
            "button",
            {
              staticClass: "btn",
              class: {
                "btn-primary": _vm.currentTab == "journals",
                "btn-default": _vm.currentTab != "journals",
              },
              on: {
                click: function ($event) {
                  return _vm.switchTab("journals")
                },
              },
            },
            [_vm._v(_vm._s("Journals"))]
          ),
        ]),
        _vm._v(" "),
        _vm.currentTab == "bookings"
          ? _c(
              "div",
              { staticClass: "bg-white rounded p-4" },
              [
                _c("h3", { staticClass: "mb-3" }, [
                  _vm._v(_vm._s("List of client bookings")),
                ]),
                _vm._v(" "),
                _vm.client.bookings && _vm.client.bookings.length > 0
                  ? [
                      _c("div", { staticClass: "form-group" }, [
                        _c(
                          "label",
                          { attrs: { for: "exampleFormControlSelect1" } },
                          [_vm._v(_vm._s("Filter bookings"))]
                        ),
                        _vm._v(" "),
                        _c(
                          "select",
                          {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.filterBookings,
                                expression: "filterBookings",
                              },
                            ],
                            staticClass: "form-control",
                            attrs: { id: "filterBookings" },
                            on: {
                              change: [
                                function ($event) {
                                  var $$selectedVal = Array.prototype.filter
                                    .call($event.target.options, function (o) {
                                      return o.selected
                                    })
                                    .map(function (o) {
                                      var val =
                                        "_value" in o ? o._value : o.value
                                      return val
                                    })
                                  _vm.filterBookings = $event.target.multiple
                                    ? $$selectedVal
                                    : $$selectedVal[0]
                                },
                                _vm.refreshData,
                              ],
                            },
                          },
                          [
                            _c("option", { attrs: { value: "all" } }, [
                              _vm._v(_vm._s("All bookings")),
                            ]),
                            _vm._v(" "),
                            _c("option", { attrs: { value: "future" } }, [
                              _vm._v(_vm._s("Future Bookings only")),
                            ]),
                            _vm._v(" "),
                            _c("option", { attrs: { value: "past" } }, [
                              _vm._v(_vm._s("Past bookings only")),
                            ]),
                          ]
                        ),
                      ]),
                      _vm._v(" "),
                      _c("table", [
                        _c("thead", [
                          _c("tr", [
                            _c("th", [_vm._v(_vm._s("Time"))]),
                            _vm._v(" "),
                            _c("th", [_vm._v(_vm._s("Notes"))]),
                            _vm._v(" "),
                            _c("th", [_vm._v(_vm._s("Actions"))]),
                          ]),
                        ]),
                        _vm._v(" "),
                        _c(
                          "tbody",
                          _vm._l(_vm.client.bookings, function (booking) {
                            return _c("tr", { key: booking.id }, [
                              _c("td", [
                                _vm._v(
                                  _vm._s(booking.start) +
                                    " to " +
                                    _vm._s(booking.end)
                                ),
                              ]),
                              _vm._v(" "),
                              _c("td", [_vm._v(_vm._s(booking.notes))]),
                              _vm._v(" "),
                              _c("td", [
                                _c(
                                  "button",
                                  {
                                    staticClass: "btn btn-danger btn-sm",
                                    on: {
                                      click: function ($event) {
                                        return _vm.deleteBooking(booking.id)
                                      },
                                    },
                                  },
                                  [_vm._v(_vm._s("Delete"))]
                                ),
                              ]),
                            ])
                          }),
                          0
                        ),
                      ]),
                    ]
                  : [
                      _c("p", { staticClass: "text-center" }, [
                        _vm._v(_vm._s("The client has no bookings.")),
                      ]),
                    ],
              ],
              2
            )
          : _vm._e(),
        _vm._v(" "),
        _vm.currentTab == "journals"
          ? _c(
              "div",
              { staticClass: "bg-white rounded p-4" },
              [
                _c("h3", { staticClass: "mb-3" }, [
                  _vm._v(_vm._s("List of client journals")),
                ]),
                _vm._v(" "),
                _c("h3", { staticClass: "mb-6" }, [
                  _vm._v(_vm._s("Add new journal")),
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "form-group" }, [
                  _c("label", { attrs: { for: "journal_content" } }, [
                    _vm._v(_vm._s("Journal content")),
                  ]),
                  _vm._v(" "),
                  _c("textarea", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.journalData.journal_content,
                        expression: "journalData.journal_content",
                      },
                    ],
                    staticClass: "form-control",
                    attrs: { rows: "5", id: "journal_content" },
                    domProps: { value: _vm.journalData.journal_content },
                    on: {
                      input: function ($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(
                          _vm.journalData,
                          "journal_content",
                          $event.target.value
                        )
                      },
                    },
                  }),
                  _vm._v(" "),
                  _vm._m(0),
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "text-right" }, [
                  _c(
                    "button",
                    {
                      staticClass: "btn btn-primary",
                      on: { click: _vm.createJournal },
                    },
                    [_vm._v(_vm._s("Create journal"))]
                  ),
                ]),
                _vm._v(" "),
                _vm.client.journals && _vm.client.journals.length > 0
                  ? [
                      _c("table", [
                        _c("thead", [
                          _c("tr", [
                            _c("th", [_vm._v(_vm._s("Date"))]),
                            _vm._v(" "),
                            _c("th", [_vm._v(_vm._s("Content"))]),
                            _vm._v(" "),
                            _c("th", [_vm._v(_vm._s("Actions"))]),
                          ]),
                        ]),
                        _vm._v(" "),
                        _c(
                          "tbody",
                          _vm._l(_vm.client.journals, function (journal) {
                            return _c("tr", { key: journal.id }, [
                              _c("td", [_vm._v(_vm._s(journal.journal_date))]),
                              _vm._v(" "),
                              _c("td", [
                                _vm._v(_vm._s(journal.journal_content)),
                              ]),
                              _vm._v(" "),
                              _c("td", [
                                _c(
                                  "button",
                                  {
                                    staticClass: "btn btn-danger btn-sm",
                                    on: {
                                      click: function ($event) {
                                        return _vm.deleteJournal(journal.id)
                                      },
                                    },
                                  },
                                  [_vm._v(_vm._s("Delete"))]
                                ),
                              ]),
                            ])
                          }),
                          0
                        ),
                      ]),
                    ]
                  : [
                      _c("p", { staticClass: "text-center" }, [
                        _vm._v(_vm._s("The client has no journals.")),
                      ]),
                    ],
              ],
              2
            )
          : _vm._e(),
      ]),
    ]),
  ])
}
var staticRenderFns = [
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "span",
      { staticClass: "invalid-feedback", attrs: { role: "alert" } },
      [_c("strong")]
    )
  },
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/clients/Show.vue?vue&type=template&id=6afd7d7a&":
/*!*******************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/clients/Show.vue?vue&type=template&id=6afd7d7a& ***!
  \*******************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "container-fluid" },
    [
      _c("client-show", {
        attrs: { client: _vm.client },
        on: { refreshData: _vm.getClient },
      }),
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ })

}]);