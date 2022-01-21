import IHeader from "./src/i-header.vue";

IHeader.install = (Vue) => {
  Vue.component(IHeader.name, IHeader);
};

export default IHeader;