import { Message } from 'element-ui';

export var Toast = {
  toast(message, type) {
    Message({
      message: message,
      type: type
    });
  },

  success(message) {
    Message({
      message: message,
      type: "success"
    });
  },

  error(message) {
    Message({
      message: message,
      type: "error"
    });
  },

  info(message) {
    Message({
      message: message,
      type: "info"
    });
  },

  warn(message) {
    Message({
      message: message,
      type: "warning"
    });
  }
};

function install(Vue) {
  Vue.prototype.$cToast = Toast;
};

export default install;
