<?php
/**
 * @ide         PhpStorm.
 * @author:     Panex
 * @datetime:   2016-11-1 19:06
 * @version:    0.1
 * @function:   生成页码，并给页码添加链接
 */

/**
 * @param int $pages 总页码数
 * @param int $showPage 当前显示的页码数
 * @param string $url 链接规则
 * @param int $length 页码栏长度
 * @return string 页码字符串
 */
function paging($pages, $showPage, $url = "", $length = 9)
{
    //正在展示的页码不能小于等于0；
    //总页码数必须大于0；
    //页码长度必须大于等5
    //正在展示的页码不能大于总页码数；
    if ($pages <= 0 || $showPage <= 0 || $length < 5 || $showPage > $pages) {
        return "暂无内容";
    }

    //向下取整，获得中间的位置
    $half = ceil($length / 2);

    //上一页Tag
    $prevPage = $showPage - 1;
    $prevTag = specialTag(($prevPage > 0), $prevPage, $showPage, "Prev", $url);

    //首页Tag
    $firstTag = specialTag(!($showPage == 1), 1, $showPage, 1, $url);

    $otherTag = "";

    //其他Tag
    //总页码数小于等于页码长度时,不显示“...”
    if ($pages <= $length && $pages > 2) {
        for ($i = 2; $i < $pages; $i++) {
            $otherTag .= specialTag(!($i == $showPage), $i, $showPage, $i, $url);
        }
    }
    else if ($pages > $length) {//总页码大于页码长度时

        //当前页小于等于一半长度时，只显示右方的"..."
        if ($showPage <= $half) {
            for ($i = 2; $i <= $length - 2; $i++) { //从2到长度-2区间的都需要显示
                $otherTag .= otherTag($i, $showPage, $url);
            }
            $otherTag .= "<a href='js:void(0)' pageStatus='dots'>...</a>";//显示右方的"..."
        } //当前页大于（总页数-一半的长度）时，只显示前方的"..."
        elseif ($showPage > ($pages - $half)) {
            $otherTag .= "<a href='js:void(0)' pageStatus='dots'>...</a>";//显示前方的"..."

            for ($i = ($pages - $length + 3); $i <= ($pages - 1); $i++) {
                $otherTag .= otherTag($i, $showPage, $url);
            }
        }
        else {//其他时候为当前页在中间的情况
            $otherTag .= "<a href='js:void(0)' pageStatus='dots'>...</a>";//前"..."

            //调整标志，若页码长度为偶数时，若当前页码小于总页数的一半，则显示在较前的位置，否则显示在较后的位置
            $adjust = ($showPage <= $pages / 2 && $length % 2 == 0) ? 1 : 0;

            for ($i = ($showPage - $half + 2 + $length % 2 + $adjust); $i < ($showPage + $half - 2 + $adjust); $i++) {
                $otherTag .= otherTag($i, $showPage, $url);
            }

            $otherTag .= "<a href='js:void(0)' pageStatus='dots'>...</a>";//后"..."
        }
    }

    //尾页Tag
    $lastTag = "";
    if ($pages > 1) {//如果总页数大于1，才固定显示最后一页
        $lastTag = specialTag(!($showPage == $pages), $pages, $showPage, $pages, $url);
    }

    //下一页Tag
    $nextPage = $showPage + 1;
    $nextTag = specialTag(($nextPage <= $pages), $nextPage, $showPage, "Next", $url);

    //todo 页面跳转按钮
//    $pageInput = "<input type='number' class='paging_input'>";
//    $pageBtn = "<button class='paging_btn'>跳转</button>";
    return $prevTag . $firstTag . $otherTag . $lastTag . $nextTag; //. $pageInput . $pageBtn;

}

/**
 * @param string $i 页码上显示的文字
 * @param int $showPage 当前显示的页码
 * @param string $url 页码跳转的链接
 * @return string 返回一个页码
 */
function otherTag($i, $showPage, $url = "")
{
    if ($i == $showPage) {
        $otherStatus = "current";
        $otherHref = "js:void(0)";
    }
    else {
        $otherStatus = "enabled";
        $otherHref = $url . $i;
    }
    return "<a href='$otherHref' pageStatus='$otherStatus'>$i</a>";
}

/**
 * 当条件为真时，生成可点击的标签，否则生成不可点击的标签
 * @param bool $term 条件
 * @param int $page_no 页码
 * @param int $showPage 当前所在页的页码
 * @param string $page_text 页码文字
 * @param string $url 页码跳转的链接
 * @return string 返回生成的标签
 */
function specialTag($term, $page_no, $showPage, $page_text, $url = "")
{
    $href = "";
    $status = "";
    if ($term) {
        $status = "enabled";
        $href = $url . $page_no;
    }
    else if ($page_no == $showPage) {
        $status = "current";
        $href = "js:void(0)";
    }
    else {
        $status = "disabled";
        $href = "js:void(0)";
    }
    return "<a href='$href' pageStatus='$status'>$page_text</a>";
}

