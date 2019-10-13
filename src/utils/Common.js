import store from "@/store/store.js";
export var COMMON = {
  /**
   *
   * 时间秒转时分秒
   */
  formatSeconds(value) {
    var secondTime = parseInt(value);// 秒
    var minuteTime = 0;// 分
    var hourTime = 0;// 小时
    if (secondTime > 60) { // 如果秒数大于60，将秒数转换成整数
      // 获取分钟，除以60取整数，得到整数分钟
      minuteTime = parseInt(secondTime / 60);
      // 获取秒数，秒数取佘，得到整数秒数
      secondTime = parseInt(secondTime % 60);
      // 如果分钟大于60，将分钟转换成小时
      if (minuteTime > 60) {
        // 获取小时，获取分钟除以60，得到整数小时
        hourTime = parseInt(minuteTime / 60);
        // 获取小时后取佘的分，获取分钟除以60取佘的分
        minuteTime = parseInt(minuteTime % 60);
      }
    }
    var result = "" + parseInt(secondTime) + "秒";

    if (minuteTime > 0) {
      result = "" + parseInt(minuteTime) + "分" + result;
    }
    if (hourTime > 0) {
      result = "" + parseInt(hourTime) + "小时" + result;
    }
    return result;
  },

  /**
   * 通过年月获取当月天数
   */
  getDaysByMonth(year, month) {
    month = parseInt(month);
    let temp = new Date(year, month, 0);
    return temp.getDate();
  },

  /**
   * 通过年月获取当月第一天是周几
   */
  getFirstDayWeekByMonth(year, month) {
    month = parseInt(month);
    let temp = new Date(year, (month - 1).toString(), "01");
    return temp.getDay();
  },

  /**
   * 格式化日期为：yyyy-mm-dd hh:mm:ss
   */
  formatDate(d) {
    let year = d.getFullYear();
    let month = this.change(d.getMonth() + 1);
    let day = this.change(d.getDate());
    let hour = this.change(d.getHours());
    let minute = this.change(d.getMinutes());
    let second = this.change(d.getSeconds());
    return (
      year + "-" + month + "-" + day + " " + hour + ":" + minute + ":" + second
    );
  },
  /**
   * 获取一天的前一天的此刻(yyyy-mm-dd hh:mm:ss)
   */
  getYesterday(date) {
    let yesterday = "";
    yesterday = this.formatDate(new Date(date.getTime() - 24 * 60 * 60 * 1000));
    return yesterday;
  },

  change(t) {
    return ("0" + t).slice(-2);
  },

  // 变量的重置
  getStartTime() {
    var MyDate = new Date();
    return (
      MyDate.getFullYear() +
      "-" +
      this.change(MyDate.getMonth() + 1) +
      "-" +
      this.change(MyDate.getDate()) +
      " 00:00:00"
    );
  },
  // 获取当前时间
  getCurrentTime() {
    var MyDate = new Date();
    return (
      MyDate.getFullYear() +
      "-" +
      this.change(MyDate.getMonth() + 1) +
      "-" +
      this.change(MyDate.getDate()) +
      " " +
      this.change(MyDate.getHours()) +
      ":" +
      this.change(MyDate.getMinutes()) +
      ":" +
      this.change(MyDate.getSeconds())
    );
  },
  // 获取当前日期
  getCurrentDate() {
    var MyDate = new Date();
    return (
      MyDate.getFullYear() +
      "-" +
      this.change(MyDate.getMonth() + 1) +
      "-" +
      this.change(MyDate.getDate()) +
      " " +
      "00:00:00"
    );
  },
  // 获取当前首卡开门默认截止时间
  getCurrentEndTime() {
    // 创建日期对象，并初始化，完成文本转日期
    var date = new Date();
    // 日期转文本方式一：
    var str = "";
    var year = date.getFullYear(); // 年
    var month = date.getMonth() + 6; // 月 +6个月  因为js里month从0开始，所以要加1
    if (month > 12) {
      year++;
      month -= 12;
    }
    if (month < 10) {
      month = "0" + month;
    }
    var date2 = new Date(year, month, 0); // 新的年月
    var day1 = date.getDate();
    var day2 = date2.getDate();
    if (day1 > day2) {
      // 防止+6月后没有31天
      day1 = day2;
    }
    if (day1 < 10) {
      day1 = "0" + day1;
    }
    str = year + "-" + month + "-" + day1;

    // 最后赋值文本框显示
    return str + " " + "23:59:59";
  },
  // 时间戳毫秒数转为时间格式
  // timestamp : 毫秒数
  // formdate : 时间格式
  timestampToFormatter(timestamp, formdate = "HH:mm:ss") {
    let date = new Date(timestamp);
    var year = date.getFullYear();
    var month =
      date.getMonth() + 1 < 10
        ? "0" + (date.getMonth() + 1)
        : date.getMonth() + 1;
    var currentDate =
      date.getDate() < 10 ? "0" + date.getDate() : date.getDate();
    var hours = date.getHours() < 10 ? "0" + date.getHours() : date.getHours();
    var minutes =
      date.getMinutes() < 10 ? "0" + date.getMinutes() : date.getMinutes();
    var ss =
      date.getSeconds() < 10 ? "0" + date.getSeconds() : date.getSeconds();
    if (formdate === null || formdate === "yyyy-mm-dd HH:mm:ss") {
      return (
        year +
        "-" +
        month +
        "-" +
        currentDate +
        " " +
        hours +
        ":" +
        minutes +
        ":" +
        ss
      );
    } else if (formdate === "yyyy-mm-dd") {
      return year + "-" + month + "-" + currentDate;
    } else if (formdate === "yyyy-mm") {
      return year + month;
    } else if (formdate === "mm-dd") {
      return month + "-" + currentDate;
    } else if (formdate === "HH:mm") {
      return hours + ":" + minutes;
    } else {
      return hours + ":" + minutes + ":" + ss;
    }
  },

  // 设置文本显示，若无则显示 "未知"
  setStringText(stringText) {
    let text;
    if (
      stringText === null ||
      !stringText ||
      stringText === "" ||
      stringText === undefined
    ) {
      text = "";
    } else {
      text = stringText;
    }
    return text;
  },

  // 设置图片显示，若无则显示 默认图片
  setPictureShow(imgUrl) {
    let imgUrlReturn;
    if (imgUrl === null || !imgUrl || imgUrl === "" || imgUrl === undefined) {
      imgUrlReturn = require("@/assets/images/user.png");
    } else {
      imgUrlReturn =
        window.config.protocolHeader +
        window.config.ip +
        `/fileforward-server-v1/project/${
          store.state.home.projectUuid
        }/fileforward/fileByUrl?fileUrl=` +
        imgUrl;
    }
    return imgUrlReturn;
  },
  /**
   * 深拷贝数组
   */
  copyArray(desArray, copyArray) {
    let jsonArray = JSON.stringify(desArray);
    copyArray = JSON.parse(jsonArray);
    return copyArray;
  },
  /**
   * 深拷贝对象
   */
  copyObject(desObject, copyObject) {
    let jsonObject = JSON.stringify(desObject);
    copyObject = JSON.parse(jsonObject);
    return copyObject;
  },
  /**
   * 格式化数字，数字过长中间加逗号
   */
  formatNumber(num) {
    var result = "",
      counter = 0;
    num = (num || 0).toString();
    for (var i = num.length - 1; i >= 0; i--) {
      counter++;
      result = num.charAt(i) + result;
      if (!(counter % 3) && i !== 0) {
        result = "," + result;
      }
    }
    return result;
  },

  // 一维大数组，等分为多个二维数组
  getSubArrayFromArray(data, arrSize) {
    // data = [3, 6, 4, 5, 6, 99, 55, 45, 33, 22, 90, 12, 54, 23, 33, 243, 2324, 12, 335, 23, 21, 22, 22];
    // arrSize = 12;
    // var dataArr = new Array(Math.ceil(data.length / arrSize));
    // for (let i = 0; i < dataArr.length; i++) {
    //   dataArr[i] = new Array();
    // }
    // for (let i = 0; i < data.length; i++) {
    //   dataArr[parseInt(i / arrSize)][i % arrSize] = data[i];
    // }
    let len = Math.ceil(data.length / arrSize);
    return [...Array(len).keys()].map((v, i) => {
      return data.slice(i * arrSize, (i + 1) * arrSize);
    });
  },

  /**
   * 通过groupStr获取枚举items
   */
  getEnumByGroupStr(groupStr) {
    if (
      !store.state.home.localEnums ||
      Object.keys(store.state.home.localEnums).length === 0
    ) {
      return [];
    }
    let types = [];
    for (let groupStrKey in store.state.home.localEnums) {
      if (groupStr === groupStrKey) {
        for (let typeStrKey in store.state.home.localEnums[groupStrKey]) {
          types.push({
            typeStr: typeStrKey,
            typeName: store.state.home.localEnums[groupStrKey][typeStrKey]
          });
        }
        return types;
      }
    }
    return [];
  },
  /**
   *
   * @param {*} groupStr
   * @param {*} typeStr
   */
  /**
   * 通过groupStr  找到本地枚举类 再通过typeStr 找到对应的值
   */
  getEnumItemName(groupStr, typeStr) {
    let enums = this.getEnumByGroupStr(groupStr);
    if (!enums || enums.length === 0) {
      return typeStr;
    }
    for (let enumItem of enums) {
      // 内容返回值当中返回的是 Number类型 但是枚举中返回的是 string 对于status来说 因此用的是 ==
      if (typeStr === enumItem.typeStr) {
        return enumItem.typeName;
      }
    }
    return typeStr;
  },
  /**
   *
   * @param {*} groupStr
   * @param {*} typeStr
   */
  /**
   * 通过groupStr  找到本地枚举类 再通过typeStr 找到对应的值
   */
  transferEnumItemName(enums, typeStr) {
    if (!enums || enums.length === 0) {
      return typeStr;
    }
    for (let enumItem of enums) {
      // 内容返回值当中返回的是 Number类型 但是枚举中返回的是 string 对于status来说 因此用的是 ==
      if (typeStr === enumItem.typeStr) {
        return enumItem.typeName;
      }
    }
    return typeStr;
  },
  // 递归查找所有的设备节点的通道列表
  /**
   *
   * @param {树节点node} data
   * @param {返回的叶子集合} arr
   */
  getChildren(data, arr) {
    if (!data || data.length === 0) {
      return;
    }
    for (let index = 0; index < data.length; index++) {
      if (!data[index].children) {
        arr.push(JSON.parse(JSON.stringify(data[index])));
      } else {
        this.getChildren(data[index].children, arr);
      }
    }
  },
  // 递归去掉设备树的通道节点，建立设备树节点
  hasChildren(data) {
    if (!data && data.length === 0) {
      return;
    }
    for (let index = 0; index < data.length; index++) {
      if (data[index].children === null) {
        data.splice(index, 1);
        index = index - 1;
      } else {
        this.hasChildren(data[index].children);
      }
    }
  },

  // 去掉树为展开部分的子节点冗余字段
  getOrgTreeExpandNode(data) {
    for (var i = 0; i < data.length; i++) {
      console.log(data[i].children[0].orgName);
      if (data[i].children && data[i].children[0].orgName) {
      } else {
        data[i].children = null;
      }
    }

    return data;
  },
  funBuildFile(url, name) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", url, true); // 也可以使用POST方式，根据接口
    xhr.setRequestHeader("Authorization", store.state.home.Authorization);
    xhr.responseType = "blob"; // 返回类型blob
    xhr.onload = function () {
      // 请求完成
      if (this.status === 200) {
        // 返回200
        var blob = this.response;
        var reader = new FileReader();
        reader.readAsDataURL(blob); // 转换为base64，可以直接放入a标签
        reader.onload = function (e) {
          // 转换完成，创建一个a标签用于下载
          var a = document.createElement("a");
          a.download = name;
          a.href = e.target.result;
          a.click();
        };
      }
    };
    // 发送ajax请求
    xhr.send();
  },
  throttle(func, wait, options) {
    // options中的leading:false 表示禁用第一次执行
    // trailing:false 表示晋中停止触发的回调
    // 定时器  作用域 参数 结果
    var timeout, context, args;
    // 上一个时间
    var previous = 0;
    if (!options) options = {};

    var later = function () {
      //
      previous = options.leading === false ? 0 : new Date().getTime();
      timeout = null;
      func.apply(context, args);
      if (!timeout) context = args = null;
    };

    var throttled = function () {
      // 记录当前时间
      var now = new Date().getTime();
      // 如果是第一次进来，并且leading等于false,设置previous等于now,可以阻止事件立即执行
      if (!previous && options.leading === false) previous = now;
      // 触发func 剩余的时间，定时器的执行时间不一定准确
      var remaining = wait - (now - previous);
      context = this;
      args = arguments;
      //  如果没有剩余的时间了或者你改了系统时间
      if (remaining <= 0 || remaining > wait) {
        if (timeout) {
          clearTimeout(timeout);
          timeout = null;
        }
        previous = now;
        func.apply(context, args);
        if (!timeout) context = args = null;
        // 如果timeout不存在，后面后面的事件执行使用setTimeout,traniling=false表示事件停止调用后，不执行setTimeout的最后一次
      } else if (!timeout && options.trailing !== false) {
        timeout = setTimeout(later, remaining);
      }
    };

    throttled.cancel = function () {
      clearTimeout(timeout);
      previous = 0;
      timeout = null;
    };

    return throttled;
  }
};
function install(Vue) {
  Vue.prototype.$common = COMMON;
}

export default install;
