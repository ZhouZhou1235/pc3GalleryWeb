// 欢迎
function ZZWWwelcome(){
    console.log('-----=====-----');
    console.log('ZHOUZHOU Web World');
    console.log('欢迎来到粉糖粒子');
    console.log('简单小众幻想动物图片站');
    console.log('-----=====-----');
}
ZZWWwelcome();

// 日期
function timeDay() {
    var now = new Date();
    var yearNum = now.getFullYear();
    var monthNum = now.getMonth()+1;
    var dayNum = now.getDate();
    var nowDate = yearNum + '年' + monthNum + '月' + dayNum + '日';
    document.write(nowDate);
}

// 星期
function timeWeek(){
    var week;
    var date = new Date().getDay();
    switch(date){
        case 0: week='周日';
        break;
        case 1: week='周一';
        break;
        case 2: week='周二';
        break;
        case 3: week='周三';
        break;
        case 4: week='周四';
        break;
        case 5: week='周五';
        break;
        case 6: week='周六';
        break;
    }
    document.write(week);
}

// 数字时钟
function timeClock(){
    var date = new Date();
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var seconds = date.getSeconds();
    var showHours = hours<10 ? `0${hours}`: hours;
    var showMinutes = minutes<10 ? `0${minutes}`: minutes;
    var showSeconds = seconds<10 ? `0${seconds}`: seconds;
    document.getElementById('timeClock').innerHTML=`${showHours}:${showMinutes}:${showSeconds}`;
}

// 本月日历
function calender(){
    // 判断闰年
    function isLeap(year) {
        return year % 4 == 0 ? (year % 100 != 0 ? 1 : (year % 400 == 0 ? 1 : 0)) : 0;
    }
    var i, k;
        //获取日期
        today = new Date();
        y = today.getFullYear();
        m = today.getMonth();
        d = today.getDate();
        //获取第一天
        firstday = new Date(y, m, 1);
        //判断第一天星期
        dayOfWeek = firstday.getDay();
        //月份数组
        days_per_month = new Array(31, 28 + isLeap(y), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
        //确定日期表格行数
        str_nums = Math.ceil((dayOfWeek + days_per_month[m]) / 7);
        // document.write("<thead>📅本月日历📅</thead>");
        document.write("<table cellspacing='0'><tr><td colspan ='7'>"+ '本月日历📅' + + y + "年" + (m + 1) + "月" + "</td></tr>");
        document.write("<tr><th>日</th><th>一</th><th>二</th><th>三</th><th>四</th><th>五</th><th>六</th></tr>");
    //创建日期表格
    for(i = 0; i < str_nums; i += 1) { 
        document.write('<tr>');
        for(k = 0; k < 7; k++) {
            //为表格创建索引
            var idx = 7 * i + k;
            //第一天与星期匹配
            var date = idx - dayOfWeek + 1; 
            //空表格代替
            (date <= 0 || date > days_per_month[m]) ? date = ' ': date = idx - dayOfWeek + 1; 
            //高亮显示当天
            date == d ? document.write('<td style="color: red;">' + date + '</td>') : document.write('<td>' + date + '</td>');
        }
        document.write('</tr>');
    }
    document.write('</table>');
}