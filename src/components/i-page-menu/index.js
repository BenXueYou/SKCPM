import IPageMenu from "./src/i-page-menu.vue";

IPageMenu.install = (Vue) => {
  Vue.component(IPageMenu.name, IPageMenu)
}

export default IPageMenu;