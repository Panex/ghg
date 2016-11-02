/**
 * Created by Panex on 2016-10-18.
 *
 * the basic method set/get/delete of cookie
 * escape方法需要替换，否则可能造成问题
 * escape已被删除，使用它cookie无法保存
 */

function setCookie(name, value, days) {
    var exp = new Date();
    exp.setTime(exp.getTime() + days * 24 * 60 * 60 * 1000);
    // console.log(exp.toUTCString());
    document.cookie = name + "=" + value + ";expires=" + exp.toUTCString();
}

function getCookie(name) {
    var arr, reg = new RegExp("(^|)" + name + "=([^;]*)(;|$)");
    if (arr = document.cookie.match(reg))
        return arr[2];
    else return null;
}

function deleteCookie(name) {
    var exp = new Date();
    exp.setTime(exp.getTime() - 1);
    var cval = getCookie(name);
    if (cval != null) {
        document.cookie = name + "=" + cval + ";expires=" + exp.toUTCString();
    }
}