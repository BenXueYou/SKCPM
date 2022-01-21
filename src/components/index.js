import IHeader from "./i-header";
import IPageMenu from "./i-page-menu";
import IBreadcrumb from "./i-breadcrumb";

console.log(IHeader);

const components = [ IHeader, IPageMenu, IBreadcrumb];

const install = (Vue) => {
  components.forEach((component) => Vue.component(component.name, component));
}

export default install