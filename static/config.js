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
    // serverUrl: 'http://47.104.204.250/images'
    // UEditor 资源文件的存放路径，如果你使用的是 vue-cli 生成的项目，通常不需要设置该选项，vue-ueditor-wrap 会自动处理常见的情况，如果需要特殊配置，参考下方的常见问题2
    // UEDITOR_HOME_URL: '/static/UEditor/'
    // 配合最新编译的资源文件，你可以实现添加自定义Request Headers,详情https://github.com/HaoChuan9421/ueditor/commits/dev-1.4.3.3
    // headers: {
    //   access_token: '37e7c9e3fda54cca94b8c88a4b5ddbf3'
    // }
  },
  tableData: [
    {
      date: "2016-05-02",
      name: "王小虎",
      province: "上海",
      city: "普陀区",
      address: "上海市普陀区金沙江路 1518 弄",
      zip: 200333,
      id: '1401050000000139'
    },
    {
      date: "2016-05-04",
      name: "王小虎",
      province: "上海",
      id: '1401050000000139',
      city: "普陀区",
      address: "上海市普陀区金沙江路 1517 弄",
      zip: 200333
    },
    {
      date: "2016-05-01",
      name: "王小虎",
      province: "上海",
      city: "普陀区",
      address: "上海市普陀区金沙江路 1519 弄",
      zip: 200333,
      id: '1401050000000139'
    },
    {
      date: "2016-05-03",
      name: "王小虎",
      province: "上海",
      city: "普陀区",
      address: "上海市普陀区金沙江路 1516 弄",
      zip: 200333,
      id: '1401050000000139'
    },
    {
      date: "2016-05-03",
      name: "王小虎",
      province: "上海",
      city: "普陀区",
      address: "上海市普陀区金沙江路 1516 弄",
      zip: 200333,
      id: '1401050000000139'
    },
    {
      date: "2016-05-03",
      name: "王小虎",
      province: "上海",
      city: "普陀区",
      address: "上海市普陀区金沙江路 1516 弄",
      zip: 200333,
      id: '1401050000000139'
    },
    {
      date: "2016-05-03",
      name: "王小虎",
      province: "上海",
      city: "普陀区",
      address: "上海市普陀区金沙江路 1516 弄",
      zip: 200333,
      id: '1401050000000139'
    },
    {
      date: "2016-05-03",
      name: "王小虎",
      province: "上海",
      city: "普陀区",
      address: "上海市普陀区金沙江路 1516 弄",
      zip: 200333,
      id: '1401050000000139'
    },
    {
      date: "2016-05-03",
      name: "王小虎",
      province: "上海",
      city: "普陀区",
      address: "上海市普陀区金沙江路 1516 弄",
      zip: 200333,
      id: '1401050000000139'
    },
    {
      date: "2016-05-03",
      name: "王小虎",
      province: "上海",
      city: "普陀区",
      address: "上海市普陀区金沙江路 1516 弄",
      zip: 200333,
      id: '1401050000000139'
    }
  ],
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
