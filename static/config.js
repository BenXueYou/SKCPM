/*
 * @Descripttion: 
 * @version: 1.0.0
 * @Author: pengxueyou@hikvision.com.cn
 * @Date: 2021-08-08 12:23:07
 * @LastEditors: 
 * @LastEditTime: 2021-09-01 15:35:42
 */
let httpUrlHeader = '/apis';
const DEBUG = 'PO';
if (DEBUG === 'PRO') {
  httpUrlHeader = 'http://47.104.204.250:80';
  // httpUrlHeader = 'http://129.28.156.99:80';
  // httpUrlHeader = 'http://175.24.87.234:80';
}
window.config = {
  pageSizeArr: [10, 30, 50],
  httpHeader: 'http://',
  ip: '47.104.204.250:8080',
  httpUrlHeader: httpUrlHeader,
  vueUedutorWrap: {
    // 编辑器不自动被内容撑高
    autoHeightEnabled: false,
    // 初始容器高度
    initialFrameHeight: 240,
    // 初始容器宽度
    initialFrameWidth: '100%',
    // 上传文件接口（这个地址是我为了方便各位体验文件上传功能搭建的临时接口，请勿在生产环境使用！！！）
    serverUrl: 'http://35.201.165.105:8000/controller.php'
  },
  tableData: [],
  alinkArr: [
    {
      strName: "关于尚宽",
      strValue: "http://www.senk.com.cn/comcontent_detail/i=2&comContentId=2.html"
    },
    {
      strName: "联系我们",
      strValue: "http://www.senk.com.cn/comcontent_detail/i=8&comContentId=8.html"
    },
    {
      strName: "产品中心",
      strValue: "http://www.senk.com.cn/products_list3/%2523%253FcolumnsId=82&pmcId=35.html"
    },
    {
      strName: "解决方案",
      strValue: "http://www.senk.com.cn/news_list3/newsCategoryId=14.html"
    },
    {
      strName: "成功案例",
      strValue: "http://www.senk.com.cn/products_list3/pmcId=36.html"
    },
    {
      strName: "服务支持",
      strValue: "http://www.senk.com.cn/fwzc/i=17&comContentId=17.html"
    },
    {
      strName: "资质荣誉",
      strValue: "http://www.senk.com.cn/comcontent_detail/i=15&comContentId=15.html"
    },
    {
      strName: "新闻中心",
      strValue: "http://www.senk.com.cn/xwzx/newsCategoryId=16.html"
    }
  ],
};
