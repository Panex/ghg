<?php

/**
 * @param $pages
 * 总页码数
 * @param $showPage
 * 当前页码
 * @param int $length
 * 页码栏长度，默认9
 * @return null|string
 * 返回页码字符串
 */
function flipBar($pages, $showPage, $length = 9)
{
    //正在展示的页码不能小于等于0；
    //总页码数必须大于0；
    //页码长度必须大于等5
    //正在展示的页码不能小于总页码数；
    //echo "-pages=" . $pages . "-showPage=" . $showPage . "-length=" . $length;
    if ($pages <= 0 || $showPage <= 0 || $length < 5 || $showPage > $pages) {
        echo "内容为空";
        return null;
    }

    $half = ceil($length / 2);

    //上一页Tag
    $prevPage = $showPage - 1;
    $prevTag = specialTag(($prevPage > 0), $prevPage, "上一页");

    //首页Tag
    $firstTag = specialTag(!($showPage == 1), 1, 1);

    $otherTag = "";

    //其他Tag
    //总页码数小于等于页码长度时,不显示“...”
    if ($pages <= $length && $pages > 2) {
        for ($i = 2; $i < $pages; $i++) {
            $otherTag .= specialTag(!($i == $showPage), $i, $i);
        }
    }
    else if ($pages > $length) {//总页码大于页码长度时

        //当前页小于等于一半长度时，只显示右方的"..."
        if ($showPage <= $half) {
            for ($i = 2; $i <= $length - 2; $i++) { //从2到长度-2区间的都需要显示
                $otherTag .= otherTag($i, $showPage);
            }
            $otherTag .= "<a href='js:void(0)' pageStatus='dots'>...</a>";//显示右方的"..."
        } //当前页大于（总页数-一半的长度）时，只显示前方的"..."
        elseif ($showPage > ($pages - $half)) {
            $otherTag .= "<a href='js:void(0)' pageStatus='dots'>...</a>";//显示前方的"..."

            for ($i = ($pages - $length + 3); $i <= ($pages - 1); $i++) {
                $otherTag .= otherTag($i, $showPage);
            }
        }
        else {//其他时候为当前页在中间的情况
            $otherTag .= "<a href='js:void(0)' pageStatus='dots'>...</a>";//前"..."

            //调整标志，若页码长度为偶数时，若当前页码小于总页数的一半，则显示在较前的位置，否则显示在较后的位置
            $adjust = ($showPage <= $pages / 2 && $length % 2 == 0) ? 1 : 0;

            for ($i = ($showPage - $half + 2 + $length % 2 + $adjust); $i < ($showPage + $half - 2 + $adjust); $i++) {
                $otherTag .= otherTag($i, $showPage);
            }

            $otherTag .= "<a href='js:void(0)' pageStatus='dots'>...</a>";//后"..."
        }
    }

    //尾页Tag
    $lastTag = "";
    if ($pages > 1) {//如果总页数大于1，才固定显示最后一页
        $lastTag = specialTag(!($showPage == $pages), $pages, $pages);
    }

    //下一页Tag
    $nextPage = $showPage + 1;
    $nextTag = specialTag(($nextPage <= $pages), $nextPage, "下一页");

    //todo 添加跳页功能
    $pageInput = "<input type='number'>";
    $pageBtn = "<button>跳转</button>";
    return $prevTag . $firstTag . $otherTag . $lastTag . $nextTag . $pageInput . $pageBtn;

}

/**
 * @param $i
 * 标签页码与标签名
 * @param $showPage
 * 当前页
 * @return string
 */
function otherTag($i, $showPage)
{
    if ($i == $showPage) {
        $otherStatus = "disabled";
        $otherHref = "js:void(0)";
    }
    else {
        $otherStatus = "enabled";
        $otherHref = "#comments_top";
    }
    return "<a href='$otherHref' onclick='flip(this)' page='$i' pageStatus='$otherStatus'>$i</a>";
}

/**
 * 当条件为真时，生成可点击的标签，否则生成不可点击的标签
 * @param $term
 * 条件
 * @param $page_no
 * 页码
 * @param $page_text
 * 页码文字
 * @return string
 * 返回生成的标签
 *
 */
function specialTag($term, $page_no, $page_text)
{
    if ($term) {
        $status = "enabled";
        $href = "#comments_top";
    }
    else {
        $status = "disabled";
        $href = "js:void(0)";
    }
    return "<a href='$href' onclick='flip(this)' page='$page_no' pageStatus='$status'>$page_text</a>";
}

