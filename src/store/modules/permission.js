import { constantRouterMap, localComponents } from '@/router';
import { RequestHelper } from '@/utils/RequestHelper';
import app from "@/store/modules/app";

/**
 * 通过meta.role判断是否与当前用户权限匹配
 * @param roles
 * @param route
 */
function hasPermission(roles, route) {
  if (route.meta && route.meta.role) {
    return roles.some(role => route.meta.role.indexOf(role) >= 0);
  } else {
    return true;
  }
}

/**
 * 递归过滤异步路由表，返回符合用户角色权限的路由表
 * @param asyncRouterMap
 * @param roles
 */
function filterAsyncRouter(asyncRouterMap, roles) {
  const accessedRouters = asyncRouterMap.filter(route => {
    if (hasPermission(roles, route)) {
      if (route.children && route.children.length) {
        route.children = filterAsyncRouter(route.children, roles);
      }
      return true;
    }
    return false;
  });
  return accessedRouters;
}

/**
 * 将本地的路由 通过接口返回的 路由数组 过滤
 */
function filterLocalRouter(routes) {
  for (let route of routes) {
    setComponentByLocalComponent(route);
  }
  console.log("==========");
  console.log(routes);
}

/**
 * 通过遍历找到 所需要的组件随后 赋值
 */
function setComponentByLocalComponent(route) {
  if (!route) {
    return;
  }
  let component = getComponentByName(route.name);
  if (component) {
    route.component = component;
  } else {
    if (route.component === null || route.component === "") {
      delete route.component;
    }
  }
  if (!route.children || route.children.length === 0) {
    return;
  }
  for (let child of route.children) {
    setComponentByLocalComponent(child);
  }
}

/**
 * 遍历出想要的组件
 */
function getComponentByName(desName) {
  if (!desName) {
    // desName为空直接返回
    return null;
  }
  for (let localComponent of localComponents) {
    if (desName === localComponent.name) {
      // 使用require 默认会多一层default
      return localComponent.component.default;
    }
  }
  return null;
}

const permission = {
  state: {
    routers: constantRouterMap,
    addRouters: []
  },
  mutations: {
    SET_ROUTERS: (state, routers) => {
      state.addRouters = routers;
      state.routers = constantRouterMap.concat(routers);
    }
  },
  actions: {
    GenerateRoutes({ commit }, data) {
      return new Promise(resolve => {
        // 这部分是模拟网络请求返回数据
        // RequestHelper.getMenuFromLocal({
        RequestHelper.getMenuFromWeb({
          appId: app.state.enumCodes.appId,
          onResult(isSuccess, data) {
            if (isSuccess && data.body.code === 200) {
              let routes = data.body.result;
              filterLocalRouter(routes);
              commit('SET_ROUTERS', routes);
              resolve();
            }
          }
        });
      });
    }
  }
};

export default permission;
