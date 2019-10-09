/*
* 返回树数据的，当前节点的父节点的uuid
*/
/*
 *遍历树形数据，添加数据,如icon 图标字段
 */
export function addTreeKey(data, key, value) {
  if (!data || !data.length) {
    return;
  }
  for (var i = 0, len = data.length; i < len; i++) {
    data[i][key] = value;
    if (data[i].children && data[i].children.length) {
      addTreeKey(data[i].children, key, value);
    }
  }
}
/*
 *两个树形数据之间的对比，保存上次树的数据的展开和关闭状态
 */
export function remeberLast(data, num, selectId) {
  for (var i = 0, len = data.length; i < len; i++) {
    // data[i].isextend = data[i].isextend;
    // nowData[i].selected = data[i][key].selected;
    if (num.indexOf(data[i].orgUuid) === -1) {
      data[i].isextend = false;
    } else {
      data[i].isextend = true;
    }
    if (selectId && data[i].orgUuid === selectId) {
      data[i].selected = true;
    } else {
      data[i].selected = false;
    }
    if (data[i].children && data[i].children.length) {
      data[i].havechildren = true;
      remeberLast(data[i].children, num, selectId);
    } else {
      data[i].havechildren = false;
    }
  }
}
/*
 *遍历树形数据，复制数据，如接口返回的树形数据的字段名不是叫id、value等
 */
export function copyTreeKey(data, key, copyKey) {
  if (!data || !data.length) {
    return;
  }
  for (var i = 0, len = data.length; i < len; i++) {
    data[i][key] = data[i][copyKey];
    if (data[i].children && data[i].children.length) {
      copyTreeKey(data[i].children, key, copyKey);
    }
  }
}
