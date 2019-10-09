const fixZero = str => {
  return ("0" + str).slice(-2);
};
// 将时间前补0
const fixTime = time => {
  let [hour, minute, seconds] = time.split(":");
  return `${fixZero(hour)}:${fixZero(minute)}:${fixZero(seconds)}`;
};
// 将数字转化为英文名称
const turnNumberToweek = number => {
  let date = [
    "monday",
    "tuesday",
    "wednesday",
    "thursday",
    "friday",
    "saturday",
    "sunday"
  ];
  return date[number] || number;
};
// 将英文星期转换为数字
const turnWeekToNumber = week => {
  let weekStr = {
    monday: 0,
    tuesday: 1,
    wednesday: 2,
    thursday: 3,
    friday: 4,
    saturday: 5,
    sunday: 6
  };
  return weekStr[week];
};
const turnWeek = week => {
  // input week [0,2,3,4,6]
  // ouput 星期一、星期三至星期五、星期日
  if (!week || !week.length) {
    return "";
  }
  let arr = [],
    count = 1;
  for (let i = 0, len = week.length; i < len; ) {
    for (var j = i + 1; j < len; j++) {
      if (week[j] - week[i] === count) {
        count++;
      } else {
        break;
      }
    }
    if (count == 1) {
      arr.push(week[i]);
    } else if (count == 2) {
      arr.push(week[i]);
      arr.push(week[i + 1]);
    } else {
      arr.push(week[i] + "至" + week[i + count - 1]);
    }
    i += count; //对i进行移位
    count = 1;
  }
  const numberToWeek = str => {
    let newStr = "";
    for (let i = 0, len = str.length; i < len; i++) {
      let index = parseInt(str[i]);
      if (!isNaN(index) && index >= 0 && index <= 6) {
        newStr += "星期" + ["一", "二", "三", "四", "五", "六", "天"][index];
      } else {
        newStr += str[i];
      }
    }
    return newStr;
  };
  return numberToWeek(arr.join("、"));
};
// 获取年月日，传一个时间戳
const getYMD = timestamp => {
  let d = new Date(timestamp);
  return `${d.getFullYear()}-${fixZero(d.getMonth() + 1)}-${fixZero(
    d.getDate()
  )}`;
};
const turnTimesArea = time => {
  // input [{startTime:"00:00:00",endTime:"10:00:00"},{startTime:"12:00:00",endTime:"16:00:00"}]
  // ouput 00:00:00 ~ 10:00:00 12:00:00 ~ 16:00:00
  let a = time;
  if (!time) {
    return "";
  }
  return time.reduce((sum, item, index) => {
    return `${sum}${index === 0 ? "" : " "}${item.startTime ||
      item.begin} ~ ${item.endTime || item.end}`;
  }, "");
};
const getHMS = date => {
  let d = new Date(date);
  let arr = [d.getHours(), d.getMinutes(), d.getSeconds()];

  return `${fixZero(arr[0])}:${fixZero(arr[1])}:${fixZero(arr[2])}`;
};
/*
 * @param time 时分秒 08:00:00
 * @param count 增加的小时数
 * @return  返回time增加 count小时的时间，不超过23:59:59
 */
const addHoursTime = (time, count) => {
  console.log(time);
  console.log(time);
  let [hour, minute] = time.split(":");
  hour = parseInt(hour) + count;

  if (hour >= 24) {
    return "23:59:59";
  } else {
    return `${hour}:${minute}:00`;
  }
};
export {
  fixTime,
  turnWeek,
  turnTimesArea,
  getHMS,
  addHoursTime,
  getYMD,
  turnNumberToweek,
  turnWeekToNumber,
  fixZero
};
