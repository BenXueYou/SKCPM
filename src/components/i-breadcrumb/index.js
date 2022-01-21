import IBreadcrumb from "./src/i-breadcrumb.vue";

IBreadcrumb.install = (Vue) => {
  Vue.component(IBreadcrumb.name, IBreadcrumb);
};

export default IBreadcrumb;